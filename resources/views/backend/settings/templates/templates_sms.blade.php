@extends('backend.layouts.app')
@section('css')

@endsection
@section('content')

<div class="card">
    <div class="card-body overflowhidden">
        <button type="button" class="btn btn-primary float-end" id="addtemplate">Add</button>

        <ul class="nav nav-tabs nav-bordered border-0">
            <li class="nav-item">
                <a href="{{ route('backend.setting-template-email') }}" class="nav-link ">
                    Email
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('backend.setting-template-sms') }}" class="nav-link active">
                    SMS
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

<div class="row">
    @foreach($smstemplates as $smstemplate)
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <h4 class="text-truncate">{{ $smstemplate->title }}</h4>
                    <div class="ms-auto" style="width: 34px; margin-left:5px;">
                        <i class="mdi mdi-square-edit-outline text-primary editTemplateModel" data-id="{{ $smstemplate->id }}"></i>
                        <a href="{{ route('backend.template-sms-delete', ['id' => $smstemplate->id ]) }}" id="delete">
                            <i class="mdi mdi-delete-outline text-danger"></i>
                        </a>
                    </div>
                </div>
                <hr>
                <p>{!! $smstemplate->text_message !!}</p>
            </div>
        </div>
    </div>
    @endforeach

</div>

<!-- Standard modal content -->
<div id="addTemplateModel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addcontact-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="templateForm">
                <div class="modal-header">
                    <h4 class="modal-title" id="addcontact-modalLabel">Add SMS Template</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-2">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="title">
                        <span class="text-danger" id="titleError"></span>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Text Message <span class="text-danger">*</span></label>
                        <select class="form-control messagePlaceholder">
                            <option value="">Select Placeholder</option>
                            <option value="{Client First Name}">Client First Name</option>
                            <option value="{Client Last Name}">Client Last Name</option>
                            <option value="{Client Date of birth}">Client Date of birth</option>
                            <option value="{Client Phone}">Client Phone</option>
                            <option value="{Client Email}">Client Email</option>
                            <option value="{Client Full Address}">Client Full Address</option>
                            <option value="{Client City}">Client City</option>
                            <option value="{Client Nation Name}">Client Nation Name</option>
                            <option value="{Client Visa Expiry Date}">Client Visa Expiry Date</option>
                            <option value="{Client Assignee Name}">Client Assignee Name</option>
                            <option value="{Client Id}">Client Id</option>
                            <option value="{Internal Id}">Internal Id</option>
                            <option value="{Company Name}">Company Name</option>
                        </select>
                        <textarea id="summereditor" name="text_message"></textarea>
                        <span class="text-danger" id="messageError"></span>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveTemplate">Save</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Standard modal content -->
<div id="updateTemplate" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="updateTemplateForm">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Edit Sms Template</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body updateTemplateContent">

                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
    $(document).ready(function() {

        $('.messagePlaceholder').on("change", function() {
            var placeholder = $(this).val();
            $('#summereditor').summernote('editor.insertText', placeholder);
        });

        $('#addtemplate').on("click", function() {
            $('#addTemplateModel').modal("show");
        });

        $("#saveTemplate").click(function(e) {
            e.preventDefault();
            var serialize = $("#templateForm").serialize();
            $.ajax({
                url: "{{ route('backend.template-sms-create') }}",
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
                    $('#titleError').text(response.responseJSON.errors.title);
                    $('#messageError').text(response.responseJSON.errors.text_message);
                }
            });
        });

        $('.editTemplateModel').on("click", function() {

            $('#updateTemplate').modal("show");
            var templateId = $(this).data('id');

            $.ajax({
                url: "{{ route('backend.template-sms-edit') }}",
                data: {
                    template_id: templateId,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {

                    var html = '';

                    html += '<input type="hidden" name="template_id" value="'+response.id+'"><div class="mb-2"><label class="form-label">Title <span class="text-danger">*</span></label><input type="text" class="form-control" name="title" value="'+response.title+'"><span class="text-danger titleError"></span></div><div class="mb-2"><label class="form-label">Text Message <span class="text-danger">*</span></label><select class="form-control messagePlaceholder"><option value="">Select Placeholder</option><option value="{Client First Name}">Client First Name</option><option value="{Client Last Name}">Client Last Name</option><option value="{Client Date of birth}">Client Date of birth</option><option value="{Client Phone}">Client Phone</option><option value="{Client Email}">Client Email</option><option value="{Client Full Address}">Client Full Address</option><option value="{Client City}">Client City</option><option value="{Client Nation Name}">Client Nation Name</option><option value="{Client Visa Expiry Date}">Client Visa Expiry Date</option><option value="{Client Assignee Name}">Client Assignee Name</option><option value="{Client Id}">Client Id</option><option value="{Internal Id}">Internal Id</option><option value="{Company Name}">Company Name</option></select><textarea name="text_message" class="form-control summereditor">'+response.text_message+'</textarea><span class="text-danger messageError"></span></div><button type="button" class="btn btn-primary px-5 w-100" id="update"> Update </button>';

                    $('.updateTemplateContent').html(html);

                    $('.messagePlaceholder').on("change", function() {
                        var placeholder = $(this).val();
                        $('.summereditor').summernote('editor.insertText', placeholder);
                    });

                    $('[data-toggle="select2"]').select2({
                        dropdownParent: $('#updateTemplate')
                    });
                    $('.summereditor').summernote();


                }
            });

        });

        $(document).delegate('#update', 'click', function(e) {
            e.preventDefault();
            var serialize = $("#updateTemplateForm").serialize();
            $.ajax({
                url: "{{ route('backend.template-sms-update') }}",
                type: "POST",
                data: serialize,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    $('#updateTemplate').modal("hide");
                    window.location.reload();
                },
                error: function(response) {
                    $('.titleError').text(response.responseJSON.errors.title);
                    $('.messageError').text(response.responseJSON.errors.text_message);
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

        $('#summereditor').summernote();

    });
</script>
@endsection