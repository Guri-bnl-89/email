@extends('layouts.app')

@section('content')


<main id="main" class="main">

  <div class="pagetitle">
    <h1>Tickets</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Tickets</li>
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
  @if(auth()->user()->access == 'user')
  <div class="row">
    <div class="col-12 text-end">
      <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#add-ticket">
        <i class="bi bi-ticket-detailed-fill"></i> New Ticket
      </button>
    </div>
  </div>

  <div class="modal fade" id="add-ticket" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">New Ticket</h5>
          <button type="button" class="btn-close fs-25" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <div class="row">
            <div class="col-lg-12 px-4 pb-3">
              <form method="POST" action="{{ route('support') }}">
                @csrf
                <div class="mb-3">
                  <label for="ticket-priority" class="form-label">Ticket priority</label>
                  <select id="ticket-priority" class="form-select" name="priority" required>
                    <option value="">Choose...</option>
                    <option value="critical">Critical</option>
                    <option value="high">High</option>
                    <option value="normal">Normal</option>
                    <option value="low">Low</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="ticket-subject" class="form-label">Subject</label>
                  <input type="text" class="form-control" name="subject" id="ticket-subject" required>
                </div>
                <div class="mb-3">
                  <label for="ticket-message" class="form-label">Message</label>
                  <textarea class="form-control" id="ticket-message" name="message" rows="5" required></textarea>
                </div>
                <div class="col-12 mt-3 text-end">
                  <button class="btn btn-primary" type="submit">Create</button>
                </div>
              </form>
            </div>
          </div>


        </div>
        
      </div>
    </div>
  </div>
  @endif

  <div class="modal fade" id="ticket-box" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered chat-modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Ticket #<span id="ticket-id"></span></h5>
          <button type="button" class="btn btn-sm btn-secondary ms-4" data-id="" id="ticket-close"><i class="bi bi-check2-all"></i> Close Ticket</button>
          <button type="button" class="btn-close fs-25" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body chat-modal-body" id="ticket-chat-message">
          <div class="d-flex justify-content-center">
            <div class="spinner-border" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
          </div>          
        </div>

        <div class="modal-footer border-0" id="message-wrap">
          <div class="chat-footer">
            <div class="chat-form rounded-pill chat-bg">
              <div class="row align-items-center gx-0">
                <div class="col">
                  <div class="input-group">
                    <textarea id="chat-message" class="form-control px-2" placeholder="Type your message..." rows="1" data-autosize="true" style="overflow: hidden; overflow-wrap: break-word;  height: 47.2px;background-color: #ebf1f7;border: 2px solid #ebf1f7; box-shadow: none;"></textarea>
                  </div>
                </div>
                <div class="col-auto">
                  <button class="btn btn-icon btn-primary rounded-circle ms-2" id="message-send">
                    <i class="bi bi-send"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        
      </div>
    </div>
  </div>

</section>

<section class="section tickets">
  <div class="row">
  
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">

        <div class="d-flex pb-3">
          <div class="card-title p-0 text-start flex-grow-1">Tickets</div>
        </div>

        <table class="table table-striped text-center" id="ticketTable">
          <thead>
            <tr>
              <th scope="col" class="text-center">Priority</th>
              <th scope="col" class="text-center">Subject</th>
              @if(auth()->user()->access == 'admin')
              <th scope="col" class="text-center">Created By</th>
              @endif
              <th scope="col" class="text-center">Created At</th>
              <th scope="col" class="text-center">Status</th>
              <th scope="col" class="text-center">Action</th>

            </tr>
          </thead>
          <tbody>
            @foreach($tickets as $ticket)
            <?php
            switch($ticket->status){
              case 'new':
                $class = 'warning';
                break;
              case 'open':
                $class = 'primary';
                break;
              case 'closed':
                $class = 'success';
                break;
            }

            switch($ticket->priority){
              case 'critical':
                $prclass = 'danger';
                break;
              case 'high':
                $prclass = 'warning';
                break;
              case 'normal':
                $prclass = 'info';
                break;
              case 'low':
                $prclass = 'dark';
                break;
            }
            ?>
            
            <tr>
              <td><span class="border border-{{$prclass}} rounded-pill badge text-{{$prclass}}">{{ ucfirst($ticket->priority) }}</span></td> 
              <td>{{ $ticket->subject }}</td>
              @if(auth()->user()->access == 'admin')
              <td>{{ $ticket->name }} {{ $ticket->surname }}</td>
              @endif
              <td>{{ date('d M-Y h:i A', strtotime($ticket->created_at)) }}</td>
              <td><span class="border border-{{$class}} rounded-pill badge text-{{$class}}">{{ ucfirst($ticket->status) }}</span></td> 
              <td>
                <span class="campaign-status">
                  <a href="#" id="ticket-chat" data-id="{{ $ticket->id }}" data-status="{{ $ticket->status }}" data-bs-toggle="modal" data-bs-target="#ticket-box">
                    <i class="bi bi-eye-fill fs-25"></i>
                  </a>
                </span>
              </td>
            </tr>
            @endforeach
            
          </tbody>
        </table>

        </div>
      </div>

    </div>

  </div>
</section>

</main>
@endsection

@push('cust_scripts')
  <script>
    $(document).ready(function() {

      // initialized DataTable
      $('#ticketTable').DataTable();

      // get ticket full chat from server
      $(document).on('click','#ticket-chat',function(){
        var tid = $(this).attr("data-id");
        var tstatus = $(this).attr("data-status");
        if(tstatus == 'closed'){
          $('#message-wrap').addClass('d-none');
          $('#ticket-close').addClass('d-none');
        } else {
          $('#message-wrap').removeClass('d-none');
          $('#ticket-close').removeClass('d-none');
        }
        $('#ticket-id').text(tid);
        $('#ticket-close').attr("data-id",tid);
        if(tid != ''){
          $.ajax({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              url : '/getChat',
              data: {ticket_id:tid} ,
              type : 'POST',
              dataType : 'json',
              success : function(response){
                  if(response.status == 'success'){
                    $('#ticket-chat-message').html(response.message);
                    setTimeout(function() {
                      $('#ticket-chat-message').animate({scrollTop : $('#ticket-chat-message')[0].scrollHeight }, 'slow');
                    }, 500);
                   
                  }   
              }
          });
        } 
      });

      // send message
      $(document).on('click','#message-send',function(){
        var tid = $('#ticket-close').attr("data-id");
        var new_msg = $('#chat-message').val();        
        if(new_msg != ''){
          $.ajax({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              url : '/addChat',
              data: {ticket_id:tid, message:new_msg} ,
              type : 'POST',
              dataType : 'json',
              success : function(response){
                  if(response.status == 'success'){
                    $('#ticket-chat-message').html(response.message);
                    $('#chat-message').val('');
                    setTimeout(function() {
                      $('#ticket-chat-message').animate({scrollTop : $('#ticket-chat-message')[0].scrollHeight }, 'slow');
                    }, 500);
                  }  
              }
          });
        } 
      });

      // ticket close
      $('#ticket-close').on('click', function() {
        var tid = $(this).attr("data-id");
        if(tid != ''){
          $.ajax({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              url : '/closeTicket',
              data: {ticket_id:tid} ,
              type : 'POST',
              dataType : 'json',
              success : function(response){
                  if(response.status == 'success'){
                    location.reload();
                  }   
              }
          });
        } 
      });


    });

  </script>

@endpush
