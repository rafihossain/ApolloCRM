@extends('backend.layouts.app')
@section('css')
 
@endsection
@section('content')
<h4 class="mt-0 header-title text-end">
    <a href="{{route('backend.manage-clients')}}" class="btn btn-primary">  Client List </a>
</h4>

<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body"> 
                @include('backend.client.include.client-sidebar')
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-body"> 
                @include('backend.client.include.client-header')
            </div>
        </div>
        
        <div class="text-end mb-3">
            <button type="button" class="btn btn-primary" id="addApplication">+ Add</button>
        </div>
        <div class="card">
            <div class="card-body">
                <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                    <thead>
                        <tr>        
                            <th> Name </th>
                            <th> Workflow </th> 
                            <th> Current Stage </th>
                            <th> Status </th> 
                            <th> Sales Forecast </th>
                            <th> Started </th>
                            <th> Last Updated </th>
                            <th> Action </th>
                        </tr>
                    </thead>  
                    <tbody>
                        @foreach($applications as $application)
                            <tr>
                                <td>
                                    <div class="text-truncate">
                                        <a href="{{ route('backend.client-profile-application-details', 
                                        ['id'=> $application->id, 'client_id'=> $application->client_id ] )}}" >
                                            @isset($application->product)
                                                {{ $application->product->name }}
                                            @endisset
                                        </a>
                                    </div>
                                    <small>@isset($application->partner){{ $application->partner->name }}(Head Office)@endisset</small>
                                </td>
                                <td> {{ $application->workflow->service_workflow }} </td>
                                <td> COE </td>
                                <td> <span class="rounded-pill badge bg-light text-dark">Tset</span> </td>
                                <td> 0.00 </td>
                                <td> {{ $application->created_at }} </td>
                                <td> {{ $application->updated_at }} </td>
                                <td>
                                    <a href="" class="btn btn-sm btn-primary waves-effect waves-light"><i class="mdi mdi-square-edit-outline"></i></a>
                                    <a href="" id="delete" class="btn btn-sm btn-danger waves-effect waves-light"><i class="mdi mdi-trash-can-outline"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>
</div>
<!-- Standard modal content -->
<div id="applicationModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addcontact-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="applicationForm">
                <div class="modal-header">
                    <h4 class="modal-title" id="addcontact-modalLabel">Add Application</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="client_id" value="{{ $client->id }}">
                    <div class="mb-2">
                        <label class="form-label">Select Workflow </label>
                        <select name="workflow_id" id="getWorkflow" class="form-control" data-toggle="select2" data-width="100%">
                            <option value="">Please select a workflow</option>
                            @foreach($workflowCategories as $workflow)
                                <option value="{{ $workflow->id }}">{{ $workflow->service_workflow }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger" id="workflowError"></span>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Select Partner & Branch</label>
                        <select name="partner_id" id="getProduct" class="form-control" data-toggle="select2" data-width="100%">
                            <option value="">Please select a partner & branch</option>
                        </select>
                        <span class="text-danger" id="partnerError"></span>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Select Product</label>
                        <select name="product_id" id="productInfo" class="form-control" data-toggle="select2" data-width="100%"> 
                            <option value="">Please select a product</option>
                        </select>
                        <span class="text-danger" id="productError"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitBtn">Submit</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

 
@endsection

@section('script')
<!-- Datatables init --> 
<script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('[data-toggle="select2"]').select2({
            dropdownParent: $('#applicationModal')
        }); 
    });
    
    $('#addApplication').click(function(){
        $('#applicationModal').modal('show');
    });

    $('#getWorkflow').on("change", function() {
        var workflowId = $(this).val();
        $.ajax({
            url: "{{ route('backend.service_workflow') }}",
            data:{'workflow_id':workflowId},
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: 'json',
            success: function(data) {
                if(data != undefined && data != null){
                    var optionValue = '';
                    for(var i = 0; i < data.length; i++){
                        optionValue +='<option value="'+data[i].id+'">'+data[i].name+'</option>';
                    }
                    $('#getProduct').append(optionValue);
                }
            }
        });
    });
    $('#getProduct').on("change", function() {
        var partnerId = $(this).val();
        $.ajax({
            url: "{{ route('backend.product_info') }}",
            data:{'partner_id':partnerId},
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: 'json',
            success: function(data) {
                if(data != undefined && data != null){
                    var optionValue = '';
                    for(var i = 0; i < data.length; i++){
                        optionValue +='<option value="'+data[i].id+'">'+data[i].name+'</option>';
                    }
                    $('#productInfo').append(optionValue);
                }
            }
        });
    });
    $('#submitBtn').on("click", function() {
        var serialize = $('#applicationForm').serialize();
        $.ajax({
            url: "{{ route('backend.save-client-application') }}",
            type: "POST",
            data: serialize,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: 'json',
            success: function(response) {
                $('#applicationModal').modal('hide');
                window.location.reload();
            },
            error: function(response){
                $('#workflowError').text(response.responseJSON.errors.workflow_id);
                $('#partnerError').text(response.responseJSON.errors.partner_id);
                $('#productError').text(response.responseJSON.errors.product_id);
            }
        });
    });
    
    //archived sweetalert
    $(document).on('click', '#client-delete', function(e) {
        e.preventDefault();
        var Id = $(this).attr('href');

        swal({
                title: "Are you sure?",
                text: "You want to Archived!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    swal("Successfully Archived!", {
                        icon: "success",
                    });

                    window.location.href = Id;

                } else {
                    swal("Archived not completed!");
                }

            });
    });

    //restore sweetalert
    $(document).on('click', '#client-restore', function(e) {
        e.preventDefault();
        var Id = $(this).attr('href');

        swal({
                title: "Are you sure?",
                text: "You want to restore this client!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    swal("Successfully restore!", {
                        icon: "success",
                    });

                    window.location.href = Id;

                } else {
                    swal("Restore not completed!");
                }

            });
    });

</script>
@endsection