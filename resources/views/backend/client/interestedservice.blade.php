@extends('backend.layouts.app')
@section('css')
<link href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<h4 class="mt-0 header-title text-end">
    <a href="{{route('backend.manage-clients')}}" class="btn btn-primary"> Client List </a>
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
        
        @if(Session::has('success'))
            <div class="alert alert-success" style="text-align: center;">
                {{ Session::get('success') }}
            </div>
        @endif

        <div class="text-end mb-3">
            <button type="button" class="btn btn-primary" id="addService">+ Add</button>
        </div>

        <div class="row">

            @foreach($interestedServices as $service)
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body p-2">
                        <div class="dropdown float-end">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="javascript:void(0);" data-id="{{ $service->id }}" data-client="{{ $service->client_id }}" class="dropdown-item editServiceModel">Edit</a>
                                <a href="{{ route('backend.deleteclient-service', ['id' => $service->id, 'client_id'=> $service->client_id ]) }}" id="delete" class="dropdown-item">Delete</a>
                            </div>
                        </div>
                        <div class="mb-3">
                            <h5 class="media-heading mt-0 mb-0">{{ $service->workflow->service_workflow }} <span class="badge bg-primary rounded-pill">Draft</span></h5>
                            <p>{{ $service->product->name }}</p>
                        </div>
                        <p>{{ $service->partner->name }}</p>
                        <p>{{ $service->branch->name }}</p>
                        <div class="row">
                            <div class="col-6">
                                <p class="mb-0"><strong>Product Fees</strong></p>
                                <p class="mb-0"><small>AUD 0.00</small></p>
                            </div>
                            <div class="col-6 text-end">
                                <p class="mb-0"><strong>Sales Forecast</strong></p>
                                <p class="mb-0"><small>AUD 0.00</small></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <p class="mb-0"><strong>Expected Start Date</strong></p>
                                <p class="mb-0"><small>{{ $service->start_date }}</small></p>
                            </div>
                            <div class="col-6 text-end">
                                <p class="mb-0"><strong>Expected Win Date</strong></p>
                                <p class="mb-0"><small>{{ $service->end_date }}</small></p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer p-2">
                        <div class="float-end">
                            <a href="javascript:void(0);" data-id="{{ $service->id }}" data-client="{{ $service->client_id }}" class="btn btn-primary rounded-pill btn-sm viewServiceModel">View</a>
                        </div>
                        <div class="d-flex align-items-center">
                            <a href="#"><img class="flex-shrink-0 me-1 rounded-circle avatar-sm" alt="64x64" src="{{ asset('assets/images/users/user-1.jpg') }}"></a>
                            <div class="flex-grow-1">
                                <p class="mb-0">Last Modified:</p>
                                <p class="mb-0"><small>{{ $service->updated_at }}</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>

    </div>
</div>
<!-- Standard modal content -->
<div id="addServiceModel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addcontact-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="serviceFrom">
                <div class="modal-header">
                    <h4 class="modal-title" id="addcontact-modalLabel">Add Interested Services</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="client_id" value="{{ $client->id }}">
                    <div class="mb-2">
                        <label class="form-label">Select Workflow <span class="text-danger">*</span></label>
                        <select name="workflow_id" id="getWorkflow" class="form-control" data-toggle="select2" data-width="100%">
                            <option value="">Please select a workflow</option>
                            @foreach($workflowCategories as $workflow)
                            <option value="{{ $workflow->id }}">{{ $workflow->service_workflow }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger" id="workflowError"></span>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Select Partner</label>
                        <select name="partner_id" id="getProduct" class="form-control" data-toggle="select2" data-width="100%">
                            <option value="">Please select a partner</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Select Product</label>
                        <select name="product_id" id="getBranch" class="form-control" data-toggle="select2" data-width="100%">
                            <option value="">Please select a product</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Select Branch</label>
                        <select name="branch_id" class="form-control" id="branchInfo" data-toggle="select2" data-width="100%">
                            <option value="">Please select a branch</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-2">
                            <label class="form-label">Expected Start Date</label>
                            <input type="text" name="start_date" class="form-control basic-datepicker" placeholder="Select Date">
                            <small>Date must be in YYYY-MM-DD (2012-12-22) format.</small>
                        </div>
                        <div class="col-6 mb-2">
                            <label class="form-label">Expected End Date</label>
                            <input type="text" name="end_date" class="form-control basic-datepicker" placeholder="Select Date">
                            <small>Date must be in YYYY-MM-DD (2012-12-22) format.</small>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Standard modal content -->
<div id="updateService" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="updateServiceForm" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Edit Task</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body updateServiceContent">

                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Standard modal content -->
<div id="viewService" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Service Details</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body viewServiceContent">
                
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection

@section('script')
<!-- Datatables init -->
<script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
<script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {

        $('#addService').click(function() {
            $('#addServiceModel').modal('show');
        });

        $('#getWorkflow').on("change", function() {
            var workflowId = $(this).val();
            $.ajax({
                url: "{{ route('backend.service_workflow') }}",
                data: {
                    'workflow_id': workflowId
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(data) {
                    if (data != undefined && data != null) {
                        var optionValue = '';
                        for (var i = 0; i < data.length; i++) {
                            optionValue += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
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
                data: {
                    'partner_id': partnerId
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(data) {
                    if (data != undefined && data != null) {
                        var optionValue = '';
                        for (var i = 0; i < data.length; i++) {
                            optionValue += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                        }
                        $('#getBranch').append(optionValue);
                    }
                }
            });
        });
        $('#getBranch').on("change", function() {
            var productId = $(this).val();
            $.ajax({
                url: "{{ route('backend.partner_branch') }}",
                data: {
                    'product_id': productId
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(data) {
                    if (data != undefined && data != null) {
                        var optionValue = '';
                        for (var i = 0; i < data.length; i++) {
                            optionValue += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                        }
                        $('#branchInfo').append(optionValue);
                    }
                }
            });
        });

        $('#submitBtn').on("click", function(e) {
            e.preventDefault();
            var serialize = $('#serviceFrom').serialize();
            $.ajax({
                url: "{{ route('backend.addclient-service') }}",
                type: "POST",
                data: serialize,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    $('#addServiceModel').modal('hide');
                    window.location.reload();
                },
                error: function(response) {
                    $('#workflowError').text(response.responseJSON.errors.workflow_id);
                }
            });
        });

        $('.editServiceModel').on("click", function() {

            $('#updateService').modal("show");
            var serviceId = $(this).data('id');
            var clinetId = $(this).data('client');

            $.ajax({
                url: "{{ route('backend.editclient-service') }}",
                type: "POST",
                data: {
                    service_id: serviceId,
                    client_id: clinetId,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {

                    var workflow = '';
                    for(var i = 0; i < response.workflowes.length; i++){
                        if(response.service.workflow_id == response.workflowes[i].id){
                            workflow += '<option value="'+response.workflowes[i].id+'" selected>'+response.workflowes[i].service_workflow+'</option>';
                        }else{
                            workflow += '<option value="'+response.workflowes[i].id+'">'+response.workflowes[i].service_workflow+'</option>';
                        }
                    }

                    var partner = '';
                    for(var i = 0; i < response.partners.length; i++){
                        if(response.service.partner_id == response.partners[i].id){
                            partner += '<option value="'+response.partners[i].id+'" selected>'+response.partners[i].name+'</option>';
                        }else{
                            partner += '<option value="'+response.partners[i].id+'">'+response.partners[i].name+'</option>';
                        }
                    }

                    var product = '';
                    for(var i = 0; i < response.products.length; i++){
                        if(response.service.product_id == response.products[i].id){
                            product += '<option value="'+response.products[i].id+'" selected>'+response.products[i].name+'</option>';
                        }else{
                            product += '<option value="'+response.products[i].id+'">'+response.products[i].name+'</option>';
                        }
                    }

                    var branch = '';
                    for(var i = 0; i < response.branches.length; i++){
                        if(response.service.branch_id == response.branches[i].id){
                            branch += '<option value="'+response.branches[i].id+'" selected>'+response.branches[i].name+'</option>';
                        }else{
                            branch += '<option value="'+response.branches[i].id+'">'+response.branches[i].name+'</option>';
                        }
                    }

                    var html = '';

                    html += '<input type="hidden" name="service_id" value="'+response.service.id+'"><input type="hidden" name="client_id" value="'+response.service.client_id+'"><div class="mb-2"><label class="form-label">Select Workflow <span class="text-danger">*</span></label><select name="workflow_id" class="form-control getWorkflow" data-toggle="select2" data-width="100%"><option value="">Please select a workflow</option>'+workflow+'</select><span class="text-danger workflowError"></span></div><div class="mb-2"><label class="form-label">Select Partner</label><select name="partner_id" class="form-control getProduct" data-toggle="select2" data-width="100%"><option value="">Please select a partner</option>'+partner+'</select></div><div class="mb-2"><label class="form-label">Select Product</label><select name="product_id" class="form-control getBranch" data-toggle="select2" data-width="100%"><option value="">Please select a product</option>'+product+'</select></div><div class="mb-2"><label class="form-label">Select Branch</label><select name="branch_id" class="form-control branchInfo" data-toggle="select2" data-width="100%"><option value="">Please select a branch</option>'+branch+'</select></div><div class="row"><div class="col-6 mb-2"><label class="form-label">Expected Start Date</label><input type="text" name="start_date" class="form-control basic-datepicker" value="'+response.service.start_date+'"><small>Date must be in YYYY-MM-DD (2012-12-22) format.</small></div><div class="col-6 mb-2"><label class="form-label">Expected End Date</label><input type="text" name="end_date" class="form-control basic-datepicker" value="'+response.service.end_date+'"><small>Date must be in YYYY-MM-DD (2012-12-22) format.</small></div></div><button type="button" class="btn btn-primary px-5 w-100" id="update"> Update </button>';

                    $('.updateServiceContent').html(html);

                    $('.getWorkflow').on("change", function() {
                        var workflowId = $(this).val();
                        $.ajax({
                            url: "{{ route('backend.service_workflow') }}",
                            data: {
                                'workflow_id': workflowId
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: 'json',
                            success: function(data) {
                                if (data != undefined && data != null) {
                                    var optionValue = '';
                                    for (var i = 0; i < data.length; i++) {
                                        optionValue += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                                    }
                                    $('.getProduct').append(optionValue);
                                }
                            }
                        });
                    });
                    $('.getProduct').on("change", function() {
                        var partnerId = $(this).val();
                        $.ajax({
                            url: "{{ route('backend.product_info') }}",
                            data: {
                                'partner_id': partnerId
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: 'json',
                            success: function(data) {
                                if (data != undefined && data != null) {
                                    var optionValue = '';
                                    for (var i = 0; i < data.length; i++) {
                                        optionValue += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                                    }
                                    $('.getBranch').append(optionValue);
                                }
                            }
                        });
                    });
                    $('.getBranch').on("change", function() {
                        var productId = $(this).val();
                        $.ajax({
                            url: "{{ route('backend.partner_branch') }}",
                            data: {
                                'product_id': productId
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: 'json',
                            success: function(data) {
                                if (data != undefined && data != null) {
                                    var optionValue = '';
                                    for (var i = 0; i < data.length; i++) {
                                        optionValue += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                                    }
                                    $('.branchInfo').append(optionValue);
                                }
                            }
                        });
                    });

                    $('[data-toggle="select2"]').select2({
                        dropdownParent: $('#updateService')
                    });
                    $(".basic-datepicker").flatpickr();
                    $(".basic-timepicker").flatpickr({
                        enableTime: !0,
                        noCalendar: !0,
                        dateFormat: "H:i"
                    });

                }
            });

        });

        $(document).delegate('#update', 'click', function(e) {
            e.preventDefault();
            var serialize = $('#updateServiceForm').serialize();
            $.ajax({
                url: "{{ route('backend.updateclient-service') }}",
                type: "POST",
                data: serialize,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    // alert(response);
                    $('#updateService').modal("hide");
                    window.location.reload();
                },
                error: function(response) {
                    $('.workflowError').text(response.responseJSON.errors.workflow_id);
                }
            });

        });
        
        $('.viewServiceModel').on("click", function(e) {
            e.preventDefault();

            $('#viewService').modal("show");
            var serviceId = $(this).data('id');
            var clientId = $(this).data('client');
            // console.log(contactId);

            $.ajax({
                url: "{{ route('backend.viewclient-service') }}",
                type: "POST",
                data: {
                    service_id: serviceId,
                    client_id: clientId,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    var html = '';

                    html += '<div class="mb-2"><label class="form-label">Workflow</label><p>'+response.workflow.service_workflow+'</p></div><div class="mb-2"><label class="form-label">Partner</label><p>'+response.partner.name+'</p></div><div class="mb-2"><label class="form-label">Branch</label><p>'+response.branch.name+'</p></div><div class="mb-2"><label class="form-label">Product</label><p>'+response.product.name+'</p></div><div class="mb-2"><label class="form-label">Expected Start Date</label><p>'+response.start_date+'</p></div><div class="mb-2"><label class="form-label">Expected Win Date</label><p>'+response.end_date+'</p></div>';

                    $('.viewServiceContent').html(html);

                }
            });

        });

        //delete sweetalert
        $(document).on('click', '#delete', function(e) {
            e.preventDefault();
            var Id = $(this).attr('href');

            swal({
                    title: "Are you sure?",
                    text: "You want to delete!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        swal("Successfully deleted!", {
                            icon: "success",
                        });

                        window.location.href = Id;

                    } else {
                        swal("safe!");
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


        $('[data-toggle="select2"]').select2({
            dropdownParent: $('#addServiceModel')
        });
        $(".basic-datepicker").flatpickr();
        $(".basic-timepicker").flatpickr({
            enableTime: !0,
            noCalendar: !0,
            dateFormat: "H:i"
        });
    });
</script>
@endsection