@extends('home.layouts.app')

@section('content')

<!--body content start-->

<div class="page-content">

<!--login start-->

<section>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-5">
        <div>
        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
          <div class="text-center mb-5">
            <h2>Forgot your password?</h2>
          <p>Enter your email to reset your password.</p>
          </div>
          <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="messages"></div>
            <div class="form-group">
                <label>Email Address</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email" required autocomplete="email" autofocus>

                @error('email')
                    <div class="help-block with-errors">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary btn-block">
                {{ __('Send Password Reset Link') }}
            </button>
           
           
          </form>
          <div class="mt-4 text-center">
                   <a class="link-title" href="{{ route('login') }}">Back to sign in</a>
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