@extends('layouts.app')

@section('content')
<main id="main" class="main">

<div class="pagetitle">
  <h1>Validation Result</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('list') }}">List</a></li>
      <li class="breadcrumb-item active">Validation Result</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

@if (session('message'))
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('message') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>  
@endif

<section class="section">
  <div class="row">
    <div class="col-lg-8">

      <div class="card">
        <div class="card-body">

          <div class="d-flex pb-3">
            <div class="card-title p-0 text-start flex-grow-1">Detailed Result History</div>
            @if($account['status'] == 'completed')
              <form method="POST" ACTION="{{ route('downloadCsvFile') }}">
                @csrf
                <input type="hidden" name="filename" value="{{ $account['file_name'] }}">
                <input type="hidden" name="recodes" value="all">
                <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-cloud-arrow-down-fill"></i> FULL LIST</button>
              </form>                
            @endif
          </div>

          <div class="row">
            <!-- <div class="col-xxl-4 col-md-6">
              <div class="card"> 
                <div class="card-body p-3">
                  <h5 class="card-title p-0">{{ $account['id'] }}</h5>
                  <h5 class="cust-title">Id</h5>                  
                </div>
              </div>
            </div> -->

            <div class="col-xxl-4 col-md-6">
              <div class="card"> 
                <div class="card-body p-3">
                  <h5 class="card-title p-0">{{ $account['file_name'] }}</h5>
                  <h5 class="cust-title">File Name</h5>
                </div>
              </div>
            </div>

            <div class="col-xxl-4 col-md-6">
              <div class="card"> 
                <div class="card-body p-3">
                  <h5 class="card-title p-0">{{ $account['file_size'] }}</h5>
                  <h5 class="cust-title">File Size</h5>
                </div>
              </div>
            </div>

            <div class="col-xxl-4 col-md-6">
              <div class="card"> 
                <div class="card-body p-3">
                  <h5 class="card-title p-0 mb-1">
                    <input type="hidden" id="result-page-status" value="{{ $account['status'] }}">
                    @if($account['status'] == 'completed')
                    <span class="badge badge-pill bg-success text-light">{{ $account['status'] }}</span>
                    @else
                    <span class="badge badge-pill bg-warning blink-icon text-light">{{ $account['status'] }}</span>
                    @endif
                  </h5>
                  <h5 class="cust-title">Status</h5>
                </div>
              </div>
            </div>

            <div class="col-xxl-4 col-md-6">
              <div class="card"> 
                <div class="card-body p-3">
                  <h5 class="card-title p-0">{{ $account['total_recodes'] }}</h5>
                  <h5 class="cust-title">Total Records</h5>
                </div>
              </div>
            </div>

            <div class="col-xxl-4 col-md-6">
              <div class="card"> 
                <div class="card-body p-3">
                  <h5 class="card-title p-0">{{ $account['duplicate_recodes'] }}</h5>
                  <h5 class="cust-title">Duplicate Records</h5>
                </div>
              </div>
            </div>

            <div class="col-xxl-4 col-md-6">
              <div class="card"> 
                <div class="card-body p-3">
                  <h5 class="card-title p-0">{{ $account['save_recodes'] }}</h5>
                  <h5 class="cust-title">Save Records</h5>                  
                </div>
              </div>
            </div>

            
          </div>

          <hr>
          <div class="row">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col" class="text-center">Type</th>
                  <th scope="col" class="text-center">Count</th>
                  <th scope="col" class="text-center">Percent</th>
                  <th scope="col" class="text-center">Download</th>
                </tr>
              </thead>
              <tbody>

                <tr>
                  <td class="valid-color text-center">
                  Valid
                  </td>
                  <td class="valid-color text-center">
                    <input type="hidden" id="valid_id" value="{{ $account['valid'] }}">
                    <span class="font-weight-normal" id="valid" value="524">{{ $account['valid'] }}</span>
                  </td>
                  <td class="valid-color text-center">
                    <span class="font-weight-normal">{{ $account['valid_per'] }}</span>
                  </td>
                  
                  <td class="text-center">
                    <span class="campaign-status">
                      @if($account['status'] == 'completed' && $account['valid'] > 0)
                      <form method="POST" ACTION="{{ route('downloadCsvFile') }}">
                        @csrf
                        <input type="hidden" name="filename" value="{{ $account['file_name'] }}">
                        <input type="hidden" name="recodes" value="valid">
                        <a type="submit" onclick="this.parentNode.submit();">
                          <i class="bi bi-cloud-arrow-down-fill fs-30 theme-primary"></i>
                        </a>
                      </form>
                      @else                                            
                        <i class="bi bi-cloud-slash-fill fs-30 text-secondary"></i>
                      @endif
                    </span>
                  </td>
                </tr>

                <tr>
                  <td class="invalid-color text-center">
                  Invalid
                  </td>
                  <td class="invalid-color text-center">
                    <input type="hidden" id="invalid_id" value="{{ $account['invalid'] }}">
                    <span class="font-weight-normal">{{ $account['invalid'] }}</span>
                  </td>
                  <td class="invalid-color text-center">
                    <span class="font-weight-normal">{{ $account['invalid_per'] }}</span>
                  </td>
                  
                  <td class="text-center">
                    <span class="campaign-status">
                      @if($account['status'] == 'completed' && $account['invalid'] > 0)
                        <form method="POST" ACTION="{{ route('downloadCsvFile') }}">
                          @csrf
                          <input type="hidden" name="filename" value="{{ $account['file_name'] }}">
                          <input type="hidden" name="recodes" value="invalid">
                          <a type="submit" onclick="this.parentNode.submit();">
                            <i class="bi bi-cloud-arrow-down-fill fs-30 theme-primary"></i>
                          </a>
                        </form>
                      @else                                            
                        <i class="bi bi-cloud-slash-fill fs-30 text-secondary"></i>
                      @endif
                    </span>
                  </td>
                </tr>

                <tr>
                  <td class="catch-color text-center">
                  Catch All
                  </td>
                  <td class="catch-color text-center">
                    <input type="hidden" id="catchall_id" value="{{ $account['catchall'] }}">
                    <span class="font-weight-normal">{{ $account['catchall'] }}</span>
                  </td>
                  <td class="catch-color text-center">
                    <span class="font-weight-normal">{{ $account['catchall_per'] }}</span>
                  </td>
                  
                  <td class="text-center">
                    <span class="campaign-status">
                      @if($account['status'] == 'completed' && $account['catchall'] > 0)
                        <form method="POST" ACTION="{{ route('downloadCsvFile') }}">
                          @csrf
                          <input type="hidden" name="filename" value="{{ $account['file_name'] }}">
                          <input type="hidden" name="recodes" value="catchall">
                          <a type="submit" onclick="this.parentNode.submit();">
                            <i class="bi bi-cloud-arrow-down-fill fs-30 theme-primary"></i>
                          </a>
                        </form>
                      @else                                            
                        <i class="bi bi-cloud-slash-fill fs-30 text-secondary"></i>
                      @endif
                    </span>
                  </td>
                </tr>

                <tr>
                  <td class="unknown-color text-center">
                  Unknown
                  </td>
                  <td class="unknown-color text-center">
                    <input type="hidden" id="unknown_id" value="{{ $account['unknown'] }}">
                    <span class="font-weight-normal">{{ $account['unknown'] }}</span>
                  </td>
                  <td class="unknown-color text-center">
                    <span class="font-weight-normal">{{ $account['unknown_per'] }}</span>
                  </td>
                  
                  <td class="text-center">
                    <span class="campaign-status">
                      @if($account['status'] == 'completed' && $account['unknown'] > 0)
                        <form method="POST" ACTION="{{ route('downloadCsvFile') }}">
                          @csrf
                          <input type="hidden" name="filename" value="{{ $account['file_name'] }}">
                          <input type="hidden" name="recodes" value="unknown">
                          <a type="submit" onclick="this.parentNode.submit();">
                            <i class="bi bi-cloud-arrow-down-fill fs-30 theme-primary"></i>
                          </a>
                        </form>
                      @else                                            
                        <i class="bi bi-cloud-slash-fill fs-30 text-secondary"></i>
                      @endif
                    </span>
                  </td>
                </tr>

                <tr>
                  <td class="text-info text-center">
                  Free Account
                  </td>
                  <td class="text-info text-center">
                    <span class="font-weight-normal">{{ $account['free'] }}</span>
                  </td>
                  <td class="text-info text-center">
                    <span class="font-weight-normal">{{ $account['free_per'] }}</span>
                  </td>
                  
                  <td class="text-center">
                    <span class="campaign-status">
                      @if($account['status'] == 'completed' && $account['free'] > 0)
                        <form method="POST" ACTION="{{ route('downloadCsvFile') }}">
                          @csrf
                          <input type="hidden" name="filename" value="{{ $account['file_name'] }}">
                          <input type="hidden" name="recodes" value="free">
                          <a type="submit" onclick="this.parentNode.submit();">
                            <i class="bi bi-cloud-arrow-down-fill fs-30 theme-primary"></i>
                          </a>
                        </form>
                      @else                                            
                        <i class="bi bi-cloud-slash-fill fs-30 text-secondary"></i>
                      @endif
                    </span>
                  </td>
                </tr>

                <tr>
                  <td class="text-black-50 text-center">
                  Role Account
                  </td>
                  <td class="text-black-50 text-center">
                    <span class="font-weight-normal">{{ $account['role'] }}</span>
                  </td>
                  <td class="text-black-50 text-center">
                    <span class="font-weight-normal">{{ $account['role_per'] }}</span>
                  </td>
                  
                  <td class="text-center">
                    <span class="campaign-status">
                      @if($account['status'] == 'completed' && $account['role'] > 0)
                        <form method="POST" ACTION="{{ route('downloadCsvFile') }}">
                          @csrf
                          <input type="hidden" name="filename" value="{{ $account['file_name'] }}">
                          <input type="hidden" name="recodes" value="role">
                          <a type="submit" onclick="this.parentNode.submit();">
                            <i class="bi bi-cloud-arrow-down-fill fs-30 theme-primary"></i>
                          </a>
                        </form>
                      @else                                            
                        <i class="bi bi-cloud-slash-fill fs-30 text-secondary"></i>
                      @endif
                    </span>
                  </td>
                </tr>

                <tr>
                  <td class="text-black text-center">
                  Disposable Account
                  </td>
                  <td class="text-black text-center">
                    <span class="font-weight-normal">{{ $account['disposable'] }}</span>
                  </td>
                  <td class="text-black text-center">
                    <span class="font-weight-normal">{{ $account['disposable_per'] }}</span>
                  </td>
                  
                  <td class="text-center">
                    <span class="campaign-status">
                      @if($account['status'] == 'completed' && $account['disposable'] > 0)
                        <form method="POST" ACTION="{{ route('downloadCsvFile') }}">
                          @csrf
                          <input type="hidden" name="filename" value="{{ $account['file_name'] }}">
                          <input type="hidden" name="recodes" value="disposable">
                          <a type="submit" onclick="this.parentNode.submit();">
                            <i class="bi bi-cloud-arrow-down-fill fs-30 theme-primary"></i>
                          </a>
                        </form>
                      @else                                            
                        <i class="bi bi-cloud-slash-fill fs-30 text-secondary"></i>
                      @endif
                    </span>
                  </td>
                </tr>
                
              </tbody>
            </table>
          </div>

        </div>
      </div>

    </div>

    <div class="col-lg-4">    
      <div class="card">
        <div class="card-body pb-0">
          <div class="d-flex pb-3">
            <div class="card-title p-0 text-start flex-grow-1">Chat View</div>
          </div>

          <div id="trafficChart" style="min-height: 400px;" class="echart"></div>

          

        </div>
      </div>      
    </div>
  </div>
</section>

</main><!-- End #main -->
@endsection

@push('cust_scripts')
  <script>
    var valid_val = document.getElementById("valid_id").value;
    var invalid_val = document.getElementById("invalid_id").value;
    var catchall_val = document.getElementById("catchall_id").value;
    var unknown_val = document.getElementById("unknown_id").value;
    document.addEventListener("DOMContentLoaded", () => {
      echarts.init(document.querySelector("#trafficChart")).setOption({
        tooltip: {
          trigger: 'item'
        },
        legend: {
          top: '5%',
          left: 'center'
        },
        series: [{
          // name: 'Access From',
          type: 'pie',
          radius: ['40%', '70%'],
          avoidLabelOverlap: false,
          label: {
            show: false,
            position: 'center'
          },
          emphasis: {
            label: {
              show: true,
              fontSize: '18',
              fontWeight: 'bold'
            }
          },
          labelLine: {
            show: false
          },
          
          data: [
            {
              value: valid_val,
              name: 'Valid',
              itemStyle: {color: '#2eca6a'},
            },
            {
              value: invalid_val,
              name: 'Invalid',
              itemStyle: {color: '#f34545'},
            },
            {
              value: catchall_val,
              name: 'Catch All',
              itemStyle: {color: '#ff9d55'},
            },                    
            {
              value: unknown_val,
              name: 'Unknown',
              itemStyle: {color: '#7466e8'},
            }
          ]
        }]
      });
    });
  </script>

  <script>
    $(document).ready(function() {
      setInterval( function () {
        if($('#result-page-status').val() == 'inprocess'){
            location.reload();
        }            
      }, 30000 );
    });

  </script>
@endpush
