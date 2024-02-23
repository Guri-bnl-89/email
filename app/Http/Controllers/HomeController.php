<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailList;
use DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $csv_file_info = "SELECT COUNT(email) as t_email,
        (SELECT COUNT(email) FROM email_lists WHERE status = 'valid' AND user_id = '$user_id') AS 'count_valid',
        (SELECT COUNT(email) FROM email_lists WHERE status = 'invalid' AND user_id = '$user_id') AS 'count_invalid',
        (SELECT COUNT(email) FROM email_lists WHERE status = 'catch all' AND user_id = '$user_id') AS 'count_catchall',
        (SELECT COUNT(email) FROM email_lists WHERE status = 'unknown' AND user_id = '$user_id') AS 'count_unknown'
        FROM email_lists WHERE user_id = '$user_id' ";
        $csv_info = DB::select($csv_file_info);
        $csv_result = $csv_info[0];
        if(!empty($csv_result)){ 
            $account['total_emails'] = $csv_result->t_email;
            $account['valid'] = $csv_result->count_valid;
            $account['invalid'] = $csv_result->count_invalid;
            $account['catchall'] = $csv_result->count_catchall;
            $account['unknown'] = $csv_result->count_unknown;
        }
        return view('pages.dashboard')->with(compact('account'));
    }

    public function reportsChartData(Request $request)
    {
        $chartData = [];
        if(!empty($request->type)){
            $unknown_data = $catchall_data = $invalid_data = $valid_data = [];
            $user_id = auth()->user()->id;
            switch ($request->type){
                case 'today':
                    $valid = EmailList::select(DB::raw('count(email) as total'), 'created_at')->where('user_id', $user_id)->where('status', 'valid')->whereDate('created_at', Carbon::today())->groupBy('created_at')->get()->toarray();
                    $invalid = EmailList::select(DB::raw('count(email) as total'), 'created_at')->where('user_id', $user_id)->where('status', 'invalid')->whereDate('created_at', Carbon::today())->groupBy('created_at')->get()->toarray();
                    $catchall = EmailList::select(DB::raw('count(email) as total'), 'created_at')->where('user_id', $user_id)->where('status', 'catch all')->whereDate('created_at', Carbon::today())->groupBy('created_at')->get()->toarray();
                    $unknown = EmailList::select(DB::raw('count(email) as total'), 'created_at')->where('user_id', $user_id)->where('status', 'unknown')->whereDate('created_at', Carbon::today())->groupBy('created_at')->get()->toarray();
                    break;
                case 'month':
                    $valid = EmailList::select(DB::raw('count(email) as total'), 'created_at')->where('user_id', $user_id)->where('status', 'valid')->whereMonth('created_at', Carbon::now())->groupBy('created_at')->get()->toarray();
                    $invalid = EmailList::select(DB::raw('count(email) as total'), 'created_at')->where('user_id', $user_id)->where('status', 'invalid')->whereMonth('created_at', Carbon::now())->groupBy('created_at')->get()->toarray();
                    $catchall = EmailList::select(DB::raw('count(email) as total'), 'created_at')->where('user_id', $user_id)->where('status', 'catch all')->whereMonth('created_at', Carbon::now())->groupBy('created_at')->get()->toarray();
                    $unknown = EmailList::select(DB::raw('count(email) as total'), 'created_at')->where('user_id', $user_id)->where('status', 'unknown')->whereMonth('created_at', Carbon::now())->groupBy('created_at')->get()->toarray();
                    break;
                case 'year':
                    $valid = EmailList::select(DB::raw('count(email) as total'), 'created_at')->where('user_id', $user_id)->where('status', 'valid')->whereYear('created_at', Carbon::now())->groupBy('created_at')->get()->toarray();
                    $invalid = EmailList::select(DB::raw('count(email) as total'), 'created_at')->where('user_id', $user_id)->where('status', 'invalid')->whereYear('created_at', Carbon::now())->groupBy('created_at')->get()->toarray();
                    $catchall = EmailList::select(DB::raw('count(email) as total'), 'created_at')->where('user_id', $user_id)->where('status', 'catch all')->whereYear('created_at', Carbon::now())->groupBy('created_at')->get()->toarray();
                    $unknown = EmailList::select(DB::raw('count(email) as total'), 'created_at')->where('user_id', $user_id)->where('status', 'unknown')->whereYear('created_at', Carbon::now())->groupBy('created_at')->get()->toarray();
                    break;
            }
            
            foreach($valid as $vRval){
                $valid_data[] = ['x' =>$vRval['created_at'], 'y' =>$vRval['total']]; 
            }
            
            foreach($invalid as $inRval){
                $invalid_data[] = ['x' =>$inRval['created_at'], 'y' =>$inRval['total']]; 
            }
            
            foreach($catchall as $chRval){
                $catchall_data[] = ['x' =>$chRval['created_at'], 'y' =>$chRval['total']]; 
            }
            
            foreach($unknown as $uRval){
                $unknown_data[] = ['x' =>$uRval['created_at'], 'y' =>$uRval['total']]; 
            }

            $chartData[] = [
                'name' => 'Valid',
                'data' =>$valid_data
            ];  
            $chartData[] = [
                'name' =>'Invalid',
                'data' =>$invalid_data
            ];
            $chartData[] = [
                'name' =>'Catch All',
                'data' =>$catchall_data
            ];
            $chartData[] = [
                'name' =>'Unknown',
                'data' =>$unknown_data
            ];
        }

        return response()->json($chartData);
    }

    public function orders_list()
    {
        return view('pages.order_management');
    }

    public function front_home()
    {
        return view('pages.front_home');
    }

    public function front_about()
    {
        return view('pages.front_about');
    }

    public function front_pricing()
    {
        return view('pages.front_pricing');
    }

    public function front_contact()
    {
        return view('pages.front_contact');
    }
    
}
