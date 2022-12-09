@extends('backend.layouts.app')
@section('css')

@endsection
@section('content')
<div class="card">
  <div class="card-body">  
    <table id="datatable_new" class="table table-bordered dt-responsive table-responsive nowrap">
        <thead>
            <tr>
                <th></th>                                                           
                <th>Application Id</th>  
                <th>Client</th>  
                <th>Email</th>   
                <th>Client Id</th>  
                <th>DOB</th>  
                <th>Client Phone</th>   
                <th>Workflow</th>  
                <th>Partner</th>  
                <th>Product</th>  
                <th>Partner Branch</th>   
                <th>Total Fee </th>  
                <th>Installment Type</th>   
                <th>Status</th>     
                <!-- <th>Assignees</th>  
                <th>Started By</th>  
                <th>Office</th>  
                <th>Client Source</th>  
                <th>Sub Agent</th>  
                <th>Super Agent</th>   -->
                <th>Visa Expiry</th>  
                <th>Added Date</th>  
                <!-- <th>Start Date</th>  
                <th>End Date</th>   -->
                <th>Last Updated </th>  

            </tr>
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
                url: "{{route('backend.report_application')}}",
                type: "get",
                dataType: 'JSON',
            },
            columns: [
                { data: 'checkbox', name: 'checkbox'},
                { data: 'id', name: 'id'},
                { data: 'full_name', name:'full_name'},
                { data: 'email', name: 'email'},
                { data: 'client.client_id', name: 'client.client_id' },
                { data: 'client.client_dob', name: 'client.client_dob' },
                { data: 'client.phone', name: 'client.phone' },
                { data: 'workflow.service_workflow', name: 'workflow.service_workflow' },
                { data: 'partner.name', name: 'partner.name' },
                { data: 'product.name', name: 'product.name' },
                { data: 'branch_office.name', name: 'branch_office.name' },
                { data: 'product_price.totals', name: 'product_price.totals' },
                { data: 'installment_type', name: 'installment_type'},
                { data: 'status', name: 'status' },
                { data: 'client.visa_expiry', name: 'client.visa_expiry' },
                { data: 'created_at', name: 'created_at'},
                { data: 'updated_at', name: 'updated_at'},
               ],
       });

       $('body').delegate('.send_mail', 'click', function(e) {
               var email=$(this).html(); 
               $("#send_to").val(email);
               $("#AddNewKPI").modal("show");
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
    });    
</script>
<!-- Datatables init --> 
<script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script> 
@endsection