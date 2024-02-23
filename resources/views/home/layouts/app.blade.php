<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

  <!-- ** Basic Page Needs ** -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{config('app.title')}}</title>

  <!--== bootstrap -->
  <link href="{{ asset('assets/front/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />

  <!--== animate -->
  <link href="{{ asset('assets/front/css/animate.css') }}" rel="stylesheet" type="text/css" />

  <!--== line-awesome -->
  <link href="{{ asset('assets/front/css/line-awesome.min.css') }}" rel="stylesheet" type="text/css" />

  <!--== themify-icons -->
  <link href="{{ asset('assets/front/css/themify-icons.css') }}" rel="stylesheet" type="text/css" />

  <!--== spacing -->
  <link href="{{ asset('assets/front/css/spacing.css') }}" rel="stylesheet" type="text/css" />

  <!--== theme.min -->
  <link href="{{ asset('assets/front/css/theme.min.css') }}" rel="stylesheet" />

  <link href="{{ asset('assets/front/css/style.css') }}" rel="stylesheet" />

  <!-- inject css end -->
  
  <!--Favicon-->
  <link rel="icon" href="{{ asset('assets/front/images/favicon.png') }}" type="image/x-icon">

</head>

<body>

<!-- page wrapper start -->

<div class="page-wrapper">
  
<!-- preloader start -->

<div id="ht-preloader">
  <div class="loader clear-loader">
    <span></span>
    <p>EmailValidation</p>
  </div>
</div>

<!-- preloader end -->


<!--header start-->

<header class="site-header">
  <div id="header-wrap">
    <div class="container">
      <div class="row">
        <!--menu start-->
        <div class="col"> 
          <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand logo text-dark h2 mb-0" href="{{ route('front') }}">
              Email<span class="text-primary fw-bold">Validation</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav ms-auto">
                <li class="nav-item"> 
                  <a class="nav-link {{ Request::is('front') || Request::is('/') ? 'active' : '' }}" href="{{ route('front') }}">Home</a>          
                </li>
                <li class="nav-item"> 
                  <a class="nav-link {{ Request::is('about-us') ? 'active' : '' }}" href="{{ route('about-us') }}">About Us</a>          
                </li>
                <li class="nav-item"> 
                  <a class="nav-link {{ Request::is('pricing') ? 'active' : '' }}" href="{{ route('pricing') }}">Pricing</a>          
                </li>
                <li class="nav-item"> 
                  <a class="nav-link {{ Request::is('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>          
                </li>
                @guest
                <li class="nav-item"> 
                  <a class="nav-link {{ Request::is('login') ? 'active' : '' }}" href="{{ route('login') }}">Login</a>          
                </li>
                @endguest
               
              </ul>
              @guest
                <div class="my-2 my-md-0 ml-lg-4 text-center">
                  <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                </div>
              @else
                <div class="my-2 my-md-0 ml-lg-4 text-center">
                  <a href="{{ route('login') }}" class="btn btn-primary">Dashboard</a>
                </div>
              @endguest
            </div>
          </nav>  
        </div>
        <!--menu end-->
      </div>
    </div>
  </div>
</header>

<!--header end-->

    @yield('content')

   
<!--footer start-->

<footer class="py-11 bg-primary position-relative" data-bg-img="assets/front/images/bg/03.png">
  <div class="shape-1" style="height: 150px; overflow: hidden;">
    <svg viewBox="0 0 500 150" preserveAspectRatio="none" style="height: 100%; width: 100%;">
      <path d="M0.00,49.98 C150.00,150.00 271.49,-50.00 500.00,49.98 L500.00,0.00 L0.00,0.00 Z" style="stroke: none; fill: #fff;"></path>
    </svg>
  </div>
  <div class="container mt-7">
    <div class="row">
      <div class="col-12 col-lg-5 col-xl-4 me-auto mb-6 mb-lg-0">
        <div class="subscribe-form p-5">
          <div>
            <a class="footer-logo text-white h4 mb-0" href="{{ route('front') }}">
            Email<span class="fw-bold">Validation</span>
            </a>
          </div>
          <p class="text-light pt-2">We recognize the pivotal role that accurate email data plays in establishing effective and trustworthy communication. Our mission is to provide advanced email validation solutions that go beyond just verification, ensuring your digital interactions are not only efficient but built on a foundation of reliability.</p>
          
        </div>
      </div>
      <div class="col-12 col-lg-6 col-xl-7">
        <div class="row">
          <div class="col-12 col-sm-4 navbar-dark">
            <h5 class="mb-4 text-white">Pages</h5>
            <ul class="navbar-nav list-unstyled mb-0">
              <li class="mb-3 nav-item"><a class="nav-link" href="{{ route('about-us') }}">About</a>
              </li>
              <li class="mb-3 nav-item">
                <a class="nav-link" href="{{ route('features') }}">Features</a>
              </li>

              <li class="mb-3 nav-item"><a class="nav-link" href="{{ route('blog') }}">Blogs</a>
              </li>
              <li class="mb-3 nav-item"><a class="nav-link" href="{{ route('contact') }}">Contact Us</a>
              </li>
              <li class="mb-3 nav-item"><a class="nav-link" href="{{ route('pricing') }}">Pricing</a>
              </li>

              <li class="nav-item"><a class="nav-link" href="{{ route('faqs') }}">Faq</a>
              </li>
            </ul>

          </div>
          <div class="col-12 col-sm-4 mt-6 mt-sm-0 navbar-dark">
          <h5 class="mb-4 text-white">Legal</h5>
            <ul class="navbar-nav list-unstyled mb-0">
              <li class="mb-3 nav-item">
                <a class="nav-link" href="{{ route('tos') }}">Term Of Service</a>
              </li>
              <li class="mb-3 nav-item">
                <a class="nav-link" href="{{ route('privacy') }}">Privacy Policy</a>
              </li>
              <li class="mb-3 nav-item">
                <a class="nav-link" href="{{ route('data-policy') }}">Data Policy</a>
              </li>
              <li class="mb-3 nav-item">
                <a class="nav-link" href="{{ route('cookie-policy') }}">Cookie Policy</a>
              </li>
              <li class="mb-3 nav-item">
                <a class="nav-link" href="{{ route('refund-policy') }}">Refund Policy</a>
              </li>
              <li class="mb-3 nav-item">
                <a class="nav-link" href="{{ route('gdpr-policy') }}">GDPR Compliance</a>
              </li>
              
            </ul>
          </div>
          <div class="col-12 col-sm-4 mt-6 mt-sm-0 navbar-dark">
          <h5 class="mb-4 text-white">Alternatives</h5>
            <ul class="navbar-nav list-unstyled mb-0">              
              <li class="mb-3 nav-item">
                <a class="nav-link" href="{{ route('zerobounce-alternative') }}">Zerobounce Alternative</a>
              </li>
              <li class="mb-3 nav-item">
                <a class="nav-link" href="{{ route('neverbounce-alternative') }}">NeverBounce Alternative</a>
              </li>
              <li class="mb-3 nav-item">
                <a class="nav-link" href="{{ route('xverify-alternative') }}">Xverify Alternative</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('briteverify-alternative') }}">BriteVerify Alternative</a>
              </li>
              
            </ul>
          </div>
        </div>
        <div class="row mt-5">
          <div class="col-12 col-sm-6">
            <a class="footer-logo text-white h2 mb-0" href="{{ route('front') }}">
            Email<span class="fw-bold">Validation</span>
            </a>
          </div>
          <div class="col-12 col-sm-6 mt-6 mt-sm-0">
            <ul class="list-inline mb-0">
              <li class="list-inline-item"><a class="text-light ic-2x" href="#"><i class="la la-facebook"></i></a>
              </li>
              <li class="list-inline-item"><a class="text-light ic-2x" href="#"><i class="la la-dribbble"></i></a>
              </li>
              <li class="list-inline-item"><a class="text-light ic-2x" href="#"><i class="la la-instagram"></i></a>
              </li>
              <li class="list-inline-item"><a class="text-light ic-2x" href="#"><i class="la la-twitter"></i></a>
              </li>
              <li class="list-inline-item"><a class="text-light ic-2x" href="#"><i class="la la-linkedin"></i></a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="row text-white text-center mt-2">
      <div class="col">
      <hr class="mb-2">Copyright @php echo date("Y"); @endphp | All Rights Reserved</div>
    </div>
  </div>
</footer>


<!--footer end-->

</div>

<!-- page wrapper end -->

 
<!--back-to-top start-->

<div class="scroll-top"><a class="smoothscroll" href="#top"><i class="las la-angle-up"></i></a></div>

<!--back-to-top end-->

<!-- inject js start -->

<script src="{{ asset('assets/front/js/theme-plugin.js') }}"></script>
<script src="{{ asset('assets/front/js/theme-script.js') }}"></script>
@stack('after_scripts')
<!-- inject js end -->

</body>

</html>
