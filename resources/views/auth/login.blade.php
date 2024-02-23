@extends('home.layouts.app')

@section('content')

<!--body content start-->

<div class="page-content">

<!--login start-->

<section>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-5">
        <div>
          <h2 class="text-center mb-3">Sign In</h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="messages"></div>
                <div class="form-group">
                    <label>{{ __('Email Address') }}</label>
                    <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email" />
                                            
                    @error('email')
                        <div class="help-block with-errors">{{ $message }}</div>
                    @enderror 
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                    @error('password')
                        <div class="help-block with-errors">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mt-4 mb-5">
                    <div class="remember-checkbox d-flex align-items-center justify-content-between">
                        <div class="form-check mb-0">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label mb-0" for="flexCheckDefault">Remember Me</label>
                        </div>
                        <a href="{{ route('password.request') }}">Forgot Password?</a>
                    </div>
                </div> 
                <button class="btn btn-primary btn-block" type="submit">Login Now</button>           
           
          </form>
          <div class="d-flex align-items-center text-center justify-content-center mt-4">
                  <span class="text-muted me-1">Don't have an account?</span>
                   <a href="{{ route('register') }}">Sign Up</a>
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