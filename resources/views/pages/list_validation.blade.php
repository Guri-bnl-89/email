@extends('layouts.app')

@section('content')

<main id="main" class="main">

<div class="pagetitle">
  <h1>List Validation</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
      <li class="breadcrumb-item active">List Validation</li>
    </ol>
  </nav>
</div><!-- End Page Title -->


<section class="section mb-2">
  <div class="row">
    <div class="col-12 text-end">
      <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#add-list"><i class="bi bi-file-earmark-plus"></i> Add List</button>
      <input type="hidden" id="user-id" value="{{ Auth::user()->id }}">
    </div>
  </div>

  <div class="modal fade" id="add-list" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header border-bottom-0 pb-0">
          <h5 class="modal-title">Add List</h5>
          <button type="button" class="btn-close fs-25" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Bordered Tabs Justified -->
          <ul class="nav nav-tabs nav-tabs-bordered d-flex" id="borderedTabJustified" role="tablist">
            <li class="nav-item flex-fill" role="presentation">
              <button class="nav-link w-100 active" id="upload-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-upload" type="button" role="tab" aria-controls="upload" aria-selected="true"><i class="bi bi-file-earmark-arrow-up"></i> Upload File</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
              <button class="nav-link w-100" id="paste-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-paste" type="button" role="tab" aria-controls="paste" aria-selected="false"><i class="bi bi-clipboard"></i> Paste Emails</button>
            </li>
          </ul>
          <div class="tab-content pt-2" id="borderedTabJustifiedContent">
            <div class="tab-pane fade show active" id="bordered-justified-upload" role="tabpanel" aria-labelledby="upload-tab">
              <h6 class="py-2">Select CSV file containing emails to upload</h6>
              <div class="d-flex drop-area" id="dropArea" ondrop="handleDrop(event)" ondragover="allowDrop(event)">
                <div class="text-start flex-grow-1 theme-primary">
                  <div class="up-title">Select or drag CSV file</div>
                  <div class="up-subtitle fs-11">0.0B / 0.00%</div>
                </div>
                <div class="right-div">
                  <label for="fileInput" class="btn btn-sm btn-primary float-end custom-file-upload" id="export-to-csv">+</label>
                  <input class="hide-input" type="file" id="fileInput" name="fileInput" accept=".csv" onchange="handleFiles(this.files)">
                </div>
              </div>

              <div class="d-flex drop-area d-none file-pro-area">
                <div class="text-start flex-grow-1 theme-primary">
                  <div class="up-title pro-file-name"></div>
                  <div class="up-subtitle"><span class="badge badge-pill bg-warning blink-icon">Inprocess</span></div>
                </div>
                <div class="right-div">
                  <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                  </div>
                </div>
              </div>
              <span class="upload-error text-danger fs-11"></span>
              <div class="result-status"></div>
              

              <div class="mt-5">
                <dl class="text-secondary">
                  <dt class="mb-2"><i class="bi bi-info-circle-fill"></i> Please Note</dt>
                  <dd class="fs-11 mb-1"><span class="badge bg-secondary">1</span>&nbsp;CSV files of upto 10Mb size are supported</dd>
                  <dd class="fs-11 mb-1"><span class="badge bg-secondary">2</span>&nbsp;No limit on the number of emails in a file</dd>
                  <dd class="fs-11 mb-1"><span class="badge bg-secondary">3</span>&nbsp;Emails are de-duplicated, so imported emails count might be lower</dd>
                  <dd class="fs-11 mb-1"><span class="badge bg-secondary">4</span>&nbsp;Additional data columns present in the file will be retained</dd>
                  <dd class="fs-11 mb-1"><span class="badge bg-secondary">5</span>&nbsp;The uploaded file will be analyzed and ready for verification</dd>
                </dl>                
              </div>

            </div>
            <div class="tab-pane fade" id="bordered-justified-paste" role="tabpanel" aria-labelledby="paste-tab">
              <h6 class="py-2">Paste Emails <span class="fs-11 text-secondary">(one on each line)</span></h6>
              <div class="row" id="pastArea">
                <from>
                  <textarea class="form-control" placeholder="Email addresses" name="email" rows="5" id="input-textarea"></textarea>
                  <div class="col-12 mt-3 text-end">
                    <button class="btn btn-primary" id="text-validate" type="button">Validate</button>
                  </div>
                </form>
              </div>

              <div class="d-flex drop-area d-none file-pro-area">
                <div class="text-start flex-grow-1 theme-primary">
                  <div class="up-title pro-file-name"></div>
                  <div class="up-subtitle"><span class="badge badge-pill bg-warning blink-icon">Inprocess</span></div>
                </div>
                <div class="right-div">
                  <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                  </div>
                </div>
              </div>
              <span class="upload-error text-danger fs-11"></span>
              <div class="result-status mb-5"></div>

              <div class="mt-1">
                <dl class="text-secondary">
                  <dt class="mb-2"><i class="bi bi-info-circle-fill"></i> Please Note</dt>
                  <dd class="fs-11 mb-1"><span class="badge bg-secondary">1</span>&nbsp;Enter upto 1000 email addresses </dd>
                  <dd class="fs-11 mb-1"><span class="badge bg-secondary">2</span>&nbsp;Enter only email addresses on each line </dd>
                  <dd class="fs-11 mb-1"><span class="badge bg-secondary">3</span>&nbsp;If you need to include additional data, then try Upload File method</dd>
                </dl>                
              </div>  

            </div>
            
          </div>
            <!-- End Bordered Tabs Justified -->

        </div>
        
      </div>
    </div>
  </div>

</section>

<section class="section">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">

          <div class="d-flex pb-3">
            <div class="card-title p-0 text-start flex-grow-1">Result History</div>
          </div>


          <table class="table table-striped" id="listTable">
                <thead>
                  <tr>
                    <th scope="col">S.no.</th>
                    <th scope="col">Filename</th>
                    <th scope="col" class="text-center">Valid</th>
                    <th scope="col" class="text-center">Invalid</th>
                    <th scope="col" class="text-center">Catch All</th>
                    <th scope="col" class="text-center">Unknown</th>
                    <th scope="col" class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  
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
  <script src="{{ asset('assets/back/js/list.js') }}"></script>
@endpush
