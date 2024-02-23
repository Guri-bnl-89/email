@extends('layouts.app')

@section('content')
<main id="main" class="main">

<div class="pagetitle">
  <h1>Contact Page</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
      <li class="breadcrumb-item">Crm</li>
      <li class="breadcrumb-item active">Contact</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    

    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">

          <div class="d-flex pb-3">
            <div class="card-title pb-0 text-start flex-grow-1">Contact</div>
            
          </div>


          
        </div>
      </div>

    </div>
  </div>
</section>

</main><!-- End #main -->
@endsection