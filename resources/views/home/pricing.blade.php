@extends('home.layouts.app')

@section('content')

<!--body content start-->

<div class="page-content">

<!--pricing start-->

<section>
  <div class="container">            
    <div class="row justify-content-center text-center">
      <div class="col-12 col-md-12 col-lg-8 mb-8 mb-lg-0">
        <div class="mb-8"> 
          <h2 class="mt-3">Best &amp; Lowest Price</h2>
          <p class="lead mb-0">Empower Your Marketing with Advanced Email List Cleaning Service!</p>
        </div>
      </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="job_listing">
                <div class="text-center text-success" >Get FLAT 5% OFF. Promo code <b>L68T11</b>. Limited time offer.</div>
                <div class="listing_tab">

                  <div class="list-items px-8 py-5">

                    <div class="row align-items-center justify-content-between list-in-item">
                      <div class="col-lg-8 list-title px-5">
                        <h6>
                          10,000 Verifications <span class="list-title-span" >$ 0.0019 per email verification</span>
                        </h6>
                      </div>
                      <div class="col-lg-4 px-5 list-price text-end">
                        <span class="">$19</span>
                      </div>
                    </div>
                    <hr>

                    <div class="row align-items-center justify-content-between list-in-item">
                      <div class="col-lg-8 list-title px-5">
                        <h6>
                          30,000 Verifications <span class="list-title-span" >$ 0.0013 per email verification</span>
                        </h6>
                      </div>
                      <div class="col-lg-4 px-5 list-price text-end">
                        <span class="">$39</span>
                      </div>
                    </div>
                    <hr>

                    <div class="row align-items-center justify-content-between list-in-item">
                      <div class="col-lg-8 list-title px-5">
                        <h6>
                          1,00,000 Verifications <span class="list-title-span" >$ 0.0010 per email verification</span>
                        </h6>
                      </div>
                      <div class="col-lg-4 px-5 list-price text-end">
                        <span class="">$99</span>
                      </div>
                    </div>
                    <hr>

                    <div class="row align-items-center justify-content-between list-in-item">
                      <div class="col-lg-8 list-title px-5">
                        <h6>
                          2,00,000 Verifications <span class="list-title-span" >$ 0.0007 per email verification</span>
                        </h6>
                      </div>
                      <div class="col-lg-4 px-5 list-price text-end">
                        <span class="">$149</span>
                      </div>
                    </div>
                    <hr>

                    <div class="row align-items-center justify-content-between list-in-item">
                      <div class="col-lg-8 list-title px-5">
                        <h6>
                          5,00,000 Verifications <span class="list-title-span" >$ 0.0006 per email verification</span>
                        </h6>
                      </div>
                      <div class="col-lg-4 px-5 list-price text-end">
                        <span class="">$279</span>
                      </div>
                    </div>
                    <hr>

                    <div class="row align-items-center justify-content-between list-in-item">
                      <div class="col-lg-8 list-title px-5">
                        <h6>
                        1 Million Verifications <span class="list-title-span" >$ 0.0005 per email verification</span>
                        </h6>
                      </div>
                      <div class="col-lg-4 px-5 list-price text-end">
                        <span class="">$479</span>
                      </div>
                    </div>
                    <hr>

                  </div>


                </div>

                <div class="text-center" >
                    <ul class="list-unstyled">
                        <li>For more than 1 Million verifications please
                            <a href="{{ route('contact') }}">contact</a>
                        </li>
                    </ul>
                </div>
                
            </div>

        </div>
        
        <div class="col-lg-6">
            <div class="ps-8">
                <h2 class="mb-3">Pay as you go plans</h2>
                <ul class="list-unstyled ms-2">
                    <li class="mb-3"><i class="text-primary me-3 ti-arrow-circle-right"></i>No monthly subscription</li>
                    <li class="mb-3"><i class="text-primary me-3 ti-arrow-circle-right"></i>Unused credits do not expire</li>
                    <li class="mb-3"><i class="text-primary me-3 ti-arrow-circle-right"></i>More verifications, better pricing</li>
                    <li class="mb-3"><i class="text-primary me-3 ti-arrow-circle-right"></i>Free list quality analysis</li>
                    <li class="mb-3"><i class="text-primary me-3 ti-arrow-circle-right"></i>Free duplicate removal</li>
                    <li class="mb-3"><i class="text-primary me-3 ti-arrow-circle-right"></i>For use with API and Bulk email verification</li>
                </ul>

                <a href="{{ route('register') }}" class="btn btn-primary mx-6 my-3">Signup</a>
                <ul class="list-unstyled ms-2">
                    <li class="mb-2"><i class="text-primary me-3 ti-control-record"></i>Get 100 verifications free</li>
                    <li class="mb-2"><i class="text-primary me-3 ti-control-record"></i>Instant activation</li>
                    <li class="mb-2"><i class="text-primary me-3 ti-control-record"></i>Credit card not required</li>
                    <li class="mb-2"><i class="text-primary me-3 ti-control-record"></i>Accepted payment methods</li>
                    <li class="mb-2"><i class="text-primary me-3 ti-control-record"></i>18% GST applicable</li>
                </ul>
            </div>
        </div>
    </div>
  </div>


</section>

<!--pricing end-->


<section class="pt-0">
  <div class="container">
    <div class="row align-items-center justify-content-center">
      <div class="col-12 col-md-12 col-lg-8 text-center">
        <div class="mb-8"> 
          <h2 class="mt-3">Frequently Asked Questions</h2>
        </div>
      </div>
    
      <div class="col-12 col-md-12 col-lg-8">
        <div class="accordion" id="accordion">
          @php
          $faq_array = [
              [
              "title" => "Lorem Ipsum passage first ?",
              "discription" => "Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered Many desktop publishing packages and web page editors now use Nor again is there anyone who loves or pursues or desires to obtain pain of itself."
              ],
              [
              "title" => "Lorem Ipsum passage second ?",
              "discription" => "Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered Many desktop publishing packages and web page editors now use Nor again is there anyone who loves or pursues or desires to obtain pain of itself."
              ],
              [
              "title" => "Lorem Ipsum passage third ?",
              "discription" => "Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered Many desktop publishing packages and web page editors now use Nor again is there anyone who loves or pursues or desires to obtain pain of itself."
              ],
              [
              "title" => "Lorem Ipsum passage fourth ?",
              "discription" => "Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered Many desktop publishing packages and web page editors now use Nor again is there anyone who loves or pursues or desires to obtain pain of itself."
              ]
            ];
          @endphp

          @foreach($faq_array as $key=>$faqs)
          <div class="accordion-item mb-4">
            <h2 class="accordion-header" id="heading-{{$key}}">
              <button class="accordion-button border mb-0 bg-transparent rounded text-dark {{ $key == '0' ? '' : 'collapsed'}}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{$key}}" aria-expanded="true" aria-controls="collapse-{{$key}}">
                @php echo $faqs['title']; @endphp
              </button>
            </h2>
            <div id="collapse-{{$key}}" class="accordion-collapse border-0 collapse {{ $key == '0' ? 'show' : ''}}" aria-labelledby="heading-{{$key}}" data-bs-parent="#accordion">
              <div class="accordion-body text-muted">@php echo $faqs['discription']; @endphp</div>
            </div>
          </div>
          @endforeach

        </div>
      </div>
    </div>
  </div>
</section>

</div>

@endsection