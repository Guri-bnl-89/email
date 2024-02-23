@extends('layouts.app')

@section('content')
<main id="main" class="main">

<div class="pagetitle">
  <h1>User Management</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
      <li class="breadcrumb-item active">Users</li>
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

<section class="section">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">

          <div class="d-flex pb-3">
            <div class="card-title p-0 text-start flex-grow-1">Users</div>
            <!-- <div class="right-div mt-3">
              <button class="btn btn-sm btn-primary float-end" id="export-to-csv">Export to CSV</button>
            </div> -->
          </div>


          <table class="table table-striped text-center" id="usersTable">
                <thead>
                  <tr>
                    <th scope="col" class="text-center">Image</th>
                    <th scope="col" class="text-center">Name</th>
                    <th scope="col" class="text-center">Role</th>
                    <th scope="col" class="text-center">Phone</th>
                    <th scope="col" class="text-center">Email</th> 
                    <th scope="col" class="text-center">credits</th> 
                    <th scope="col" class="text-center">Status</th>                    
                    <th scope="col" class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($users as $key=>$user)
                  <tr>
                    <td><img id="img-{{$key}}" src="{{ asset('assets/'.($user->image ? $user->image  : 'back/img/profile-img.jpg')) }}" width="50" alt="Profile"></td>
                    <td id="name-{{$key}}">{{ ucfirst($user->name) }} {{ ucfirst($user->surname) }}</td>
                    <td id="role-{{$key}}">{{ ucfirst($user->access) }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->email }}</td>
                    <td id="credits-{{$key}}">{{ number_format($user->credits) }}</td>
                    <td id="status-{{$key}}">{{ ucfirst($user->status) }}</td>  
                    <td>
                      <div class="pt-2">
                        <a id="edit-button" data-key="{{$key}}" data-id="{{$user->id}}" class="btn btn-primary btn-sm" title="Upload new profile image"><i class="bi bi-pencil-square"></i></a>
                        <a href="{{ url('deleteUser/'.$user->id) }}"  onclick="return confirm('Are you sure want to delete?')" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></a>
                      </div>
                    </td>
                  </tr>
                  @endforeach                  
                </tbody>
              </table>
        </div>
      </div>

    </div>
  </div>

  <!-- User update Modal -->
  <div class="modal fade" id="add-plan" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Update User</h5>
          <button type="button" class="btn-close fs-25" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <div class="row">
            <div class="col-lg-6">
              <div class="image">
                <div class="pt-4 d-flex flex-column align-items-center">
                  <img id="user-img" src="{{ asset('assets/back/img/profile-img.jpg') }}" width="150" alt="Profile" class="rounded-circle">
                  <h5 id="user-name" class="py-2"></h5>            
                </div>
              </div>
            </div>
            <div class="col-lg-6 pb-3">
              <form method="POST" id="user-form" action="{{ route('userUpdate') }}">
                @csrf
                <input type="hidden" id="user-id" name="uid" value="">
                <div class="mb-3">
                  <label for="user-credits" class="form-label">Credits</label>
                  <input type="text" class="form-control" name="credits" id="user-credits" value="" required>
                </div>
                <div class="mb-3">
                  <label for="user-role" class="form-label">Role</label>
                  <select id="user-role" class="form-select" name="role">
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="user-status" class="form-label">Status</label>
                  <select id="user-status" class="form-select" name="status">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                  </select>
                </div>
                <div class="col-12 mt-3 text-end">
                  <button class="btn btn-primary" id="plan-button" type="submit">Update</button>
                </div>
              </form>
            </div>
          </div>


        </div>
        
      </div>
    </div>
  </div>

  <!-- Confirm Modal -->
  <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmModalLabel">Confirm Action</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to perform this action?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" onclick="performAction()">Confirm</button>
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
    $('#usersTable').DataTable();


    $(document).on('click','#edit-button',function(){
      var key = $(this).attr("data-key");
      var uid = $(this).attr("data-id");
      var img = $('#img-'+key).attr('src');
      var name = $('#name-'+key).text();
      var role = $('#role-'+key).text().toLowerCase();
      var credit = $('#credits-'+key).text();
      var status = $('#status-'+key).text().toLowerCase();

      $('#user-id').val(uid);
      $('#user-img').attr('src', img);
      $('#user-name').text(name);
      $('#user-credits').val(credit);
      $('#user-role').val(role);
      $('#user-status').val(status);
      
      $('#add-plan').modal('show');
    });

  });

  function confirmAction() {
      // Using JavaScript's built-in confirm function
      if (confirm("Are you sure you want to perform this action?")) {
        // If the user confirms, perform your action here
        console.log('Action performed!');
      } else {
        // If the user cancels, do nothing or provide feedback
        console.log('Action cancelled!');
      }
    }

</script>
@endpush