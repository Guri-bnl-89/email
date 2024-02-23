@extends('layouts.app')

@section('content')
<main id="main" class="main">

<div class="pagetitle">
  <h1>Verify Single Email</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
      <li class="breadcrumb-item active">Verify Single Email</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<div class="alert alert-danger alert-dismissible d-none" id="alert-message-id">
  <span id="alert-message-span"></span>
  <button type="button" class="btn-close" id="alert-btn-close" aria-label="Close"></button>
</div>

<section class="section">
  <div class="row">
    

    <div class="col-lg-8">

      <div class="card">
        <div class="card-body">
          
              <h5 class="card-title p-0">Enter Email to Verify</h5>
              <p class="paragraph-text pt-2">Validation costs 1 credit per email.</p>
              <!-- <form method="post" action="#"> -->
                <div class="col-lg-10">
                  <input type="email" class="form-control" id="Email" placeholder="Please enter an email address" required>
                  <span class="upload-error text-danger fs-11"></span>
                </div>
                <div class="col-12 mt-3">
                  <button class="btn btn-sm btn-primary" id="verify-button" type="button" onclick="validateSingleEmail({{auth()->user()->id}})"><i class="bi bi-clipboard2-check"></i> Verify</button>
                  <button class="btn btn-sm btn-primary d-none loading-class" type="button" disabled=""><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>&nbsp;Loading... </button>
                </div>
              <!-- </form> -->
           

        </div>
      </div>

      
    </div>
    <div class="col-lg-4 ">
      <div class="alert alert-primary" role="alert">
        <h5 class="card-title py-0">Verification Result &nbsp;<span class="loading-class badge badge-pill bg-warning blink-icon text-white d-none">Inprocess</span></h5>
        
          <div id="verify-result" class="d-none">
            <p class="paragraph-text mb-1" id="email-id"></p>
            <h5 id="email-status"></h5>
            <div class="mt-1">
              <dl class="text-secondary">
                <dd class="mb-1"><span class="d-inline-block w-150">Score</span><span class="badge bg-secondary" id="email-score"></span></dd>
                <dd class="mb-1"><span class="d-inline-block w-150">Role based email</span><span class="badge bg-secondary email_role_type" id="email-role"></span></dd>
                <dd class="mb-1"><span class="d-inline-block w-150">Free email service</span><span class="badge bg-secondary email_role_type" id="email-free"></span></dd>
                <dd class="mb-1"><span class="d-inline-block w-150">Disposable email</span><span class="badge bg-secondary email_role_type" id="email-disposable"></span></dd>
              </dl>                
            </div>
          </div>
      </div>
    </div>


  </div>
</section>

</main><!-- End #main -->
@endsection

@push('cust_scripts')
  <script>
    $(document).ready(function() {
        $('#alert-btn-close').on('click', function() {
          $('#alert-message-id').addClass('d-none');
        });
    });
    function validateSingleEmail(userId){
      var email = $('#Email').val();
      if (email === '') {
        errorMsg('Please enter a valid email address.');
        return false;
      } else if (isEmail(email) === false) {
        errorMsg('Entered Email is not Valid!');
        return false;
      } else {

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url : '/validateSingleEmailRequest',
            data: {file:email, uid:userId} ,
            type : 'POST',
            dataType : 'json',
            beforeSend: function(){
              $('#verify-result').addClass('d-none');
              $('.loading-class').removeClass('d-none');
              $('#verify-button').addClass('d-none');
            },
            complete: function(){
              $('.loading-class').addClass('d-none');
              $('#verify-button').removeClass('d-none');
            },
            success : function(response){
                console.log(response);
                if(response.status == 'success'){
                  var string = '';
                  $('#verify-result').removeClass('d-none');
                  $('#email-id').text(email);
                  
                  $('#email-score').text(response.email_score);
                  $('.email_role_type').text('No');
                  $('#email-'+response.email_type).text('Yes');
                  if(response.email_status == 'Deliverable'){
                    string = '<span class="text-success"><i class="bi bi-check-circle-fill"></i>&nbsp;Deliverable</span>';  
                  }
                  if(response.email_status == 'Risky'){
                    string = '<span class="text-info"><i class="bi bi-info-circle-fill"></i>&nbsp;Risky</span>';  
                  }
                  if(response.email_status == 'Bounce'){
                    string = '<span class="text-danger"><i class="bi bi-x-circle-fill"></i>&nbsp;Bounce</span>';  
                  }
                  $('#email-status').html(string);
                } else {
                  $('#alert-message-span').html(response.message);
                  $('#alert-message-id').removeClass('d-none');
                }                       
            }
        });
      }
    }

    function isEmail(email) {
      const regex =/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      if (!regex.test(email)) {
          return false;
      } else {
          return true;
      }
    }

    function errorMsg(custText){
        $(".upload-error").text(custText);
        setTimeout(function() {
            $(".upload-error").text('');
        }, 5000); 
    }

  </script>
@endpush