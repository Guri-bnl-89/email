<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailList;
use App\Models\EmailCategories;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class VerificationController extends Controller
{
    public function list()
    {
        //
        return view('pages.list_validation');
    }


    public function listData()
    {
        $user_id = auth()->user()->id;
        $items = EmailList::select('file_name')->where('user_id', $user_id)->groupBy('file_name')->orderBy('file_name', 'desc')->get();
        if(!$items->isEmpty()){
            foreach($items as $akey=>$item){
                $csv_file_info = "SELECT COUNT(email) as t_email, MIN(created_at) as create_time,
                    (SELECT COUNT(email) FROM email_lists WHERE file_name = '$item->file_name' AND status = 'inprocess' AND user_id = '$user_id') AS 'count_inprocess',
                    (SELECT COUNT(email) FROM email_lists WHERE file_name = '$item->file_name' AND status = 'valid' AND user_id = '$user_id') AS 'count_valid',
                    (SELECT COUNT(email) FROM email_lists WHERE file_name = '$item->file_name' AND status = 'invalid' AND user_id = '$user_id') AS 'count_invalid',
                    (SELECT COUNT(email) FROM email_lists WHERE file_name = '$item->file_name' AND status = 'catch all' AND user_id = '$user_id') AS 'count_catchall',
                    (SELECT COUNT(email) FROM email_lists WHERE file_name = '$item->file_name' AND status = 'unknown' AND user_id = '$user_id') AS 'count_unknown'                
                    FROM email_lists WHERE file_name = '$item->file_name' AND user_id = '$user_id' ";
                $csv_info = DB::select($csv_file_info);
                foreach($csv_info as $csv_result){
                    $accounts[$akey]['id'] = $akey+1;
                    $accounts[$akey]['file_name'] = $item->file_name;
                    $accounts[$akey]['total_email'] = $csv_result->t_email;
                    $accounts[$akey]['create_time'] = $csv_result->create_time;
                    $accounts[$akey]['count_valid'] = $csv_result->count_valid;
                    $accounts[$akey]['count_invalid'] = $csv_result->count_invalid;
                    $accounts[$akey]['count_catchall'] = $csv_result->count_catchall;
                    $accounts[$akey]['count_unknown'] = $csv_result->count_unknown;
                    $accounts[$akey]['count_valid_per'] = '('.$this->calculatePercentage($csv_result->count_valid, $csv_result->t_email).'%)';
                    $accounts[$akey]['count_invalid_per'] = '('.$this->calculatePercentage($csv_result->count_invalid, $csv_result->t_email).'%)';
                    $accounts[$akey]['count_catchall_per'] = '('.$this->calculatePercentage($csv_result->count_catchall, $csv_result->t_email).'%)';
                    $accounts[$akey]['count_unknown_per'] = '('.$this->calculatePercentage($csv_result->count_unknown, $csv_result->t_email).'%)';

                    if($csv_result->count_inprocess > 0){
                        $accounts[$akey]['job_status'] = 'inprocess';
                    } else {
                        $accounts[$akey]['job_status'] = 'completed';
                    }                    
                }

            }
            $userData['data'] = $accounts;
        } else {
            $userData['data'] = [];
        }
        return $userData;
    }

    function calculatePercentage($count, $total){
        $percentage = round ($count * 100 / $total); 
        return $percentage;
    }
    
    public function emailVerifyRequest(Request $request) {     
        set_time_limit(0);
        $array_data = $request->email;
        $filename = $request->filename;
        $filesize = $request->filesize ? $request->filesize : 0;
        $user_id = $request->uid;
        $data_arr = array_filter(explode (",",$array_data));
        $status = "inprocess";
        $duplicate = 0;
        $save = 0;
        $total = count($data_arr);
        $str_arr = array_unique($data_arr);
        $count_after_uniq = count($str_arr);
        $duplicate = $total - $count_after_uniq;
        $save = $total - $duplicate;
        $userData = User::select('id','credits')->where('id', $user_id)->first();
        if($userData->credits >= $save){
          $balanceCredits = $userData->credits - $save;
          $userData->credits = $balanceCredits;
          $userData->save();

          $data = [];
          foreach ($str_arr as $email) {
              if(!empty($email)){
                  $now = Carbon::now();
                  $data[] = ['user_id' => $user_id, 'file_name' => $filename, 'email' => $email, 'status' => $status, 'created_at' => $now, 'updated_at' => $now];
              }
          }
          if(!empty($data)){
              EmailList::insert($data);

              // Add recode in task table for future use if job stooped
              Task::create([
                  'user_id' => $user_id,
                  'file_name' => $filename,
                  'file_size' => $filesize,
                  'total_recodes' => $total,
                  'duplicate_recodes' => $duplicate,
              ]);

          }
          echo json_encode(['status' => 'success', 'save' => $save, 'total' => $total, 'duplicate' => $duplicate]);
        } else {
          $message = "<div class='text-danger'><b>Insufficient Credits:</b> You do not have enough credits to verify the email addresses.</div><div class='mt-2'>Please <a href='purchase'>Click Here</a> to add more credits.</div>";
          echo json_encode(['status' => 'error', 'message' => $message]);
        }
        die;       
    }

    public function validateEmailsRequest(Request $request) {        
        set_time_limit(0);
        ini_set('max_execution_time', '0');
        ini_set('request_terminate_timeout', '0');
        ini_set('fastcgi_read_timeout', '0');
        
        global $debug;
        $debug=env("JOB_DEBUG");

        $count_valid = 0;
        $count_catch_all = 0;
        $count_unknown = 0;
        $count_invalid = 0;
        $count_syntax_error = 0;
        $count_disponsable_acc = 0;
        $count_free_acc = 0;
        $count_role_acc = 0;
        $filename = $request->filename;
        $user_id = $request->uid;

        // Task find and update the status initialize to inprocess
        $task_id = '';
        $task = Task::select('id')->where('user_id', $user_id)->where('file_name', $filename)->first();
        if(!empty($task->id)){
          $task_id = $task->id;
          $task->status = 'inprocess';
          $task->save();
        }

        $this->OutputDebug("JOB STARTED. Task id:". $task_id);
        
        // Get all emails for varify the emails
        $all_emails = EmailList::select('id','email')->where('user_id', $user_id)->where('file_name', $filename)->where('status', 'inprocess')->get();
        if(!$all_emails->isEmpty()){
          foreach($all_emails as $ekey=>$eVal){
            $email_id = $eVal->id;
            $toemail = $eVal->email;
            $safe_to_send = '';
            $email_score = '';
            $bounce_type = '';
            $email_account = '';
            $email_domain = '';
            $email_type = '';
            $validation_status_code = '0';

            // Validate email
            if (filter_var($toemail, FILTER_VALIDATE_EMAIL)) {
              $toemail = filter_var($toemail, FILTER_SANITIZE_EMAIL);
              $email_arr = explode('@', $toemail);
              $email_account = $email_arr[0];
              $email_domain = $email_arr[1];
              $catch_all_status = '';
              $emailCategory = EmailCategories::select('mail_type','catch_all')->where('name', $email_account)->orWhere('name', $email_domain)->first();
              if($emailCategory){
                $email_type = $emailCategory->mail_type;
                $catch_all_status = $emailCategory->catch_all;
                $trim_email_type = trim($email_type);
                if($trim_email_type == 'Free Account'){
                    $count_free_acc++;
                }elseif($trim_email_type == 'Disposable Account'){
                    $count_disponsable_acc++;
                }elseif($trim_email_type == 'Role Account'){
                    $count_role_acc++;
                }

                if($catch_all_status != '0'){
                  $random_str = Str::random(10);
                  $catch_mail = $random_str.'@'.$email_domain;
                  $result = $this->ValidateEmailBox($catch_mail);
                  if($result[0] == 1){
                    $validation_status_code = 'Catch-All mail server';
                    $result = array(2,$validation_status_code);
                  }else{
                    if($result[1] == 0 ){
                      $result=$this->ValidateEmailBox($toemail);
                    }
                  }
                }else{
                  $result=$this->ValidateEmailBox($toemail);
                }
              }else{
                $result=$this->ValidateEmailBox($toemail);
              }
            }else{
              $count_syntax_error++;
              $validation_status_code = 'syntax error';
              $result = array(0,$validation_status_code);
            }

            if($result[0]<0){
              $count_unknown++;
              $email_verify_result = 'unknown';
              if($result[1] == '0'){
                $email_verify_status = 'Mail server error';
              }else{
                $email_verify_status = $result[1];
              }
            } elseif ($result[0] == 2) {
              $count_catch_all++;
              $email_verify_result = 'catch all';
              $email_verify_status = $result[1];
            } else{
              if($result[0] == 1){
                $count_valid++;
                $email_verify_result = 'valid';
                $email_verify_status = 'success';
              }else{
                $count_invalid++;
                $email_verify_result = 'invalid';
                if($result[1] == '0'){
                  $email_verify_status = 'mail box not found';
                }else{
                  $email_verify_status = $result[1];
                }
              }
            }
            if($email_verify_result == 'valid'){
              $safe_to_send = 'Yes';
              $email_score = 1;
            }elseif($email_verify_result == 'catch all'){
              $safe_to_send = 'Risky';
              $email_score = 0.5;
            }else{
              $safe_to_send = 'NO';
              $email_score = 0;
              $bounce_type = 'hard';
            }

            // Update email status
            $current_email = EmailList::find($email_id); 
            $current_email->status = $email_verify_result;
            $current_email->type = $email_type;
            $current_email->safe_to_send = $safe_to_send;
            $current_email->response = $email_verify_status;
            $current_email->score = $email_score;
            $current_email->bounce_type = $bounce_type;
            $current_email->account = $email_account;
            $current_email->domain = $email_domain;
            $current_email->save();

          }
        } else {
          $this->OutputDebug("No email found for task id:".$task_id); 
        }
          
        $job_status = 'success';
        // On job finished task table update the status inprocess to completed
        if(!empty($task->id)){
          $task->status = 'completed';
          $task->save();
        }

        $this->OutputDebug("JOB COMPLETED. Task id:".$task_id);

        echo json_encode(['status' => $job_status]);
        die;       
    }

    public function validateSingleEmailRequest(Request $request) {        
        set_time_limit(0);
        ini_set('max_execution_time', '0');
        ini_set('request_terminate_timeout', '0');
        ini_set('fastcgi_read_timeout', '0');
        
        global $debug;
        $debug=env("JOB_DEBUG");
        $email_status = '';
        $email_score = '';
        $trim_email_type = '';
        $message = '';
        $toemail = $request->file;
        $user_id = $request->uid;

        $this->OutputDebug("SINGLE EMAIL VERIFICATION STARTED. Email id:". $toemail);
        
        if(!empty($toemail)){
          $save = 1;
          $userData = User::select('id','credits')->where('id', $user_id)->first();
          if($userData->credits >= $save){
            $balanceCredits = $userData->credits - $save;
            $userData->credits = $balanceCredits;
            $userData->save();
            
            $email_account = '';
            $email_domain = '';
            $email_type = '';
            $validation_status_code = '0';

            // Validate email
            if (filter_var($toemail, FILTER_VALIDATE_EMAIL)) {
              $toemail = filter_var($toemail, FILTER_SANITIZE_EMAIL);
              $email_arr = explode('@', $toemail);
              $email_account = $email_arr[0];
              $email_domain = $email_arr[1];
              $catch_all_status = '';
              $emailCategory = EmailCategories::select('mail_type','catch_all')->where('name', $email_account)->orWhere('name', $email_domain)->first();
              if($emailCategory){
                $email_type = $emailCategory->mail_type;
                $catch_all_status = $emailCategory->catch_all;
                $email_type_new = str_replace("Account","",$email_type);
                $email_lower = strtolower($email_type_new);
                $trim_email_type = trim($email_lower);

                if($catch_all_status != '0'){
                  $random_str = Str::random(10);
                  $catch_mail = $random_str.'@'.$email_domain;
                  $result = $this->ValidateEmailBox($catch_mail);
                  if($result[0] == 1){
                    $validation_status_code = 'Catch-All mail server';
                    $result = array(2,$validation_status_code);
                  }else{
                    if($result[1] == 0 ){
                      $result=$this->ValidateEmailBox($toemail);
                    }
                  }
                }else{
                  $result=$this->ValidateEmailBox($toemail);
                }
              }else{
                $result=$this->ValidateEmailBox($toemail);
              }
            }else{
              $validation_status_code = 'syntax error';
              $result = array(0,$validation_status_code);
            }

            if(!empty($result)){
              if($result[0]<0){
                $email_verify_result = 'unknown';
              } elseif ($result[0] == 2) {
                $email_verify_result = 'catch all';
              } else{
                if($result[0] == 1){
                  $email_verify_result = 'valid';
                }else{
                  $email_verify_result = 'invalid';
                }
              }

              if($email_verify_result == 'valid'){
                $email_status = 'Deliverable';
                $email_score = 1;
              }elseif($email_verify_result == 'catch all'){
                $email_status = 'Risky';
                $email_score = 0.5;
              }else{
                $email_status = 'Bounce';
                $email_score = 0;
              }
            }

            $job_status = 'success';
            
          }else {
            $message = "<div class='text-danger'><b>Insufficient Credits:</b> You do not have enough credits to verify the email address.</div><div class='mt-2'>Please <a href='purchase'>Click Here</a> to add more credits.</div>";
            $job_status = 'error';
          }

        } else {
          $job_status = 'error';
          $message = "<div class='text-danger'>No email found. Please try again.</div>";
          $this->OutputDebug("No email found"); 
        }

        $this->OutputDebug("SINGLE EMAIL JOB COMPLETED. Email id:".$toemail);

        echo json_encode(['status' => $job_status, 'message' => $message, 'email' => $toemail, 'email_status' => $email_status, 'email_score' => $email_score, 'email_type' => $trim_email_type]);
        die;       
    }

    function ValidateEmailBox($email)
    {
      global $debug;
      global $last_code;
      $formmail = env("FROM_EMAIL"); 
      $formmail = explode('@', $formmail);
      $localuser = $formmail[0];
      $localhost = $formmail[1];
      $smtp_validation=env("SMTP_VALIDATION");
      $data_timeout=0;
      $timeout = env("CONNECTION_TIMEOUT");
      $exclude_address="";
      $validation_status_code = '0';      

      $EMAIL_VALIDATION_STATUS_DOMAIN_NOT_FOUND = 'domain not found';
      $EMAIL_VALIDATION_STATUS_TEMPORARY_SMTP_REJECTION = 'temporary smtp rejection';
      $EMAIL_VALIDATION_STATUS_SMTP_DIALOG_REJECTION    = 'smtp dialog rejection';
      $EMAIL_VALIDATION_STATUS_SMTP_CONNECTION_FAILED   = 'smtp connection Failed';
      $EMAIL_VALIDATION_STATUS_validation_skip = 'SMTP validation skipped due to configuration';
      // ------------------------------------------------------------------------------------------------
      // Get the domain of the email recipient
      $email_arr = explode('@', $email);
      $domain = array_slice($email_arr, -1);
      $domain = $domain[0];


      // Trim [ and ] from beginning and end of domain string, respectively
      $domain = ltrim($domain, '[');
      $domain = rtrim($domain, ']');


      if ('IPv6:' == substr($domain, 0, strlen('IPv6:'))) {
        $domain = substr($domain, strlen('IPv6') + 1);
      }
      if($record_a = dns_get_record($domain, DNS_MX)){
        
        $pir = array_column($record_a, 'pri');
        $min_mxip = $record_a[array_search(min($pir), $pir)];
        $mx_ip = $min_mxip['target'];
      }else{
        $validation_status_code = $EMAIL_VALIDATION_STATUS_DOMAIN_NOT_FOUND;
        return array(0, $validation_status_code);
      }

      if(!empty($mx_ip)){
        if(empty($localhost)){
          $localhost="localhost";
        }
        if(empty($localuser)){
          $localuser="root";
        }
        $domain=$mx_ip;
        if(preg_match('/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/',$domain))
          $ip=$domain;
        else
        {
          if($debug){
            $this->OutputDebug("Resolving host name ".$mx_ip."...");
          }
          if(!strcmp($ip=@gethostbyname($domain),$domain))
          {
            if($debug){
              $this->OutputDebug("Could not resolve host name ".$mx_ip.".");
            }
          }
        }
        if(strlen($exclude_address) && !strcmp(@gethostbyname($exclude_address),$ip))
        {
          if($debug){
            $this->OutputDebug("Host address of ".$mx_ip." is the exclude address");
          }
        }
        if(!$smtp_validation)
        {
          if($debug){
            $this->OutputDebug("SMTP validation skipped due to configuration");
          }
          $validation_status_code = $EMAIL_VALIDATION_STATUS_validation_skip;
          return array(-1, $validation_status_code);
        }
        if($debug){
          $this->OutputDebug("Connecting to host address ".$ip."...");
        }
        if(($connection=($timeout ? @fsockopen($ip,25,$errno,$error,$timeout) : @fsockopen($ip,25))))
        { 
          $timeout=($data_timeout ? $data_timeout : $timeout);
          if($timeout && function_exists("socket_set_timeout")){
            socket_set_timeout($connection,$timeout,0);
          }
          if($debug){
            $this->OutputDebug("Connected.");
          }
          if($this->VerifyResultLines($connection,"220")>0
          && $this->PutLine($connection,"HELO $localhost")
          && $this->VerifyResultLines($connection,"250")>0
          && $this->PutLine($connection,"MAIL FROM: <".$localuser."@".$localhost.">")
          && $this->VerifyResultLines($connection,"250")>0
          && $this->PutLine($connection,"RCPT TO: <$email>")
          && ($result=$this->VerifyResultLines($connection,"250"))>=0)
          {
           
            if($result)
            {
              if($this->PutLine($connection,"DATA"))
                $result=($this->VerifyResultLines($connection,"354")!=0);
            }
            if(!$result)
            {
              if(strlen($last_code) && !strcmp($last_code[0],"4"))
              {
                $validation_status_code = $EMAIL_VALIDATION_STATUS_TEMPORARY_SMTP_REJECTION;
                $result=-1;
              }
            }
            else{
              $result = 1;
              $validation_status_code = '1';
            }

            return array($result, $validation_status_code);
          }
          if($debug){
            $email_debug = $this->OutputDebug("Unable to validate the address with this host.");
          }
          @fclose($connection);
          if($debug){
            $this->OutputDebug("Disconnected.");
          }
          $validation_status_code = $EMAIL_VALIDATION_STATUS_SMTP_DIALOG_REJECTION;
        }
        else
        {
          if($debug){
            $verify_result = $this->OutputDebug("Failed");
          }
          $validation_status_code = $EMAIL_VALIDATION_STATUS_SMTP_CONNECTION_FAILED;
        }
        return array(-1,$validation_status_code);
        // -----------------------------------------------------------------------------------------------------
      }else{
        $validation_status_code = $EMAIL_VALIDATION_STATUS_DOMAIN_NOT_FOUND;
        return array(0, $validation_status_code);
      }
    }

    function OutputDebug($message)
    {
      Log::channel('joblog')->info($message);
      return true;
    }

    function PutLine($connection,$line)
    {
      global $debug;
      if($debug){
        $this->OutputDebug("C $line");
      }
      return(@fputs($connection,"$line\r\n"));
    }

    function VerifyResultLines($connection,$code)
    {
      global $last_code;
      while(($line= $this->GetLine($connection)))
      {
        $end = strcspn($line, ' -');
        $last_code=substr($line, 0, $end);
        if(strcmp($last_code,$code)){
          return(0);
        }
        if(!strcmp(substr($line, strlen($last_code), 1)," ")){
          return(1);
        }
      }
      return(-1);
    }

    function GetLine($connection)
    {
      global $debug;
      for($line="";;)
      {
        if(@feof($connection)){
          return(0);
        }
        $line.=@fgets($connection,100);
        $length=strlen($line);
        if($length>=2 && substr($line,$length-2,2)=="\r\n")
        {
          $line=substr($line,0,$length-2);
          if($debug){
            $this->OutputDebug("S $line");
          }
          return($line);
        }
      }
    }

  function FileSizeConvert($bytes)
  {
    $bytes = floatval($bytes);
    $arBytes = array(
      0 => array(
          "UNIT" => "TB",
          "VALUE" => pow(1024, 4)
      ),
      1 => array(
          "UNIT" => "GB",
          "VALUE" => pow(1024, 3)
      ),
      2 => array(
          "UNIT" => "MB",
          "VALUE" => pow(1024, 2)
      ),
      3 => array(
          "UNIT" => "KB",
          "VALUE" => 1024
      ),
      4 => array(
          "UNIT" => "Bytes",
          "VALUE" => 1
      ),
    );

    foreach($arBytes as $arItem)
    {
      if($bytes >= $arItem["VALUE"])
      {
        $result = $bytes / $arItem["VALUE"];
        $result = strval(round($result, 2))." ".$arItem["UNIT"];
        break;
      }
    }
    return $result;
  }


    public function result(string $id)
    {
      $user_id = auth()->user()->id;
      $task = Task::where('user_id', $user_id)->where('file_name', $id)->first();
      $csv_file_info = "SELECT COUNT(email) as t_email, MIN(created_at) as create_time,
      (SELECT COUNT(email) FROM email_lists WHERE file_name = '$id' AND status = 'valid' AND user_id = '$user_id') AS 'count_valid',
      (SELECT COUNT(email) FROM email_lists WHERE file_name = '$id' AND status = 'invalid' AND user_id = '$user_id') AS 'count_invalid',
      (SELECT COUNT(email) FROM email_lists WHERE file_name = '$id' AND status = 'catch all' AND user_id = '$user_id') AS 'count_catchall',
      (SELECT COUNT(email) FROM email_lists WHERE file_name = '$id' AND status = 'unknown' AND user_id = '$user_id') AS 'count_unknown',
      -- (SELECT COUNT(email) FROM email_lists WHERE file_name = '$id' AND status = 'inprocess' AND user_id = '$user_id') AS 'count_not_verify',
      -- (SELECT COUNT(email) FROM email_lists WHERE file_name = '$id' AND response = 'syntax error' AND user_id = '$user_id') AS 'count_syntax',
      (SELECT COUNT(email) FROM email_lists WHERE file_name = '$id' AND type = 'Free Account' AND user_id = '$user_id') AS 'count_free',
      (SELECT COUNT(email) FROM email_lists WHERE file_name = '$id' AND type = 'Role Account' AND user_id = '$user_id') AS 'count_role',
      (SELECT COUNT(email) FROM email_lists WHERE file_name = '$id' AND type = 'Disposable Account' AND user_id = '$user_id') AS 'count_disposable'
      FROM email_lists WHERE file_name = '$id' AND user_id = '$user_id' ";
      $csv_info = DB::select($csv_file_info);
      $csv_result = $csv_info[0];
      if(!empty($task->id)){
        $account['id'] = $task->id;
        $account['file_name'] = $task->file_name;
        $account['file_size'] = ($task->file_size > 0 ? $this->FileSizeConvert($task->file_size) : 0 );
        $account['total_recodes'] = $task->total_recodes;
        $account['duplicate_recodes'] = $task->duplicate_recodes;
        $account['save_recodes'] = ($task->total_recodes - $task->duplicate_recodes);
        $account['status'] = $task->status;
      }
      if(!empty($csv_result)){ 
        // $account['create_time'] = $csv_result->create_time;
        $account['valid'] = $csv_result->count_valid;
        $account['invalid'] = $csv_result->count_invalid;
        $account['catchall'] = $csv_result->count_catchall;
        $account['unknown'] = $csv_result->count_unknown;
        //$account['not_verify'] = $csv_result->count_not_verify;
        //$account['syntax_error'] = $csv_result->count_syntax;
        $account['free'] = $csv_result->count_free;
        $account['role'] = $csv_result->count_role;
        $account['disposable'] = $csv_result->count_disposable;
        $account['valid_per'] = $this->calculatePercentage($csv_result->count_valid, $csv_result->t_email).'%';
        $account['invalid_per'] = $this->calculatePercentage($csv_result->count_invalid, $csv_result->t_email).'%';
        $account['catchall_per'] = $this->calculatePercentage($csv_result->count_catchall, $csv_result->t_email).'%';
        $account['unknown_per'] = $this->calculatePercentage($csv_result->count_unknown, $csv_result->t_email).'%';
        $account['free_per'] = $this->calculatePercentage($csv_result->count_free, $csv_result->t_email).'%';
        $account['role_per'] = $this->calculatePercentage($csv_result->count_role, $csv_result->t_email).'%';
        $account['disposable_per'] = $this->calculatePercentage($csv_result->count_disposable, $csv_result->t_email).'%';
      }
      // echo "<pre>";print_r($account);die;

      return view('pages.validation_result')->with(compact('account'));
    }

    public function downloadCsvFile(Request $request) {
      if(!empty($request->filename) && !empty($request->recodes)){
        $filename = $request->filename;
        $recodes = $request->recodes;
        $user_id = auth()->user()->id;

        $all_emails = EmailList::select('email','status','safe_to_send','response','score','bounce_type','type','account','domain')->where('user_id', $user_id)->where('file_name', $filename);
        switch($recodes){
          case 'valid':
          case 'invalid':
          case 'unknown':
              $all_emails = $all_emails->where('status', $recodes);
            break;
          case 'catchall':
              $all_emails = $all_emails->where('status', 'catch all');
            break;
          case 'free':
          case 'role':
          case 'disposable':
                $all_emails = $all_emails->where('type', ucfirst($recodes).' Account');
              break;
        }
        $allResults = $all_emails->get()->toArray();
        if(!empty($allResults)){
          $file_name = $filename . "_".$recodes.".csv"; //make a uniq id for csv file;
          header('Content-type:text/csv;charset=utf-8'); //declear content-type;
          header('Content-Disposition: attachment; filename=' . $file_name); //assign file name to csv file;
          echo "\xEF\xBB\xBF"; // BOM header UTF-8
          $file = fopen("php://output", "w"); //write to csv file;
          ob_clean();
          fputcsv($file, array('Email', 'Verification Status', 'Safe to send', 'Verification Response', 'Score', 'Bounce type', 'Account Type', 'Email Account', 'Email Domain')); //headers name
          foreach($allResults as $result) { //write data;
              fputcsv($file, $result);
          }
          fclose($file); //close file;
        } else {
          return back()->with('error', 'Something Went Wrong, Please Try Again!');
        }
      } else {
        return back()->with('error', 'Something Went Wrong, Please Try Again!');
      }
    }


    public function singleEmail()
    {
        return view('pages.lead_management');
    }



}
