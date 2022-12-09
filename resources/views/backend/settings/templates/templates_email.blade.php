@extends('backend.layouts.app')
@section('css')
 
@endsection	
@section('content') 

<div class="card">
	<div class="card-body overflowhidden">
		<button class="btn btn-primary float-end" id="addtemplate">Add</button>
		<ul class="nav nav-tabs nav-bordered border-0">  
            <li class="nav-item">
                <a href="{{ route('backend.setting-template-email') }}" class="nav-link active">
                    Email 
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('backend.setting-template-sms') }}" class="nav-link ">
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
	@foreach($mailtemplates as $mailtemplate)
	<div class="col-md-4">
		<div class="card">
			<div class="card-body">
				<div class="d-flex align-items-center">
					<h4 class="text-truncate">Visa Granted</h4>
					<div class="ms-auto" style="width: 34px; margin-left:5px;">
						<i class="mdi mdi-square-edit-outline text-primary editTemplateModel" data-id="{{ $mailtemplate->id }}"></i>
						<a href="{{ route('backend.template-email-delete', ['id' => $mailtemplate->id ]) }}" id="delete">
							<i class="mdi mdi-delete-outline text-danger"></i>
						</a>
					</div>
				</div>
				<p class="m-0"><strong>{{ $mailtemplate->title }}</strong></p>
				<hr>
				<p>{{ $mailtemplate->subject }}</p>
				{!! $mailtemplate->body !!}
			</div>
			<div class="card-footer">
				@if($mailtemplate->documents) 
					<i class="mdi mdi-attachment"></i>
					<a href="{{ asset($mailtemplate->documents) }}" target="_blank">
						Attachment
					</a>
				@endif
			</div>
		</div>
	</div>
	@endforeach
</div>

<!-- Standard modal content -->
<div id="addTemplateModel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addcontact-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="templateForm" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title" id="addcontact-modalLabel">Add Email Template</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="title">
						<span class="text-danger" id="titleError"></span>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Subject <span class="text-danger">*</span></label>
                        <select class="form-control subjectPlaceholder">
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
						<textarea name="subject" class="form-control subject"></textarea>
                        <span class="text-danger" id="subjectError"></span>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Body <span class="text-danger">*</span></label>
						<select class="form-control bodyPlaceholder">
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
						<textarea id="summereditor" name="body"></textarea>
                        <span class="text-danger" id="bodyError"></span>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">document </label>
                        <input type="file" class="dropify" name="documents">
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
            <form id="updateTemplateForm" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Edit Email Template</h4>
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
<script type="text/javascript">
	$(document).ready(function() {

		$('.subjectPlaceholder').on("change", function() {
            var placeholder = $(this).val();
			$('.subject').append(placeholder);
        });		

		$('.bodyPlaceholder').on("change", function() {
            var placeholder = $(this).val();
			$('#summereditor').summernote('editor.insertText', placeholder);
        });

		$('#addtemplate').on("click", function() {
            $('#addTemplateModel').modal("show");
        });

        $("#saveTemplate").click(function(e) {
            e.preventDefault();
			var fromData = new FormData(document.getElementById("templateForm"));
            $.ajax({
                url: "{{ route('backend.template-email-create') }}",
                type: "POST",
                data: fromData,
				cache:false,
                contentType: false,
                processData: false,
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
                    $('#subjectError').text(response.responseJSON.errors.subject);
                    $('#bodyError').text(response.responseJSON.errors.body);
                }
            });
        });

        $('.editTemplateModel').on("click", function() {

            $('#updateTemplate').modal("show");
            var templateId = $(this).data('id');

            $.ajax({
                url: "{{ route('backend.template-email-edit') }}",
                data: {
                    template_id: templateId,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {

					var url = '';
                    var imagePath = '';
                    if(response.documents){
                        url = $('meta[name="base_url"]').attr('content');
                        imagePath = url+'/'+response.documents;
                    }

                    var html = '';

                    html += '<input type="hidden" name="template_id" value="'+response.id+'"><div class="mb-2"><label class="form-label">Title <span class="text-danger">*</span></label><input type="text" class="form-control" name="title" value="'+response.title+'"><span class="text-danger titleError"></span></div><div class="mb-2"><label class="form-label">Subject <span class="text-danger">*</span></label><select class="form-control subjectPlaceholder"><option value="">Select Placeholder</option><option value="{Client First Name}">Client First Name</option><option value="{Client Last Name}">Client Last Name</option><option value="{Client Date of birth}">Client Date of birth</option><option value="{Client Phone}">Client Phone</option><option value="{Client Email}">Client Email</option><option value="{Client Full Address}">Client Full Address</option><option value="{Client City}">Client City</option><option value="{Client Nation Name}">Client Nation Name</option><option value="{Client Visa Expiry Date}">Client Visa Expiry Date</option><option value="{Client Assignee Name}">Client Assignee Name</option><option value="{Client Id}">Client Id</option><option value="{Internal Id}">Internal Id</option><option value="{Company Name}">Company Name</option></select><textarea name="subject" class="form-control subject">'+response.subject+'</textarea><span class="text-danger subjectError"></span></div><div class="mb-2"><label class="form-label">Body <span class="text-danger">*</span></label><select class="form-control bodyPlaceholder"><option value="">Select Placeholder</option><option value="{Client First Name}">Client First Name</option><option value="{Client Last Name}">Client Last Name</option><option value="{Client Date of birth}">Client Date of birth</option><option value="{Client Phone}">Client Phone</option><option value="{Client Email}">Client Email</option><option value="{Client Full Address}">Client Full Address</option><option value="{Client City}">Client City</option><option value="{Client Nation Name}">Client Nation Name</option><option value="{Client Visa Expiry Date}">Client Visa Expiry Date</option><option value="{Client Assignee Name}">Client Assignee Name</option><option value="{Client Id}">Client Id</option><option value="{Internal Id}">Internal Id</option><option value="{Company Name}">Company Name</option></select><textarea class="summereditor" name="body">'+response.body+'</textarea><span class="text-danger bodyError"></span></div><div class="mb-2"><label class="form-label">document </label><input type="file" class="dropify" name="documents" data-height="90" data-default-file="'+imagePath+'"></div><button type="button" class="btn btn-primary px-5 w-100" id="update"> Update </button>';

                    $('.updateTemplateContent').html(html);

                    $('[data-toggle="select2"]').select2({
                        dropdownParent: $('#updateTemplate')
                    });
                    $('.summereditor').summernote();
					$('.dropify').dropify();

					$('.subjectPlaceholder').on("change", function() {
						var placeholder = $(this).val();
						$('.subject').append(placeholder);
					});

					$('.bodyPlaceholder').on("change", function() {
						var placeholder = $(this).val();
						$('.summereditor').summernote('editor.insertText', placeholder);
					});

                }
            });

        });

        $(document).delegate('#update', 'click', function(e) {
            e.preventDefault();
			var fromData = new FormData(document.getElementById("updateTemplateForm"));
            $.ajax({
                url: "{{ route('backend.template-email-update') }}",
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
                    // alert(response);
                    $('#updateTemplate').modal("hide");
                    window.location.reload();
                },
                error: function(response) {
                    $('.titleError').text(response.responseJSON.errors.title);
                    $('.subjectError').text(response.responseJSON.errors.subject);
                    $('.bodyError').text(response.responseJSON.errors.body);
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


		$('#summereditor').summernote({
			height: 300,
		});
		$('.dropify').dropify();
		$('[data-toggle="select2"]').select2({
			dropdownParent: $('#addTemplateModel')
		});


	});
</script>
@endsection