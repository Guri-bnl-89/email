<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>{{config('app.title')}}</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!--Favicon-->
  <link rel="icon" href="{{ asset('assets/front/images/favicon.png') }}" type="image/x-icon">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/back/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/back/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

</head>

<body>
  <section class="py-3 py-md-5 min-vh-100 d-flex justify-content-center align-items-center">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="text-center">
            <h2 class="d-flex justify-content-center align-items-center gap-2 mb-4">
              <span class="display-1 text-primary fw-bold">4</span>
              <i class="bi bi-exclamation-circle-fill text-primary display-4"></i>
              <span class="display-1 text-primary fw-bold bsb-flip-h">4</span>
            </h2>
            <h3 class="h2 mb-2">Oops! You're lost.</h3>
            <p class="mb-5">The page you are looking for was not found.</p>
            <a class="btn bsb-btn-5xl btn-primary rounded-pill px-5 fs-6 m-0" href="{{ route('home') }}" role="button">Back to Home</a>
          </div>
        </div>
      </div>
    </div>
  </section>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/back/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

</body>

</html>
