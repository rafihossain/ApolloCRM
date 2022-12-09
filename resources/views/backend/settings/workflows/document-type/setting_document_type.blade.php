@extends('backend.layouts.app')
@section('css')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" />
@endsection
@section('content')
<div class="card">
	<div class="card-body">
		<ul class="nav nav-tabs nav-bordered border-0">
			<li class="nav-item">
				<a href="{{ route('backend.setting-workflow') }}" class="nav-link">
					Workflow List
				</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('backend.setting-document-checklist') }}" class="nav-link">	
					Document Checklist
				</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('backend.setting-document-type') }}" class="nav-link active">			
					Document Type
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
	<div class="card-body table-responsive">
		<a href="javascript:void(0)" class="btn btn-outline-primary float-end" id="addDocumentType"> + Add</a>
		<table class="table">
			<thead>
				<tr>
					<th>Document Type</th>
					<th>Added Date</th>
					<th>Total Usage</th>
					<th>Added By</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach($documentTypes as $type)
				<tr>
					<td>{{ $type->type_name }}</td>
					<td>{{ $type->created_at }}</td>
					<td>3</td>
					<td>{{ $type->user->first_name.''.$type->user->last_name}}</td>
					<td><span class="badge bg-primary rounded-pill">Active</span></td>
					<td>
						<a href="javascript:void(0)" class="btn btn-sm btn-primary editDocumentTypeModel" data-id="{{ $type->id }}">
							<i class="mdi mdi-square-edit-outline"></i>
						</a>
						<a href="{{ route('backend.setting-document-type-delete', ['id'=> $type->id ]) }}" id="delete" class="btn btn-sm btn-danger">
							<i class="mdi mdi-delete-outline"></i>
						</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

<div id="addDocumentTypeModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addcontact-modalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="documentTypeFrom">
				<div class="modal-header">
					<h4 class="modal-title" id="addcontact-modalLabel"> Add New Document Type</h4>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="mb-2">
						<label class="form-label">Add New Document Type <span class="text-danger">*</span></label>
						<input type="text" class="inputtags form-control" name="type_name">
						<span class="text-danger" id="typenameError"></span>
					</div>
					<p><i class="mdi mdi-information-outline"></i> <em>The document type names can be seperated by “ Enter ”</em></p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="saveDocument">Submit</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Standard modal content -->
<div id="updateDocumentType" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="updateDocumentTypeForm">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Edit Document Type</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body updateDocumentTypeContent">

                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
<script>

	$('#addDocumentType').on("click", function() {
		$('#addDocumentTypeModal').modal("show");
	});

	$("#saveDocument").click(function(e) {
		e.preventDefault();
		var serialize = $("#documentTypeFrom").serialize();
		$.ajax({
			url: "{{ route('backend.setting-document-type-create') }}",
			type: "POST",
			data: serialize,
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			dataType: 'json',
			success: function(response) {
				$('#addDocumentTypeModal').modal("hide");
				window.location.reload();
			},
			error: function(response) {
				$('#typenameError').text(response.responseJSON.errors.type_name);
			}
		});
	});

	$('.editDocumentTypeModel').on("click", function() {

		$('#updateDocumentType').modal("show");
		var typeId = $(this).data('id');
		$.ajax({
			url: "{{ route('backend.setting-document-type-edit') }}",
			data: {
				type_id: typeId,
			},
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			dataType: 'json',
			success: function(response) {

				var html = '';

				html += '<input type="hidden" name="type_id" value="' + response.id + '"><div class="mb-2"><label class="form-label">Add New Document Type <span class="text-danger">*</span></label><input type="text" class="inputtags form-control" name="type_name" value="'+response.type_name+'"><span class="text-danger typenameError"></span></div><p><i class="mdi mdi-information-outline"></i> <em>The document type names can be seperated by “ Enter ”</em></p><button type="button" class="btn btn-primary px-5 w-100" id="update"> Update </button>';

				$('.updateDocumentTypeContent').html(html);
				$('.inputtags').tagsinput();

			}
		});

	});

	$(document).delegate('#update', 'click', function(e) {
		e.preventDefault();
		var serialize = $("#updateDocumentTypeForm").serialize();
		$.ajax({
			url: "{{ route('backend.setting-document-type-update') }}",
			type: "POST",
			data: serialize,
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			dataType: 'json',
			success: function(response) {
				// alert(response);
				$('#updateDocumentType').modal("hide");
				window.location.reload();
			},
			error: function(response) {
				$('.typenameError').text(response.responseJSON.errors.type_name);
			}
		});

	});

	$('.inputtags').tagsinput();

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
</script>
@endsection