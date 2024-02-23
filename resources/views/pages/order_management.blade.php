@extends('layouts.app')

@section('content')
<main id="main" class="main">

<div class="pagetitle">
  <h1>Order Management</h1>
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
            <div class="card-title pb-0 text-start flex-grow-1">Orders</div>
            <!-- <div class="right-div mt-3">
              <button class="btn btn-sm btn-primary float-end" id="export-to-csv">Export to CSV</button>
            </div> -->
          </div>


          <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">User Name</th>
                    <th scope="col">Order Number</th>
                    <th scope="col">Item Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Stauts</th>                    
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Hardi Mann</td>
                    <td>12346</td>
                    <td>500 credits</td>
                    <td><i class="bi bi-currency-rupee"></i>250</td> 
                    <td>New</td>                  
                    <td>
                      <div class="pt-2">
                        <a href="#" class="btn btn-primary btn-sm" title="Upload new profile image"><i class="bi bi-pencil-square"></i></a>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>Kamal Kumar</td>
                    <td>12347</td>
                    <td>200 credits</td>
                    <td><i class="bi bi-currency-rupee"></i>100</td>
                    <td>New</td>                  
                    <td>
                      <div class="pt-2">
                        <a href="#" class="btn btn-primary btn-sm" title="Upload new profile image"><i class="bi bi-pencil-square"></i></a>
                      </div>
                    </td>
                  </tr>
                  
                </tbody>
              </table>
        </div>
      </div>

    </div>
  </div>
</section>

</main><!-- End #main -->
@endsection