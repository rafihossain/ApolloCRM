@extends('backend.layouts.app')
@section('css')

@endsection
@section('content')

<div class="card">
    <div class="card-body overflowhidden">
        <a class="btn btn-primary float-end ms-2" href="javascript:;" id="customField">Add Field</a>
        <ul class="nav nav-tabs nav-bordered border-0">
            <li class="nav-item">
                <a href="{{ route('backend.customfield-client') }}" class="nav-link">
                    Client
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('backend.customfield-partner') }}" class="nav-link active">
                    Partner
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('backend.customfield-product') }}" class="nav-link">
                    Product
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('backend.customfield-application') }}" class="nav-link">
                    Application
                </a>
            </li>
        </ul>
    </div>
</div>

@if(Session::has('success'))
<div class="alert alert-success">
	{{ Session::get('success') }}
</div>
@endif

<div class="card">
    <div class="card-body">
        <div class="mb-4">
            <label class="form-label">Field Status</label>
            <div class=" d-flex">
                <div class="form-check me-2">
                    <input type="radio" id="customRadio1" name="customRadio" class="form-check-input" checked="">
                    <label class="form-check-label" for="customRadio1"> Active</label>
                </div>
                <div class="form-check">
                    <input type="radio" id="customRadio2" name="customRadio" class="form-check-input">
                    <label class="form-check-label" for="customRadio2">Inactive</label>
                </div>
            </div>
        </div>
        <div>
            <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Properties</th>
                        <th>Section</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customFields as $customField)
                    <tr>
                        <td>{{$customField->field_name}}</td>
                        <td>
                            {{$customField->field->name}}
                        </td>
                        <td>
                            @if($customField->mandatory == 1 && $customField->list_view == 2)
                            <button type="button" class="btn btn-light">{{'mandatory'}}</button>
                            <button type="button" class="btn btn-light">{{'list view'}}</button>
                            @elseif($customField->mandatory == 1)
                            <button type="button" class="btn btn-light">{{'mandatory'}}</button>
                            @elseif($customField->list_view == 2)
                            <button type="button" class="btn btn-light">{{'list view'}}</button>
                            @else

                            @endif
                        </td>
                        <td>
                            @if($customField->section_id == 1)
                            {{'Section 1'}}
                            @endif
                        </td>
                        <td>
                            <a href="#" data-id="{{ $customField->id }}" class="btn btn-sm btn-primary waves-effect waves-light editCustomFieldModel">
                                <i class="mdi mdi-square-edit-outline"></i>
                            </a>
                            <a href="{{ route('backend.setting-customfield-delete', ['id' => $customField->id, 'module_id' => $customField->module_id ]) }}" id="delete" class="btn btn-danger btn-sm">
                                <i class="mdi mdi-delete-outline"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Standard modal content -->
<div id="addCustomFieldModel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addcontact-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="customFieldFrom">
                <div class="modal-header">
                    <h4 class="modal-title" id="addcontact-modalLabel">Add new Custom Field</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label class="form-label">Select Module <span class="text-danger">*</span></label>
                        <select class="form-control" name="module_id">
                            <option value="">Select Module</option>
                            <option value="1">Client</option>
                            <option value="2" selected>Partner</option>
                            <option value="3">Product</option>
                            <option value="4">Application</option>
                        </select>
                        <span class="text-danger" id="moduleError"></span>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Section Name <span class="text-danger">*</span></label>
                        <select class="form-control" name="section_id">
                            <option value="">Select Name</option>
                            <option value="1">Section 1</option>
                        </select>
                        <span class="text-danger" id="sectionError"></span>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Custom Field Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="field_name">
                        <span class="text-danger" id="fieldnameError"></span>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Select Field Type <span class="text-danger">*</span></label>
                        <select class="form-control" name="field_id">
                            <option value="">Select Field Type</option>
                            <option value="1">Text</option>
                            <option value="2">Number</option>
                            <option value="3">Date</option>
                            <option value="4">Dropdown</option>
                        </select>
                        <span class="text-danger" id="fieldError"></span>
                    </div>
                    <div class="mb-2">
                        <div>
                            <input type="checkbox" id="mthis" name="mandatory" value="1">
                            <label class="form-label" for="mthis">Make this field mandatory</label>
                        </div>
                        <div>
                            <input type="checkbox" id="mthis2" name="list_view" value="2">
                            <label class="form-label" for="mthis2">Show this field on List View</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveCustomField">Save</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Standard modal content -->
<div id="updateCustomField" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="updateCustomFieldForm">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Edit New Custom Field</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body updateCustomFieldContent">

                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection

@section('script')
<script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
<script>
    $(document).ready(function() {

        $('#customField').on("click", function() {
            $('#addCustomFieldModel').modal("show");
        });

        $("#saveCustomField").click(function(e) {
            e.preventDefault();
            var serialize = $("#customFieldFrom").serialize();
            $.ajax({
                url: "{{ route('backend.setting-customfield-add') }}",
                type: "POST",
                data: serialize,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    $('#addTemplateModel').modal("hide");
                    window.location.reload();
                },
                error: function(response) {
                    $('#moduleError').text(response.responseJSON.errors.module_id);
                    $('#sectionError').text(response.responseJSON.errors.section_id);
                    $('#fieldnameError').text(response.responseJSON.errors.field_name);
                    $('#fieldError').text(response.responseJSON.errors.field_id);
                }
            });
        });

        $('.editCustomFieldModel').on("click", function() {

            $('#updateCustomField').modal("show");
            var customId = $(this).data('id');

            $.ajax({
                url: "{{ route('backend.setting-customfield-edit') }}",
                data: {
                    custom_id: customId,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response.customfield.mandatory);

                    var field = '';
                    for (var i = 0; i < response.field.length; i++) {
                        if (response.customfield.field_id == response.field[i].id) {
                            field += '<option value="' + response.field[i].id + '" selected>' + response.field[i].name + '</option>';
                        } else {
                            field += '<option value="' + response.field[i].id + '">' + response.field[i].name + '</option>';
                        }
                    }
                    var name = '';
                    if (response.customfield.section_id) {
                        name += '<option value="1" selected>Section 1</option>';
                    }

                    var mandatory = '';
                    if (response.customfield.mandatory == 1) {
                        mandatory = '<input type="checkbox" id="mthis" name="mandatory" value="1" checked>';
                    } else {
                        mandatory = '<input type="checkbox" id="mthis" name="mandatory" value="1">';
                    }

                    var listview = '';
                    if (response.customfield.list_view == 2) {
                        listview = '<input type="checkbox" id="mthis2" name="list_view" value="2" checked>';
                    } else {
                        listview = '<input type="checkbox" id="mthis2" name="list_view" value="2">';
                    }


                    var html = '';

                    html += '<input type="hidden" name="custom_id" value="' + response.customfield.id + '"><div class="mb-2"><label class="form-label">Select Module <span class="text-danger">*</span></label><select class="form-control" name="module_id"><option value="">Select Module</option><option value="1">Client</option><option value="2" selected>Partner</option><option value="3">Product</option><option value="4">Application</option></select><span class="text-danger moduleError"></span></div><div class="mb-2"><label class="form-label">Section Name <span class="text-danger">*</span></label><select class="form-control" name="section_id"><option value="">Select Name</option>' + name + '</select><span class="text-danger sectionError"></span></div><div class="mb-2"><label class="form-label">Custom Field Name <span class="text-danger">*</span></label><input type="text" class="form-control" name="field_name" value="' + response.customfield.field_name + '"><span class="text-danger fieldnameError"></span></div><div class="mb-2"><label class="form-label">Select Field Type <span class="text-danger">*</span></label><select class="form-control" name="field_id"><option value="">Select Field Type</option>' + field + '</select><span class="text-danger fieldError"></span></div><div class="mb-2"><div>' + mandatory + ' <label class="form-label" for="mthis"> Make this field mandatory</label></div><div> ' + listview + ' <label class="form-label" for="mthis2">Show this field on List View</label></div></div><button type="button" class="btn btn-primary px-5 w-100" id="update"> Update </button>';

                    $('.updateCustomFieldContent').html(html);

                    $('[data-toggle="select2"]').select2({
                        dropdownParent: $('#updateTemplate')
                    });

                }
            });

        });

        $(document).delegate('#update', 'click', function(e) {
            e.preventDefault();
            var serialize = $("#updateCustomFieldForm").serialize();
            $.ajax({
                url: "{{ route('backend.setting-customfield-update') }}",
                type: "POST",
                data: serialize,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    // alert(response);
                    $('#updateCustomField').modal("hide");
                    window.location.reload();
                },
                error: function(response) {
                    $('.moduleError').text(response.responseJSON.errors.module_id);
                    $('.sectionError').text(response.responseJSON.errors.section_id);
                    $('.fieldnameError').text(response.responseJSON.errors.field_name);
                    $('.fieldError').text(response.responseJSON.errors.field_id);
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
    });
</script>
@endsection