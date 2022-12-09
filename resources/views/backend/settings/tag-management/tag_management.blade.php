@extends('backend.layouts.app')
@section('css')
<link rel="stylesheet" href="//unpkg.com/bootstrap-select-country@4.0.0/dist/css/bootstrap-select-country.min.css" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" />
@endsection
@section('content')
<div class="card">
	<div class="card-body">
		<button class="float-end btn btn-outline-primary" id="addtag">+ Add</button>
		<ul class="nav nav-tabs nav-bordered border-0">
			<li class="nav-item">
				<a href="javascript:;" class="nav-link active">
					Tag Management
				</a>
			</li>
		</ul>
	</div>
</div>
<div class="card">
	<div class="card-body">
		<table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
			<thead>
				<tr>
					<th>TAGS</th>
					<th>CREATED BY</th>
					<th>LAST UPDATED BY </th>
					<th>LAST UPDATED ON</th>
					<th>USAGE</th>
					<th>ACTION</th>
				</tr>
			</thead>
			<tbody>
				@foreach($tags as $tag)
				<tr>
					<td>{{ $tag->name }}</td>
					<td>{{ $tag->user->first_name.' '.$tag->user->last_name }}</td>
					<td>-</td>
					<td>-</td>
					<td>0</td>
					<td>
						<a href="javascript:void(0);" data-id="{{ $tag->id }}" class="btn btn-sm btn-primary editTagModel">
							<i class="mdi mdi-square-edit-outline"></i>
						</a>
						<a href="{{ route('backend.tag-management-delete', ['id' => $tag->id ]) }}" id="delete" class="btn btn-sm btn-danger">
							<i class="mdi mdi-delete-outline"></i>
						</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
<div id="addTagModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addcontact-modalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="tagFrom">
				<div class="modal-header">
					<h4 class="modal-title" id="addcontact-modalLabel"> Add New Custom Tag</h4>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="mb-2">
						<label class="form-label">Tag Name <span class="text-danger">*</span></label>
						<input type="text" class="inputtags form-control" name="name">
						<span class="text-danger" id="nameError"></span>
					</div>
					<p><i class="mdi mdi-information-outline"></i> <em>The tag names can be seperated by “ Enter ”</em></p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="saveTag">Submit</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Standard modal content -->
<div id="updateTag" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="updateTagForm">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Edit Tag</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body updateTagContent">

                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection

@section('script')
<script src="//unpkg.com/bootstrap-select-country@4.0.0/dist/js/bootstrap-select-country.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {

		$('#addtag').on("click", function() {
			$('#addTagModal').modal("show");
		});

		$("#saveTag").click(function(e) {
			e.preventDefault();
			var serialize = $("#tagFrom").serialize();
			$.ajax({
				url: "{{ route('backend.tag-management-create') }}",
				type: "POST",
				data: serialize,
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				dataType: 'json',
				success: function(response) {
					// console.log(response);
					$('#addTagModal').modal("hide");
					window.location.reload();
				},
				error: function(response) {
					// console.log(response);
					$('#nameError').text(response.responseJSON.errors.name);
				}
			});
		});

		$('.editTagModel').on("click", function() {

			$('#updateTag').modal("show");
			var tagId = $(this).data('id');
			// console.log(contactId);

			$.ajax({
				url: "{{ route('backend.tag-management-edit') }}",
				data: {
					tag_id: tagId,
				},
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				dataType: 'json',
				success: function(response) {

					var html = '';

					html += '<input type="hidden" name="tag_id" value="' + response.id + '"><div class="mb-2"><label class="form-label">Tag Name <span class="text-danger">*</span></label><input type="text" class="inputtags form-control" name="name" value="' + response.name + '"><span class="text-danger nameError"></span></div><p><i class="mdi mdi-information-outline"></i> <em>The tag names can be seperated by “ Enter ”</em></p><button type="button" class="btn btn-primary px-5 w-100" id="update"> Update </button>';

					$('.updateTagContent').html(html);
					$('.inputtags').tagsinput();

				}
			});

		});

		$(document).delegate('#update', 'click', function(e) {
			e.preventDefault();
			var serialize = $("#updateTagForm").serialize();
			$.ajax({
				url: "{{ route('backend.tag-management-update') }}",
				type: "POST",
				data: serialize,
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				dataType: 'json',
				success: function(response) {
					// alert(response);
					$('#updateTag').modal("hide");
					window.location.reload();
				},
				error: function(response) {
					$('.nameError').text(response.responseJSON.errors.name);
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

		$('.inputtags').tagsinput();
	});
</script>
@endsection