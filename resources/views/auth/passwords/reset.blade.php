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
          <h2 class="text-center mb-3">Reset Password</h2>
          <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    <label for="email">{{ __('Email Address') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <div class="help-block with-errors">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" >{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                    @error('password')
                    <div class="help-block with-errors">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password-confirm" >{{ __('Confirm Password') }}</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                </div>

                <button class="btn btn-primary btn-block" type="submit">Reset Password</button> 
                
            </form>
          
        </div>
      </div>
    </div>
  </div>
</section>

<!--login end-->

</div>
<!--body content end--> 
@endsection