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

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/back/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/back/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ asset('assets/back/css/style.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/back/css/jquery.dataTables.min.css') }}" rel="stylesheet">
</head>

<body>
    @include('layouts.topbar')
    @include('layouts.sidebar')

    @yield('content')

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
        &copy; Copyright. All Rights Reserved
        </div>
    
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/back/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/back/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/back/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/back/vendor/echarts/echarts.min.js') }}"></script>
    
    <!-- Template Main JS File -->
    <script src="{{ asset('assets/back/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/back/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/back/js/main.js') }}"></script>
    @stack('cust_scripts')

</body>

</html>
