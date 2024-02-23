@extends('layouts.app')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">

            <!-- Total Verified Card -->
            <div class="col-xxl-3 col-md-6">
              <div class="card info-card">                

                <div class="card-body">
                  <!-- <button type="button" onclick="yesim()">yes</button> -->
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center theme-primary-bk text-white"> 
                      <i class="bi bi-check2-circle"></i>
                    </div> 
                    <div class="ms-3"> 
                      <p class="mb-0 card-title p-0">Total Verified</p>
                      <div class="m-0 fs-30 theme-primary">{{$account['total_emails']; }}
                      </div> 
                    </div> 
                    
                  </div>
                </div>

              </div>
            </div><!-- End Total Verified Card -->

            <!-- Valid Card -->
            <div class="col-xxl-3 col-md-6">
              <div class="card info-card">

                <div class="card-body">

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center valid-color-bk text-white">
                      <i class="bi bi-envelope-check"></i>
                    </div>
                    <div class="ms-3"> 
                      <p class="mb-0 card-title p-0">Valid Emails</p>
                      <div class="m-0 fs-30 valid-color">{{$account['valid']; }}
                      </div> 
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Valid Card -->

            <!-- Invalid Card -->
            <div class="col-xxl-3 col-xl-12">

              <div class="card info-card">


                <div class="card-body">

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center invalid-color-bk text-white">
                      <i class="bi bi-envelope-x"></i>
                    </div>
                    <div class="ms-3"> 
                      <p class="mb-0 card-title p-0">Bounce Emails</p>
                      <div class="m-0 fs-30 invalid-color">{{$account['invalid']; }}
                      </div> 
                    </div>
                  </div>

                </div>
              </div>

            </div><!-- End Invalid Card -->

            <!-- Catch Card -->
            <div class="col-xxl-3 col-xl-12">

              <div class="card info-card">

                <div class="card-body">

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center catch-color-bk text-white">
                    <i class="bi bi-at"></i>
                    </div>
                    <div class="ms-3"> 
                      <p class="mb-0 card-title p-0">Credit Balance</p>
                      <div class="m-0 fs-30 catch-color">{{ auth()->user()->credits; }}
                      </div> 
                    </div>
                  </div>

                </div>
              </div>

            </div><!-- End Catch Card -->

            <!-- Unknown Card -->
            <!-- <div class="col-xxl-3 col-xl-12">

              <div class="card info-card">

                <div class="card-body">
                  <h5 class="card-title">Unknown Emails</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center unknown-color-bk text-white">
                      <i class="bi bi-patch-question"></i>
                    </div>
                    <h6 class="ps-1">7</h6>
                  </div>

                </div>
              </div>

            </div> -->
            <!-- End Unknown Card -->

            <!-- Reports -->
            <div class="col-12">
              <div class="card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><button class="dropdown-item" onclick="fetchData('today')">Today</button></li>
                    <li><button class="dropdown-item" onclick="fetchData('month')">This Month</button></li>
                    <li><button class="dropdown-item" onclick="fetchData('year')">This Year</button></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title p-0">Reports <span id="report-type" class="text-capitalize">/Today</span></h5>

                  <!-- Line Chart -->
                  <div id="reportsChart"></div>

                  
                  <!-- End Line Chart -->

                </div>

              </div>
            </div><!-- End Reports -->

          </div>
        </div><!-- End Left side columns -->

      </div>
    </section>

  </main><!-- End #main -->
  @endsection
  @push('cust_scripts')
  <script>
    
      
  $(document).ready(function(){
      // Call fetchData function on page load
      fetchData('today');
  });

  // Function to fetch data via AJAX
  function fetchData(ftype) {
      $.ajax({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: '/reportsChartData', // Update the URL to match your Laravel route
          data: {type:ftype} ,
          type : 'POST',
          dataType : 'json',
          success: function(response) {
            $("#report-type").text('/'+ftype);
              // Initialize ApexCharts with fetched data
              var options = {
                  chart: {
                      type: 'line',
                      height: 350
                  },
                  series: response,
                  chart: {
                    height: 350,
                    type: 'area',
                    toolbar: {
                      show: false
                    },
                  },
                  markers: {
                    size: 4
                  },
                  colors: ['#2eca6a','#f34545', '#ff9d55', '#7466e8'],
                  fill: {
                    type: "gradient",
                    gradient: {
                      shadeIntensity: 1,
                      opacityFrom: 0.3,
                      opacityTo: 0.4,
                      stops: [0, 90, 100]
                    }
                  },
                  dataLabels: {
                    enabled: false
                  },
                  stroke: {
                    curve: 'smooth',
                    width: 2
                  },
                  xaxis: {
                      type: 'datetime'
                  }
              }
              if (window.myChart){
                window.myChart.destroy();
              }
              window.myChart = new ApexCharts(document.querySelector("#reportsChart"), options);
              window.myChart.render();

          },
          error: function(xhr, status, error) {
              console.error('Error fetching sales data:', error);
          }
      });
  }

  </script>
  @endpush

