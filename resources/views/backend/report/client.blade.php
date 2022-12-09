@extends('backend.layouts.app')
@section('css')

@endsection
@section('content')
<a href="javascript:void(0)" class="btn btn-primary mb-2 btn_show send_mail" style="display: none">Send Mail</a>    
<div class="card">
  <div class="card-body">  
    <table id="datatable_new" class="table table-bordered dt-responsive table-responsive nowrap">
        <thead>
            <tr> 
                <th></th>
                <th>Client </th> 
                <th>Client ID  </th> 
                <th>Status </th> 
                <th> Phone </th> 
                <th>Email </th> 
                <th> Street</th> 
                <th>City</th> 
                <th>State</th> 
                <th>Country Of Passport</th> 
                <th>D.O.B  </th> 
                <th>Added Date</th>        
                <th>Visa Expiry Date</th> 
                <th>Preferred Intake</th> 
                <th>Added By User</th> 
                <th>Added By Office</th> 
                <th>Followers</th>
        </thead>  
        <tbody>

        </tbody>
    </table>
  </div>
</div>

<!-- Standard modal content -->
<div id="AddNewKPI" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Compose Email</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
          <form id="send_client_email">
           
            <div class="modal-body">
                 <div class="mb-2">
                     <label>Form</label>
                     <input type="text" class="form-control" name="send_form" value="{{auth()->user()->email}}">
                     <span class="text-danger" id="error_send_form"></span>
                 </div>
                 <div class="mb-2">
                     <label>To</label>
                     <input type="text" class="form-control" name="send_to" id="send_to">
                     <span class="text-danger" id="error_send_to"></span>
                 </div>
                 <div class="mb-2">
                     <label>CC</label>
                     <input type="text" class="form-control" name="cc_email" >    
                     <span class="text-danger" id=""></span>
                 </div>
                 <div class="mb-2">
                     <label>Subject</label>
                     <input type="text" class="form-control" name="email_subject">
                     <span class="text-danger" id=""></span>
                 </div>
                 <div class="mb-2">
                     <label>Message</label>
                     <textarea class="summereditor" name="" id="get_txetarea" cols="30" rows="10" ></textarea>
                     <input type="hidden" name="email_body" id="email_body">
                     <span class="text-danger" id=""></span>
                 </div>
                 
                 <div class="mb-2">
                        <label class="form-label">Attachment</label>
                        <input type="file" name="attachment" class="dropify">
                 </div> 

            </div>
      
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary client_email" >Send</button>
            </div>
          <form> 
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
    $( document ).ready(function() { 
        $('.dropify').dropify();
        $('.summereditor').summernote();
        
       var table=$('#datatable_new').DataTable( {
            processing: true,
            serverSide: true,
            // scrollX: true,
            ajax: {
                url: "{{route('backend.get_report_client')}}",
                type: "get",
                dataType: 'JSON',
            },
            columns: [
                { data: 'checkbox', name: 'checkbox'},
                { data: 'full_name', name: 'full_name'},
                { data: 'client_id', name: 'client_id' },
                { data: 'client_status', name: 'client_status' },
                { data: 'phone', name: 'phone' },
                { data: 'email', name: 'email' },
                { data: 'street', name: 'street' },
                { data: 'city', name: 'city' },
                { data: 'state', name: 'state' },
                { data: 'country_passport', name: 'country_passport' },
                { data: 'client_dob', name: 'client_dob' },
                { data: 'created_at', name: 'created_at' },
                { data: 'visa_expiry', name: 'visa_expiry'},
                { data: 'preferred_intake', name: 'preferred_intake'},
                { data: 'users.first_name', name: 'users.first_name'},
                { data: 'office_info.office_name', name: 'office_info.office_name'},
                { data: 'flowers.first_name', name: 'flowers.first_name'},
                ],
       });

    //    $("body").delegate(function(e){

           
    //    });
       $('body').delegate('.checkbox_click', 'click', function() {
             var id=$(this).attr('data-id');
             $(".btn_show").attr('data-index',id); 
             $(".btn_show").toggle();
      });
     
      $('body').delegate('.send_mail', 'click', function(e) {
             e.preventDefault();
             var id=$(this).attr('data-index');
             jQuery.ajax({
              type: 'get',
              url: "{{route('backend.get_single_client')}}",
              data: {
                client_id:id,
              },
              success: function(data) {
                $("#send_to").val(data[0].email);
                $("#AddNewKPI").modal("show");
              }
          })   
      });

     
    });
    
    $('.client_email').click(function(e){     
        e.preventDefault();
        var email_body=$("#get_txetarea").val();
        $("#email_body").val(email_body);
        var fromData = new FormData(document.getElementById("send_client_email"));
            $.ajax({
                url: "{{route('backend.send_client_email')}}",
                type: "POST",
                data: fromData,
                cache: false,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    // console.log(response);
                    $('#send_client_email')[0].reset();
                    $('#AddNewKPI').modal("hide");
                    //window.location.reload();
                },
                error: function(response) {
                    //console.log(response);
                    $('#error_send_form').text(response.responseJSON.errors.send_form);
                    $('#error_send_to').text(response.responseJSON.errors.send_to);

                }
            });
    });
</script>
<!-- Datatables init --> 
<script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script> 
@endsection