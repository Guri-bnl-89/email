@extends('home.layouts.app')

@section('content')

<!--hero section start-->

<section class="position-relative">
  <div id="particles-js" style="z-index: -1;"></div>
  <div class="container">
    <div class="row align-items-center">
      <div class="col-12 col-lg-5 col-lg-6 order-lg-1 mb-8 mb-lg-0">
        <!-- Image -->
        <!-- <img src="assets/front/images/bg/home_email_gif.gif" class="img-fluid"> -->

        <!-- Video -->
        <video class="img-fluid" autoplay="autoplay" loop="loop" muted="" playsinline="">
          <br>
          <source src="assets/front/images/bg/home_email1.mp4" type="video/mp4">
          <br>
        </video>

      </div>
      <div class="col-12 col-lg-7 col-xl-6">
        <!-- Heading -->
        <h1 class="display-4">
            Trustworthy Connections Begin with <span class="text-primary">Validated Emails!</span> 
        </h1>
        <!-- Text -->
        <p class="lead text-muted">Elevate your inbox experience with precise email validation, ensuring accuracy at every input</p>
        <!-- Buttons --> 
        <a href="{{ route('register') }}" class="btn btn-primary shadow me-1">
        Get Started
              </a>
        
      </div>
    </div>
  </div>
</section>

<!--hero section end--> 


<!--body content start-->

<div class="page-content">

<!--feature start-->

<section class="text-center p-0">
  <div class="container">
    <div class="row justify-content-center text-center">
      <div class="col-12 col-md-12 col-lg-8 mb-8 mb-lg-0">
        <div class="mb-8"> 
          <h2 class="mt-3">Test our email validator and see the results!</h2>
          <p class="lead mb-0">Experience the speed and accuracy - simply type it in and get the result in seconds!</p>
        </div>
      </div>
    </div>


    <div class="row justify-content-center">
      <div class="col-12 col-md-12 col-lg-8 justify-content-center">
        <div class="form-container">
          <form class="form-inline ">
            <input type="email" class="form-control m-2 form-cont-input" placeholder="email@example.com" id="email">
            <button id="btn-verify" type="button" class="btn btn-outline-light m-2 form-cont-button">Verify</button>
            <!-- 🎯  -->
          </form>
        </div>
      </div>
    </div> 

    <div class="row justify-content-center form-cont-result" id="result">
      <div class="col-8 text-center">
        <div id="result_loader" class="spinner-border d-none" role="status">
          <span class="sr-only">Loading...</span>
        </div>

        <div class="row mt-4">
          <div id="result_email_box" class="col-12 alert alert-secondary">
            <strong id="result_email">email@example.com</strong>
          </div>
        </div>

        <div class="row">
          <div id="result_message_box" class="col-12 alert alert-light">
            Result Summary
          </div>
        </div>

        <div class="row">
            <table id="tbl-result" class="table table-bordered">
              <tbody>
                <tr>
                <th>STATUS</th>
                <th>REMARKS</th>
                </tr>
                <tr>
                  <td><span id="result_status" class="badge badge-light">NA</span></td>
                  <td><span id="result_remarks" class="badge badge-light">NA</span></td>
                </tr>
              </tbody>
            </table>
        </div>
        
      </div>
    </div> 


  </div>
</section>

<!--feature end-->

<!--services start-->

<section class="custom-pt-1 custom-pb-2 bg-primary position-relative" data-bg-img="assets/front/images/bg/02.png">
  <div class="container">
    <div class="row">

      <div class="col-md-4 text-white">
        <div class="text-center px-5"> 
          <span class="badge badge-primary-soft p-2 my-5">
                  <i class="la la-cubes ic-7x rotation text-light"></i>
              </span>
          <h3 class="my-3 fw-bold">Best Email Validation Service</h3>
          <p class="text-light">Empower your marketing with online email list cleaning!</p>

          <ul class="list-unstyled ms-2">
              <li class="my-2"><i class="me-3 la la-check-circle"></i>Made with&nbsp;<i class="ti-heart"></i>&nbsp;by engineers</li>
              <li class="my-2"><i class="me-3 la la-check-circle"></i>Your data security is our priority</li>
          </ul>
          
        </div>
      </div>

      <div class="col-md-8">
        <div class="row">
          <div class="col-md-6">
            <div class="rounded p-4">
              <div class="d-flex align-items-center mb-4">
                <div class="me-3">
                  <i class="la la-check-square ic-3x text-light"></i>
                </div>
                <h5 class="m-0 text-light">Accuracy Guarantee</h5>
              </div>
              <p class="mb-0 text-light">We pride ourselves on delivering unparalleled accuracy in email validation.</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="rounded p-4">
              <div class="d-flex align-items-center mb-4">
                <div class="me-3">
                  <i class="la la-stopwatch ic-3x text-light"></i>
                </div>
                <h5 class="m-0 text-light">Swift Real-Time Validation</h5>
              </div>
              <p class="mb-0 text-light">Choose us for instant results with our Real-Time Email Verification.</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="rounded p-4">
              <div class="d-flex align-items-center mb-4">
                <div class="me-3">
                  <i class="la la-mail-bulk ic-3x text-light"></i>
                </div>
                <h5 class="m-0 text-light">Bulk Cleaning</h5>
              </div>
              <p class="mb-0 text-light">Our Bulk Email List Cleaning solution is designed to handle large datasets with precision.</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="rounded p-4">
              <div class="d-flex align-items-center mb-4">
                <div class="me-3">
                  <i class="la la-network-wired ic-3x text-light"></i>
                </div>
                <h5 class="m-0 text-light">Trustworthy Connectivity</h5>
              </div>
              <p class="mb-0 text-light">Choose us for trustworthy connections.</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="rounded p-4">
              <div class="d-flex align-items-center mb-4">
                <div class="me-3">
                  <i class="la la-hand-holding-usd ic-3x text-light"></i>
                </div>
                <h5 class="m-0 text-light">Cost-Effective</h5>
              </div>
              <p class="mb-0 text-light">Choose us for cost-effective email validation solutions.</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="rounded p-4">
              <div class="d-flex align-items-center mb-4">
                <div class="me-3">
                  <i class="la la-globe ic-3x text-light"></i>
                </div>
                <h5 class="m-0 text-light">World Wide</h5>
              </div>
              <p class="mb-0 text-light">We provide email list validation to marketers from all countries.</p>
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </div>
    <div class="shape-1" style="height: 150px; overflow: hidden;">
    <svg viewBox="0 0 500 150" preserveAspectRatio="none" style="height: 100%; width: 100%;">
      <path d="M0.00,49.98 C150.00,150.00 271.49,-50.00 500.00,49.98 L500.00,0.00 L0.00,0.00 Z" style="stroke: none; fill: #fff;"></path>
    </svg>
  </div>
  <div class="shape-1 bottom" style="height: 200px; overflow: hidden;">
    <svg viewBox="0 0 500 150" preserveAspectRatio="none" style="height: 100%; width: 100%;">
      <path d="M0.00,49.98 C150.00,150.00 349.20,-50.00 500.00,49.98 L500.00,150.00 L0.00,150.00 Z" style="stroke: none; fill: #fff;"></path>
    </svg>
  </div>
</section>

<!--services end-->

<!-- start-->
<section class="pt-0">

  <div class="container">

      <div class="row justify-content-center text-center">
        <div class="col-12 col-md-12 col-lg-8 mb-8 mb-lg-0">
          <div class="mb-8"> 
            <h2 class="mt-3">How We Clean Your Mailing List</h2>
            <p class="lead mb-0">With Clean Email List Build Email Sender Reputation</p>
          </div>
        </div>
      </div>

      <div class="row justify-content-center mailing-services">
          <div class="col-lg-4 col-sm-6">
              <div class="p-6 text-center">
                  <i class="ti-split-h app_icon mailing-services-icon"></i>
                  <h5 class="my-3">Email Deduplication</h5>
                  <p>Clears duplicate emails present instantly and saves you from landing
                      in recipients spam box</p>
              </div>
          </div>
          <div class="col-lg-4 col-sm-6">
              <div class="p-6 text-center">
                  <i class="ti-text app_icon mailing-services-icon"></i>
                  <h5 class="my-3">Syntax Validation</h5>
                  <p>Incorrect email formats are inevitable during list collection or
                      generation by data teams</p>
              </div>
          </div>
          <div class="col-lg-4 col-sm-6">
              <div class="p-6 text-center">
                  <i class="ti-shield app_icon mailing-services-icon"></i>
                  <h5 class="my-3">Spamtrap Removal</h5>
                  <p>Our system indicates potentially unsafe emails and helps you avoid
                      costly sender blacklist</p>
              </div>
          </div>
          <div class="col-lg-4 col-sm-6">
              <div class="p-6 text-center">
                  <i class="ti-exchange-vertical app_icon mailing-services-icon"></i>
                  <h5 class="my-3">SMTP Verification</h5>
                  <p>Multiple advanced real-time checks are done to verify the existence
                      of the domain, email account</p>
              </div>
          </div>
          <div class="col-lg-4 col-sm-6">
              <div class="p-6 text-center">
                  <i class="ti-calendar app_icon mailing-services-icon"></i>
                  <h5 class="my-3">Disposable Email Check</h5>
                  <p>Keep your email list fresh by cleaning all emails matching our
                      database of temporary email services</p>
              </div>
          </div>
          <div class="col-lg-4 col-sm-6">
              <div class="p-6 text-center">
                  <i class="ti-magnet app_icon mailing-services-icon"></i>
                  <h5 class="my-3">Catch-All Check</h5>
                  <p>Our intelligent system identifies in real-time accept-all domains and
                      saves you from hard bounces later</p>
              </div>
          </div>
          <div class="col-lg-4 col-sm-6">
              <div class="p-6 text-center">
                  <i class="ti-widget app_icon mailing-services-icon"></i>
                  <h5 class="my-3">Anti-Greylisting</h5>
                  <p>Our system deploys the latest anti-greylisting technology that helps
                      you to reduce the number of unknowns</p>
              </div>
          </div>
          <div class="col-lg-4 col-sm-6">
              <div class="p-6 text-center">
                  <i class="ti-world app_icon mailing-services-icon"></i>
                  <h5 class="my-3">Domain Verification</h5>
                  <p>Our system checks and validates the DNS entries of email addresses
                      and helps identify the invalid/ misspelled or inactive domains</p>
              </div>
          </div>
          <div class="col-lg-4 col-sm-6">
              <div class="p-6 text-center">
                  <i class="ti-search app_icon mailing-services-icon"></i>
                  <h5 class="my-3">List Quality Analysis</h5>
                  <p>Once bouncify completes the verification, you will get the email list
                      quality analysis report of your uploaded email list</p>
              </div>
          </div>
      </div>
  </div>

</section>

<!-- End -->

<!--counter start-->

<section class="text-center p-0">
  <div class="container">
    <div class="row justify-content-center text-center">
      <div class="col-12 col-md-12 col-lg-8 mb-8 mb-lg-0">
        <div class="mb-8"> 
          <h2 class="mt-3">Over 1200+ <br> completed work & Still counting.</h2>
        </div>
      </div>
    

      <div class="counter-items mb-5">
        <div class="counter-inner-items ">
          <div class="text">
            <div class="counter one count-number" data-to="693" data-speed="10000"> 693 </div>
            <p> Happy Clients </p>
            </div>
          </div>

          <div class="counter-inner-items ">
            <div class="text">
              <div class="counter two count-number" data-to="453" data-speed="10000"> 453 </div>
              <p> Trusted Users </p>
            </div>
          </div>

          <div class="counter-inner-items ">
            <div class="text">
              <div class="counter three count-number" data-to="276" data-speed="10000"> 276 </div>
              <p> Projects </p>
            </div>
          </div>

          <div class="counter-inner-items  last">
            <div class="text">
              <div class="counter four count-number" data-to="93" data-speed="10000"> 93 </div>
              <p> Awards </p>
            </div>
        </div>
      </div>

    </div>

  </div>
</section>

<!--counter end-->

<!--about start-->

<section>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-md-12 col-lg-8 justify-content-center">
        <div class="form-container custom-box-shadow">
          <h6 class="text-light mx-2 my-0">Subscribe Our Newsletter</h6>
          <form class="form-inline ">
            <input type="email" class="form-control m-2 form-cont-input" placeholder="Email Address" id="email">
            <button id="btn-verify" type="button" class="btn btn-outline-light m-2 form-cont-button">Subscribe</button>
          </form>
        </div>
      </div>
    </div> 

  </div>
</section>

<!--about end-->


</div>

<!--body content end--> 
@endsection