@extends('home.layouts.app')

@section('content')

<!--body content start-->

<div class="page-content">

<section>
  <div class="container">
    <div class="row align-items-center justify-content-between">
      <div class="col-12 col-lg-6 mb-8 mb-lg-0">
        <img src="{{ asset('assets/front/images/about/04.png') }}" alt="Image" class="img-fluid">
      </div>
      <div class="col-12 col-lg-6 col-xl-5">
        <div class="accordion" id="accordion">
          <div class="accordion-item border mb-4">
            <h2 class="accordion-header" id="headingOne">
      <button class="accordion-button border-0 mb-0 bg-transparent rounded text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
        When our power of choice Bootsland ?
      </button>
    </h2>
            <div id="collapseOne" class="accordion-collapse border-0 collapse show" aria-labelledby="headingOne" data-bs-parent="#accordion">
              <div class="accordion-body text-muted">Looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered Many desktop publishing packages and web page editors now use Nor again is there anyone who loves or pursues or desires to obtain pain of itself.</div>
            </div>
          </div>
          <div class="accordion-item border mb-4">
            <h2 class="accordion-header" id="headingTwo">
      <button class="accordion-button border-0 mb-0 bg-transparent rounded text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
        Nam libero tempore, cum soluta nobis ?
      </button>
    </h2>
            <div id="collapseTwo" class="accordion-collapse border-0 collapse" aria-labelledby="headingTwo" data-bs-parent="#accordion">
              <div class="accordion-body text-muted">Looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered Many desktop publishing packages and web page editors now use Nor again is there anyone who loves or pursues or desires to obtain pain of itself.</div>
            </div>
          </div>
          <div class="accordion-item border">
            <h2 class="accordion-header" id="headingThree">
      <button class="accordion-button border-0 mb-0 bg-transparent rounded text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
        which is the same as saying through ?
      </button>
    </h2>
            <div id="collapseThree" class="accordion-collapse border-0 collapse" aria-labelledby="headingThree" data-bs-parent="#accordion">
              <div class="accordion-body text-muted">Looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered Many desktop publishing packages and web page editors now use Nor again is there anyone who loves or pursues or desires to obtain pain of itself.</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section>
  <div class="container">
    <div class="row align-items-center justify-content-between">
      <div class="col-12 col-lg-6 mb-8 mb-lg-0 order-lg-1">
        <img src="{{ asset('assets/front/images/about/04.png') }}" alt="Image" class="img-fluid">
      </div>
      <div class="col-12 col-lg-6 col-xl-5">
        <div class="accordion" id="accordion2">
          <div class="accordion-item border mb-4">
            <h2 class="accordion-header" id="headingFour">
      <button class="accordion-button border-0 mb-0 bg-transparent rounded text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
        When our power of choice Bootsland ?
      </button>
    </h2>
            <div id="collapseFour" class="accordion-collapse border-0 collapse show" aria-labelledby="headingFour" data-bs-parent="#accordion2">
              <div class="accordion-body text-muted">Looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered Many desktop publishing packages and web page editors now use Nor again is there anyone who loves or pursues or desires to obtain pain of itself.</div>
            </div>
          </div>
          <div class="accordion-item border mb-4">
            <h2 class="accordion-header" id="headingFive">
      <button class="accordion-button border-0 mb-0 bg-transparent rounded text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
        Nam libero tempore, cum soluta nobis ?
      </button>
    </h2>
            <div id="collapseFive" class="accordion-collapse border-0 collapse" aria-labelledby="headingFive" data-bs-parent="#accordion2">
              <div class="accordion-body text-muted">Looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered Many desktop publishing packages and web page editors now use Nor again is there anyone who loves or pursues or desires to obtain pain of itself.</div>
            </div>
          </div>
          <div class="accordion-item border">
            <h2 class="accordion-header" id="headingSix">
      <button class="accordion-button border-0 mb-0 bg-transparent rounded text-dark collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
        which is the same as saying through ?
      </button>
    </h2>
            <div id="collapseSix" class="accordion-collapse border-0 collapse" aria-labelledby="headingSix" data-bs-parent="#accordion2">
              <div class="accordion-body text-muted">Looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered Many desktop publishing packages and web page editors now use Nor again is there anyone who loves or pursues or desires to obtain pain of itself.</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

</div>

<!--body content end--> 
@endsection