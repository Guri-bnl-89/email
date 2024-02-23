@extends('layouts.app')

@section('content')

<main id="main" class="main">

<div class="pagetitle">
  <h1>Orders</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
      <li class="breadcrumb-item active">Orders</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    

    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">

          <div class="d-flex pb-3">
            <div class="card-title p-0 text-start flex-grow-1">Order History</div>
            
          </div>


          <table class="table table-striped text-center" id="orderTable">
            <thead>
              <tr>
                <th scope="col" class="text-center">Order Id</th>
                <th scope="col" class="text-center">Credit In Account</th>
                <th scope="col" class="text-center">Price</th>
                <th scope="col" class="text-center">Discount Price</th>
                <th scope="col" class="text-center">Transaction ID</th>
                <th scope="col" class="text-center">Order Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach($orders as $order)
              <tr>
                <td>{{ $order->order_id }}</td>
                <td>{{ number_format($order->credits) }}</td>
                <td>${{ $order->price }}</td>
                <td>${{ $order->discount_price }}</td>
                <td>{{ $order->transaction_id }}</td>
                <td>{{ ucfirst($order->status) }}</td>
              </tr>
              @endforeach              
            </tbody>
          </table>
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
      // initialized DataTable
      $('#orderTable').DataTable();
    });
  </script>
@endpush