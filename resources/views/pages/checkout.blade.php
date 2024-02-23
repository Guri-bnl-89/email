@extends('layouts.app')

@section('content')

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Checkout</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Checkout</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>  
  @endif

  <section class="section profile">
    <div class="row profile-overview">
      <div class="col-xl-7">
<?php
  $user = auth()->user();
?>
        <div class="card">
          <div class="card-body ">
            <h5 class="card-title pt-0">Billing Information</h5>
                <!-- Profile Edit Form -->
                <form method="POST" action="{{ route('profile') }}">
                @csrf
                  <input name="user_edit" type="hidden" value="1">
                  <div class="row mb-3">
                    <label for="fullName" class="col-md-4 col-lg-3 label">First Name</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="name" type="text" class="form-control" id="fullName" value="{{ old('name',$user->name) }}" required>
                      @error('name')
                          <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="surName" class="col-md-4 col-lg-3 label">Last Name</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="surname" type="text" class="form-control" id="surName" value="{{ old('surname',$user->surname) }}">
                      @error('surname')
                          <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="Country" class="col-md-4 col-lg-3 label">Country</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="country" type="text" class="form-control" id="Country" value="{{ old('country',$user->country) }}" required>
                      @error('country')
                          <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="Address" class="col-md-4 col-lg-3 label">Address</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="address" type="text" class="form-control" id="Address" value="{{ old('address',$user->address) }}" required>
                      @error('address')
                          <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="Phone" class="col-md-4 col-lg-3 label">Phone</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="phone" type="tel" class="form-control" id="Phone" value="{{ old('phone', $user->phone) }}" required>
                      @error('phone')
                          <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="Email" class="col-md-4 col-lg-3 label">Email</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="email" type="email" class="form-control" id="Email" value="{{ old('email', $user->email) }}" required>
                      @error('email')
                          <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>

                  <div class="text-start pt-3">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-save2"></i> Save Changes</button>
                  </div>
                </form><!-- End Profile Edit Form -->  
          </div>
        </div>

      </div>

      <div class="col-xl-5">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title pt-0">Order Summary</h5>

            

              <div class="row">
                <div class="col-lg-3 col-md-4 label">Credits</div>
                <div class="col-lg-9 col-md-8 label text-dark">{{ number_format($plan->credits) }}</div>
              </div>

              <div class="row">
                <div class="col-lg-3 col-md-4 label">Amount</div>
                <div id="price-wrap" class="col-lg-9 col-md-8 label text-dark">${{$plan->price}}</div>
              </div>

              <div class="row">
                <div class="col-lg-3 col-md-4 label"> Offer Code </div>
                <div class="col-lg-9 col-md-8">
                  <div class="input-group">
                    <input type="hidden" id="get-id" value="{{ $plan->id }}">
                    <input type="text" id="cuppon-code" class="form-control rounded-start" placeholder="Enter Offer Code" aria-label="Enter Offer Code" aria-describedby="cuppon-button">
                    <button class="btn btn-primary" type="button" id="cuppon-button">Apply</button>
                  </div>
                  <div id="code-status"></div>
                </div>
              </div>

              <h5 class="card-title">Payment Methods </h5>
              
              <div class="row">
                <div class="col-lg-12">
                  <input type="radio" class="form-check-input" name="payment_type" value="razorpay">
                  <img class="ms-2" src="{{ asset('assets/back/img/razorpay.png') }}" alt="razorpay" height="30px">
                </div>
              </div>

              <div class="row">
                <div class="col-lg-12">
                  <input type="radio" class="form-check-input" name="payment_type" value="paypal">
                  <img class="ms-2" src="{{ asset('assets/back/img/paypal.png') }}" alt="paypal" height="30px">
                </div>
              </div>

              <div class="text-start pt-3">
                <button type="button" id="proceed-pay" class="btn btn-sm btn-primary"><i class="bi bi-credit-card"></i> Proceed to Pay</button>
              </div>
              <div id="pay-status"></div>

          </div>
        </div>

      </div>
    </div>
  </section>

</main>
@endsection

@push('cust_scripts')
  <script>
    $(document).ready(function() {

      $('#cuppon-button').on('click', function() {
        var cuppon_code = $('#cuppon-code').val();
        var get_id = $('#get-id').val();
        if(cuppon_code != ''){
          $.ajax({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              url : '/discount',
              data: {code:cuppon_code, pid:get_id} ,
              type : 'POST',
              dataType : 'json',
              success : function(response){
                  console.log(response);
                  if(response.status == 'success'){
                    var price_string = '$ '+response.final_price+'&nbsp; &nbsp;<span class="text-decoration-line-through text-danger">$ '+response.price+'</span>';
                    $('#price-wrap').html(price_string); 
                    var string = '<span class="text-success"><i class="bi bi-check-circle-fill"></i>&nbsp;'+response.message+'</span>';
                  } else {
                    var string = '<span class="text-danger"><i class="bi bi-x-circle-fill"></i>&nbsp;'+response.message+'</span>';
                  }   
                  $('#code-status').html(string);                   
              }
          });
        } else {
          $("#cuppon-code").focus();
          var string = '<span class="text-danger"><i class="bi bi-x-circle-fill"></i>&nbsp;Please enter offer code.</span>';
          $('#code-status').html(string); 
        }
      });

      $('#proceed-pay').on('click', function() {
        var cuppon_code = $('#cuppon-code').val();
        var get_id = $('#get-id').val();
        var payment_type = $("input[name='payment_type']:checked").val();
        if(payment_type){
          $.ajax({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              url : '/createOrder',
              data: {code:cuppon_code, pid:get_id, ptype:payment_type} ,
              type : 'POST',
              dataType : 'json',
              success : function(response){
                  console.log(response);
                  if(response.status == 'success'){
                    if(response.type == 'razorpay'){                      
                      var options = {
                                      "key": "{{ env('RAZORPAY_KEY_ID') }}",
                                      "order_id": response.transaction_id,
                                      "handler": function (response) {
                                          window.location.href = "/orders";
                                      },
                                    };
                      var razorpayon = new Razorpay(options);
                      razorpayon.open();
                    }

                    if(response.type == 'paypal'){
                    }

                  } else {
                    var string = '<span class="text-danger">'+response.message+'</span>';
                  }   
                  $('#code-status').html(string);                   
              }
          });
        } else {
          var string = '<span class="text-danger">Please select a payment method.</span>';
          $('#pay-status').html(string); 
        }
      });

    });

  </script>
  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
@endpush