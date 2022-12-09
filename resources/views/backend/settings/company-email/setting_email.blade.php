@extends('backend.layouts.app')
@section('css')
 
@endsection	
@section('content') 
 
<div class="card">
	<div class="card-body"> 
		<div class="mb-3 text-end">
			<button class="btn btn-primary" id="addEmail">Add</button>
		</div>
		 				
		<table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
			<thead>
				<tr> 
					<th>Email id</th>
					<th>Agentcis Email</th>
					<th>User Sharing</th>
					<th>Signature</th>
					<th>Status</th> 
					<th>Action</th> 
				</tr>
			</thead>
			<tbody>
                @foreach($companyEmails as $email)
				<tr>
					<td>{{ $email->email_id }}</td>
					<td>
						<div class="text-truncate " style="max-width: 200px">
							<div>{{ $email->email_id }}</div>
						</div>
					</td>
					<td>
						{{ $email->display_name }}
					</td>
					<td>
                        @if($email->email_singature)
                            {{ 'Yes' }}
                        @else
                            {{ 'No' }}
                        @endif
                    </td>
					<td>
                        @if($email->status == 1)
                            <span class="badge bg-primary">Active</span>
                        @else
                            <span class="badge bg-warning">Deactive</span>
                        @endif
                    </td>
					<td>
						<div class="dropdown float-end">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end"> 
                                <a href="javascript:void(0);" data-id="{{ $email->id }}" class="dropdown-item editEmailModel">Edit</a> 
                                <a href="javascript:void(0);" class="dropdown-item">Copy Agentcis Email</a>
                                @if($email->status == 1)
                                    <a href="{{ route('backend.setting-email-deactive', ['id' => $email->id ]) }}" id="deactive" class="dropdown-item">
                                        Deactivate
                                    </a>
                                @else
                                    <a href="{{ route('backend.setting-email-active', ['id' => $email->id ]) }}" id="active" class="dropdown-item">
                                        Activate
                                    </a>
                                @endif
                                <a href="{{ route('backend.setting-email-delete', ['id' => $email->id ]) }}" id="delete" class="dropdown-item">Delete</a>
                            </div>
                        </div>
					</td>
				</tr>
                @endforeach
			</tbody>
		</table>
	</div>
</div>


<!-- Standard modal content -->
<div id="addEmailModel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addcontact-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="emailFrom">
                <div class="modal-header">
                    <h4 class="modal-title" id="addcontact-modalLabel">Add Company Email Setting</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   	<h4>Mail Setup</h4>  
                    <div class="mb-2">
                        <label class="form-label">Email Id <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="email_id" placeholder="personal@gmail.com">
                        <span class="text-danger" id="emailError"></span>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Status</label>
                        <div class="form-check">
                            <input type="hidden" name="status" value="0">
                            <input type="checkbox" name="status" class="form-check-input" id="emailstatus">
                            <label class="form-check-label" for="emailstatus">Enable This Feature</label>
                        </div> 
                    </div>
                    <div class="mb-2">
                    	<label class="form-label">Incoming Emails</label>
                    	<div>
                            <div class="form-check">
                                <input type="hidden" name="incoming_email" value="0">
                                <input type="radio" name="incoming_email" class="form-check-input" id="IncomingEmails" value="1">
                                <label class="form-check-label" for="IncomingEmails">Allow all inbox emails</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="incoming_email" class="form-check-input" id="IncomingEmails2" value="2">
                                <label class="form-check-label" for="IncomingEmails2">Allow only Agentcis associated emails</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-2">
                    	<label class="form-label">Display Name</label>
                    	<input type="text" class="form-control" name="display_name">
                    	<p><i class="mdi mdi-information-outline"></i><small><em>The recipient will see the display name as sender's name.</em></small></p>
                    </div>
                    <h4>User Sharing</h4>
                    <div class="mb-2">
                    	<label class="form-label">Select Users <span class="text-danger">*</span></label> 
                    	<select class="form-control" name="user_id" data-toggle="select2" data-width="100%" placeholder="Choose Fee Type"> 
                            <option value="">Selecte User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->first_name.''.$user->last_name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger" id="userError"></span>
                    </div>
                    <div class="mb-2">
                    	<label class="form-label">Company Email Signature</label>
                        <textarea id="summereditor" name="email_singature"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveEmail">Save</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Standard modal content -->
<div id="updateEmail" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="updateEmailForm">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Edit Email</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body updateEmailContent">

                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection

@section('script')
<script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {

        $('#addEmail').on("click", function() {
            $('#addEmailModel').modal("show");
        });

        $("#saveEmail").click(function(e) {
            e.preventDefault();
            var serialize = $("#emailFrom").serialize();
            $.ajax({
                url: "{{ route('backend.setting-email-create') }}",
                type: "POST",
                data: serialize,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    $('#addEmailModel').modal("hide");
                    window.location.reload();
                },
                error: function(response) {
                    $('#emailError').text(response.responseJSON.errors.email_id);
                    $('#userError').text(response.responseJSON.errors.user_id);
                }
            });
        });

        $('.editEmailModel').on("click", function() {

            $('#updateEmail').modal("show");
            var emailId = $(this).data('id');

            $.ajax({
                url: "{{ route('backend.setting-email-edit') }}",
                data: {
                    email_id: emailId,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {

                    var users = '';
                    for (var i = 0; i < response.users.length; i++) {
                        if (response.companyemail.user_id == response.users[i].id) {
                            users += '<option value="' + response.users[i].id + '" selected>' + response.users[i].first_name + ' ' + response.users[i].last_name + '</option>';
                        } else {
                            users += '<option value="' + response.users[i].id + '">' + response.users[i].first_name + ' ' + response.users[i].last_name + '</option>';
                        }
                    }

                    var allemail = '';
                    if(response.companyemail.incoming_email == 1){
                       allemail = '<input type="radio" name="incoming_email" class="form-check-input" id="IncomingEmails" value="1" checked>';
                    }else{
                       allemail = '<input type="radio" name="incoming_email" class="form-check-input" id="IncomingEmails" value="1">';
                    }

                    var onlyagentcis = '';
                    if(response.companyemail.incoming_email == 2){
                        onlyagentcis = '<input type="radio" name="incoming_email" class="form-check-input" id="IncomingEmails2" value="2" checked>';
                    }else{
                        onlyagentcis = '<input type="radio" name="incoming_email" class="form-check-input" id="IncomingEmails2" value="2">';
                    }

                    var status = '';
                    if(response.companyemail.status == 1){
                        status = '<input type="checkbox" name="status" class="form-check-input" id="emailstatus" value="1" checked>';
                    }else{
                        status = '<input type="checkbox" name="status" class="form-check-input" id="emailstatus" value="1">';
                    }

                    var html = '';

                    html += '<input type="hidden" name="company_id" value="' + response.companyemail.id + '"><h4>Mail Setup</h4><div class="mb-2"><label class="form-label">Email Id <span class="text-danger">*</span></label><input type="text" class="form-control" name="email_id" value="' + response.companyemail.email_id + '"><span class="text-danger emailError"></span></div><div class="mb-2"><label class="form-label">Status</label><div class="form-check"><input type="hidden" name="status" value="0">'+status+'<label class="form-check-label" for="emailstatus">Enable This Feature</label></div></div><div class="mb-2"><label class="form-label">Incoming Emails</label><div><div class="form-check"><input type="hidden" name="incoming_email" value="0">'+allemail+'<label class="form-check-label" for="IncomingEmails">Allow all inbox emails</label></div><div class="form-check">'+onlyagentcis+'<label class="form-check-label" for="IncomingEmails2">Allow only Agentcis associated emails</label></div></div></div><div class="mb-2"><label class="form-label">Display Name</label><input type="text" class="form-control" name="display_name" value="' + response.companyemail.display_name + '"><p><i class="mdi mdi-information-outline"></i><small><em>The recipient will see the display name as sender name.</em></small></p></div><h4>User Sharing</h4><div class="mb-2"><label class="form-label">Select Users <span class="text-danger">*</span></label><select class="form-control" name="user_id" data-toggle="select2" data-width="100%" placeholder="Choose Fee Type"><option value="">Selecte User</option>'+users+'</select><span class="text-danger userError"></span></div><div class="mb-2"><label class="form-label">Company Email Signature</label><textarea class="summereditor" name="email_singature">' + response.companyemail.email_singature + '</textarea></div><button type="button" class="btn btn-primary px-5 w-100" id="update"> Update </button>';

                    $('.updateEmailContent').html(html);

                    $('[data-toggle="select2"]').select2({
                        dropdownParent: $('#updateEmail')
                    });
                    $('.summereditor').summernote();

                }
            });

        });

        $(document).delegate('#update', 'click', function(e) {
            e.preventDefault();
            var serialize = $("#updateEmailForm").serialize();
            $.ajax({
                url: "{{ route('backend.setting-email-update') }}",
                type: "POST",
                data: serialize,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    // alert(response);
                    $('#updateEmailForm').modal("hide");
                    window.location.reload();
                },
                error: function(response) {
                    $('.emailError').text(response.responseJSON.errors.email_id);
                    $('.userError').text(response.responseJSON.errors.user_id);
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

        //deactive sweetalert
        $(document).on('click', '#deactive', function(e) {
            e.preventDefault();
            var Id = $(this).attr('href');

            swal({
                    title: "Are you sure?",
                    text: "You want to deactive!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        swal("Successfully deactivated!", {
                            icon: "success",
                        });
                        window.location.href = Id;
                    } else {
                        swal("safe!");
                    }
                });
        });
        //active sweetalert
        $(document).on('click', '#active', function(e) {
            e.preventDefault();
            var Id = $(this).attr('href');

            swal({
                    title: "Are you sure?",
                    text: "You want to active!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        swal("Successfully activated!", {
                            icon: "success",
                        });
                        window.location.href = Id;
                    } else {
                        swal("safe!");
                    }
                });
        });

        $('[data-toggle="select2"]').select2({
            dropdownParent: $('#addEmailModel')
        });
         $('#summereditor').summernote();
     });
</script>
@endsection