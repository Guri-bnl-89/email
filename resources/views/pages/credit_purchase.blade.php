@extends('layouts.app')

@section('content')

<main id="main" class="main">

<div class="pagetitle">
  <h1>Purchase</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
      <li class="breadcrumb-item active">Purchase</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>  
  @endif

  @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>  
  @endif

<section class="section mb-2">
@if(auth()->user()->access == 'admin')
  <div class="row">
    <div class="col-12 text-end">
      <button type="button" id="add-button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#add-plan">
        <i class="bi bi-clipboard2-plus"></i> Add Plan
      </button>
    </div>
  </div>

  <div class="modal fade" id="add-plan" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add New Plan</h5>
          <button type="button" class="btn-close fs-25" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <div class="row">
            <div class="col-lg-12 px-4 pb-3">
              <form method="POST" id="plan-form" action="{{ route('addPlan') }}">
                @csrf
                <input type="hidden" id="plan-id" name="pid" value="">
                <div class="mb-3">
                  <label for="plan-credits" class="form-label">Credits</label>
                  <input type="text" class="form-control" name="credits" id="plan-credits" value="" required>
                </div>
                <div class="mb-3">
                  <label for="plan-price" class="form-label">Price</label>
                  <input type="text" class="form-control" name="price" id="plan-price" required>
                </div>
                <div class="mb-3">
                  <label for="plan-per-verification" class="form-label">Per Verification</label>
                  <input type="text" class="form-control" name="per_verification" id="plan-per-verification" required>
                </div>
                <div class="col-12 mt-3 text-end">
                  <button class="btn btn-primary" id="plan-button" type="submit">Create</button>
                </div>
              </form>
            </div>
          </div>


        </div>
        
      </div>
    </div>
  </div>
  @endif
</section>

<section class="section">
  <div class="row">
    <div class="col-lg-12">   

      <div class="card">
        <div class="card-body">
          <div class="row justify-content-center pt-5">
            <div class="col-lg-12 text-center">
              <h4>Pay As You Go - Choose Higher Plans for Maximum Savings! </h4>
              <p class="paragraph-text py-2">Never Fear, Credits Never Expire - Use Anytime!</p>
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">Credits</th>
                    <th scope="col">Per Verification</th>
                    <th scope="col">Price</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($plans as $key=>$plan)
                  <tr>
                    <td id="credit-{{$key}}" data-val="{{$plan->credits}}">{{ number_format($plan->credits) }}</td>
                    <td id="verification-{{$key}}" data-val="{{$plan->per_verification}}">${{$plan->per_verification}}</td>
                    <td id="price-{{$key}}" data-val="{{$plan->price}}">${{$plan->price}}</td>
                    <td>
                      <a href="{{ url('checkout/'.$plan->id) }}" class="btn btn-sm btn-primary"><i class="bi bi-cart-check-fill"></i> Buy</a>
                      @if(auth()->user()->access == 'admin')
                      <a id="edit-button" data-key="{{$key}}" data-id="{{$plan->id}}" class="btn btn-sm btn-secondary"><i class="bi bi-pencil-square"></i> Edit</a>
                      <a href="{{ url('deletePlan/'.$plan->id) }}"  onclick="return confirm('Are you sure want to delete?')" class="btn btn-sm btn-danger"><i class="bi bi-trash3-fill"></i> Delete</a>
                      @endif
                    </td>
                  </tr>
                  @endforeach
                               
                </tbody>
              </table>
            </div>
          </div>


          
        </div>
      </div>

    </div>
  </div>
</section>

</main><!-- End #main -->
@endsection

@push('cust_scripts')
  <script>
    $(document).ready(function() {

      $(document).on('click','#edit-button',function(){
        var key = $(this).attr("data-key");
        var pid = $(this).attr("data-id");
        var credit = $('#credit-'+key).attr("data-val");
        var verification = $('#verification-'+key).attr("data-val");
        var price = $('#price-'+key).attr("data-val");
        $('#plan-id').val(pid);
        $('#plan-form').attr('action', "{{ url('/editPlan') }}");
        $('.modal-title').text('Edit Plan');
        $('#plan-credits').val(credit);
        $('#plan-price').val(price);
        $('#plan-per-verification').val(verification);
        $('#plan-button').text('Update');
        $('#add-plan').modal('show');
      });

      $(document).on('click','#add-button',function(){
        $('#plan-id').val('');
        $('#plan-form').attr('action', "{{ url('/addPlan') }}");
        $('.modal-title').text('Add New Plan');
        $('#plan-credits').val('');
        $('#plan-price').val('');
        $('#plan-per-verification').val('');
        $('#plan-button').text('Create');
      });


    });

  </script>

@endpush