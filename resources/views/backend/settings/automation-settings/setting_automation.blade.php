@extends('backend.layouts.app')
@section('css')

@endsection
@section('content')

<div class="card">
	<div class="card-body overflowhidden">
		<a class="btn btn-primary float-end ms-2" href="javascript:;" id="addAutomation"> Add Automation </a>
	</div>
</div>

@if(Session::has('success'))
<div class="alert alert-success">
	{{ Session::get('success') }}
</div>
@endif

<div class="card">
	<div class="card-body">
		<div class="table-responsive">
			<table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
				<thead>
					<tr>
						<th>Automation Name</th>
						<th>Trigger</th>
						<th>Created By</th>
						<th>Office</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach($automations as $automation)
					<tr>
						<td>{{ $automation->automation_name }}</td>
						<td>Contact Visa Expiry Date </td>
						<td>
							<div class="overflow-hidden">
								<div class="float-start me-2">
									<img src="{{ asset($automation->user->avatar) }}" alt="user-img" title="Mat Helme" class="rounded-circle avatar-sm">
								</div>
								<div>
									<div class="text-truncate">
										<a href="{{ route('backend.manage-users') }}">
											{{ $automation->user->first_name.''.$automation->user->last_name }}
										</a>
									</div>
									<div class="text-truncate">
										<a href="#">{{ $automation->user->email }}</a>
									</div>
								</div>
							</div>
						</td>
						<td>{{ $automation->office->office_name }}</td>
						<td>
							@if($automation->status == 1)
								<span class="badge bg-success">Active</span>
							@else
								<span class="badge bg-danger">Dective</span>
							@endif
						</td>
						<td>
							<a href="javascript:void(0);" data-id="{{ $automation->id }}" class="btn btn-primary btn-sm editAutomationModel"><i class="mdi mdi-square-edit-outline"></i></a>
							<a href="#" class="btn btn-info btn-sm"><i class="mdi mdi-account-cancel-outline"></i></a>
							<a href="{{ route('backend.setting-automation-delete', ['id' => $automation->id ]) }}" id="delete" class="btn btn-danger btn-sm"><i class="mdi mdi-delete-outline"></i></a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>



<!-- Standard modal content -->
<div id="addAutomationModel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addcontact-modalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="automationFrom">
				<div class="modal-header">
					<h4 class="modal-title" id="addcontact-modalLabel">Add New Automation</h4>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="mb-2">
						<label class="form-label">Automation name <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="automation_name">
						<span class="text-danger" id="automationError"></span>
					</div>
					<div class="mb-2">
						<label class="form-label">For Office <span class="text-danger">*</span></label>
						<select class="form-control" name="office_id">
							<option value="">Select Office</option>
							@foreach($offices as $office)
								<option value="{{ $office->id }}">{{ $office->office_name }}</option>
							@endforeach
						</select>
						<span class="text-danger" id="officeError"></span>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="saveAutomation">Save</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Standard modal content -->
<div id="updateAutomation" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="updateAutomationForm">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Edit Automation</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body updateAutomationContent">

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

		$('#addAutomation').on("click", function() {
            $('#addAutomationModel').modal("show");
        });

        $("#saveAutomation").click(function(e) {
            e.preventDefault();
            var serialize = $("#automationFrom").serialize();
            $.ajax({
                url: "{{ route('backend.setting-automation-create') }}",
                type: "POST",
                data: serialize,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    $('#addAutomationModel').modal("hide");
                    window.location.reload();
                },
                error: function(response) {
                    $('#automationError').text(response.responseJSON.errors.automation_name);
                    $('#officeError').text(response.responseJSON.errors.office_id);
                }
            });

        });

        $('.editAutomationModel').on("click", function() {

            $('#updateAutomation').modal("show");
            var automationId = $(this).data('id');

            $.ajax({
                url: "{{ route('backend.setting-automation-edit') }}",
                data: {
                    automation_id: automationId,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {

                    var office = '';
                    for(var i = 0; i < response.offices.length; i++){
                        if(response.automation.office_id == response.offices[i].id){
                            office += '<option value="'+response.offices[i].id+'" selected>'+response.offices[i].office_name+'</option>';
                        }else{
                            office += '<option value="'+response.offices[i].id+'">'+response.offices[i].office_name+'</option>';
                        }
                    }

                    var status = '';
					if(response.automation.status == 1){
						var selected = 'selected';
					}else{
						var selected = '';
					}
					status += '<option value="1" '+selected+'>Active</option>';
					status += '<option value="2" '+selected+'>Deactive</option>';

                    var html = '';

                    html += '<input type="hidden" name="automation_id" value="'+response.automation.id+'"><div class="mb-2"><label class="form-label">Automation name <span class="text-danger">*</span></label><input type="text" class="form-control" name="automation_name" value="'+response.automation.automation_name+'"><span class="text-danger automationError"></span></div><div class="mb-2"><label class="form-label">For Office <span class="text-danger">*</span></label><select class="form-control" name="office_id"><option value="">Select Office</option>'+office+'</select><span class="text-danger officeError"></span></div><div class="mb-2"><label class="form-label">Status </label><select class="form-control" name="status"><option value="">Select Status</option>'+status+'</select></div><button type="button" class="btn btn-primary px-5 w-100" id="update"> Update </button>';

                    $('.updateAutomationContent').html(html);

                }
            });

        });

        $(document).delegate('#update', 'click', function(e) {
            e.preventDefault();
			var serialize = $("#updateAutomationForm").serialize();
            $.ajax({
                url: "{{ route('backend.setting-automation-update') }}",
                type: "POST",
                data: serialize,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    $('#addAutomationModel').modal("hide");
                    window.location.reload();
                },
                error: function(response) {
                    $('#automationError').text(response.responseJSON.errors.automation_name);
                    $('#officeError').text(response.responseJSON.errors.office_id);
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