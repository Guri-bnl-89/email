@extends('home.layouts.app')

@section('content')

<!--hero section end--> 


<!--body content start-->

<div class="page-content">

<!--login start-->

<section class="register">
  <div class="container">
    <div class="row justify-content-center text-center">
      <div class="col-lg-8 col-md-12">
        <div class="mb-6"> 
        <span class="badge badge-primary-soft p-2">
                  <i class="la la-exclamation ic-3x rotation"></i>
              </span>
          <h2 class="mt-3">Create a free account</h2>
          <p class="lead">EmailValidation can be used for free, forever. </p>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-5 col-md-10 ms-auto me-auto">
        <button type="button" class="btn btn-outline-primary btn-block" id="google-btn">
          <img alt="Google" src="assets/front/images/logo/google_icon.png" height="20" class="pe-1">
          Sign up with Google
        </button>
        <div class="signup-or">
          <span>OR</span>
        </div>
        <div class="register-form text-center">
            <form method="POST" action="{{ route('register') }}" id="register-form">
            @csrf
            @php 
              $show = false;
            @endphp
            @if($errors->any())
            @php 
              $show = true;
            @endphp
            @endif
            <!-- <div class="messages">
            @if($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
@endif
              @if(!empty($message))
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @endif
            </div> -->
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <input id="form_email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" required="required" data-error="Valid email is required." value="{{ old('email') }}">
                  @error('email')
                    <span class="email-error help-block with-errors" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>
              
            </div>
            <div class="row show-hide-reg {{ $show ? '' : 'd-none'}}">
              <div class="col-md-6">
                <div class="form-group">
                  <input id="form_name" type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="First name" required="required" data-error="Firstname is required." value="{{ old('name') }}">
                  @error('name')
                    <span class="name-error help-block with-errors" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <input type="text" name="surname" class="form-control" placeholder="Last name" value="{{ old('surname') }}">
                </div>
              </div>
            </div>
            
            <div class="row show-hide-reg {{ $show ? '' : 'd-none'}}">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="input-group">
                    <input id="form_password" type="password"  name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" aria-label="Password" data-error="Password is required." required="required" aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondary" type="button" id="button-addon2"><i class="la la-eye-slash"></i></button>
                  </div>
                  @error('password')
                    <span class="password-error help-block with-errors" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>             
            </div>

            <div class="row show-hide-reg mt-5 {{ $show ? '' : 'd-none'}}">
              <div class="col-md-12">
                <div class="form-group clearfix mb-5 d-inline-block">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="check-pp">
                    <label class="form-check-label" for="check-pp">I agree to the term of use and privacy policy</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <button class="btn btn-primary btn-block {{ $show ? 'd-none': ''}}" id="continue-button" type="button">Continue</button>
                <button class="btn btn-primary btn-block {{ $show ? '' : 'd-none'}}" id="submit-button" type="button">Create Account</button>
              </div>
            </div>
          </form>

          <div class="row">
              <div class="col-md-12">
                <span class="mt-4 d-block">Have An Account ? <a href="{{ route('login') }}"><i>Sign In!</i></a></span>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!--login end-->

</div>

<!--body content end--> 
@endsection

@push('after_scripts')
  <script src="{{ asset('assets/front/js/register.js') }}"></script>
@endpush
