@extends('home.layouts.app')

@section('content')

<!--body content start-->

<div class="page-content">

<section>
  <div class="container">
    <div class="row justify-content-center mb-7 text-center">
      <div class="col-12 col-lg-8">
        <div>
          <h2 class="mb-0">Contact Us</h2>
          <p class="lead mb-0">Communication begins here – we're just a click away.</p>
        </div>
      </div>
    </div>
    
    <div class="row text-center">
      
      <div class="col-lg-3 col-md-6">
        <div class="px-3">
          <div class="icon-main">
              <img src="assets/front/images/bg/05.png" alt="">
              <div class="icon-sub">
                  <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="#1360ef" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
              </div>
          </div>
          <h4 class="mt-5 mb-3">Chat with Us</h4>
          <a href="#" class="badge rounded-pill text-bg-primary py-2 px-3">Live Chat</a>
          <p class="my-3">For any queries please chat with us during business hours</p>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="px-3">
          <div class="icon-main">
              <img src="assets/front/images/bg/05.png" alt="">
              <div class="icon-sub">
              <svg class="feather feather-mail" xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="#1360ef" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
              </div>
          </div>
          <h4 class="mt-5 mb-3">Send a Message</h4>
          <a href="mailto:emailvalidation@contact.com"> emailvalidation@contact.com</a>
          <p class="my-3">For sale queries please send an email and our team will respond quickly.</p>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="px-3">
          <div class="icon-main">
            <img src="assets/front/images/bg/05.png" alt="">
            <div class="icon-sub">
              <svg class="feather feather-phone-call" xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="#1360ef" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M15.05 5A5 5 0 0 1 19 8.95M15.05 1A9 9 0 0 1 23 8.94m-1 7.98v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
            </div>
          </div>
          <h4 class="mt-5 mb-3">Talk to Us</h4>
          <a href="tel:+912345678900">+91-234-567-8900</a>
          <p class="my-3">Mon - Sat: 9am - 6pm IST</p>
        </div>
      </div>
      
      <div class="col-lg-3 col-md-6">
        <div class="px-3">
          <div class="icon-main">
            <img src="assets/front/images/bg/05.png" alt="">
            <div class="icon-sub">
              <svg class="feather feather-map-pin" xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="#1360ef" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>              
            </div>
          </div>
          <h4 class="mt-5 mb-3">Office</h4>
         <a href="#">Address</a>
         <p class="my-3">423B, Road Wordwide Country, USA</p>
        </div>
      </div>

    </div>
  </div>

</section>

<section class="pt-0">
  <div class="container">
    
    <div class="row justify-content-center text-center">
      <div class="col-12 col-lg-8">
          <form id="contact-form" class="row" method="post" action="#">
            <div class="messages"></div>
            <div class="form-group col-md-6">
              <input id="form_name" type="text" name="name" class="form-control" placeholder="First Name" required="required" data-error="Name is required.">
              <div class="help-block with-errors"></div>
            </div>
            <div class="form-group col-md-6">
              <input id="form_name1" type="text" name="name" class="form-control" placeholder="Last Name" required="required" data-error="Last Name is required.">
              <div class="help-block with-errors"></div>
            </div>
            <div class="form-group col-md-12">
              <input id="form_email" type="email" name="email" class="form-control" placeholder="Email" required="required" data-error="Valid email is required.">
              <div class="help-block with-errors"></div>
            </div>
            <div class="form-group col-md-12">
              <input id="form_subject" type="text" name="subject" class="form-control" placeholder="Subject" required="required" data-error="Subject is required.">
              <div class="help-block with-errors"></div>
            </div>        
            
            <div class="form-group col-md-12">
              <textarea id="form_message" name="message" class="form-control" placeholder="Message" rows="3" required="required" data-error="Please,leave us a message." style="height: 150px;"></textarea>
              <div class="help-block with-errors"></div>
            </div>
            <div class="col-md-12 text-center mt-4">
              <button class="btn btn-primary"><span>Send Messages</span>
              </button>
            </div>
          </form>
    </div>
    </div>
    
  </div>
</section>



</div>

<!--body content end--> 
@endsection