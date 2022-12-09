@extends('backend.layouts.app')
@section('content')
<div class="card">
            <div class="card-body"> 
                <h4 class="m-0 header-title text-end float-end"> 
                    <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#InviteUser" href="javascript:;" href="{{ route('backend.create-users') }}">+ Invite User</a>
                </h4>
                <ul class="nav nav-tabs nav-bordered border-0"> 
                    <li class="nav-item">
                        <a href="{{ route('backend.manage-users') }}" class="nav-link">
                            Active 
                        </a>
                    </li> 
                    <li class="nav-item">
                        <a href="{{route('backend.usersinactive')}}" class="nav-link active">
                            Inactive
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('backend.usersinvited') }}" class="nav-link ">
                            Invited
                        </a>
                    </li> 
                    
                </ul>
            </div>
</div>
<div class="row">
    <div class="col-12">
        @if(Session::has('success'))
        <div class="alert alert-success" style="text-align: center;">
            {{ Session::get('success') }}
        </div>
        @endif
        <div class="card">
            <div class="card-body table-responsive">
                <table id="datatable" class="table table-bordered table-bordered dt-responsive nowrap">
                    <thead>
                        <tr>
                            <th>NAME</th>
                            <th>POSITION</th>
                            <th>OFFICE</th>
                            <th>ROLE</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($manageUsers as $user)
                        <tr>
                            <td>
                              <div class="overflow-hidden">
                                    <div class="float-start me-2">
                                       @if($user->profile_image)  
                                        <img src="{{asset('images/user/thumbnail/'.$user->profile_image)}}" alt="user-img" title="Mat Helme" class="rounded-circle img-thumbnail avatar-md">
                                       @else
                                        <img src="{{asset('images/user/default.jpg')}}" alt="user-img" title="Mat Helme" class="rounded-circle img-thumbnail avatar-md">    
                                       @endif 
                                    </div>
                                    <div>
                                        <div class="text-truncate">
                                            <a href="{{route('backend.usersdetails',$user->id)}}">
                                            {{ $user->first_name.' '.$user->last_name; }}
                                            </a>
                                        </div>
                                        <div class="text-truncate">
                                            <a href="mailto:{{$user->email}}">{{$user->email}}</a>
                                        </div>
                                    </div>
                                </div> 
                        
                            </td>
                            <td>{{ $user->position }}</td>
                            <td>{{ $user->office->office_name }}</td>
                            <td>{{ $user->role->name }}</td>

                            <td>

                                <a href="{{route('backend.edit-users',$user->id)}}" class="btn btn-sm btn-primary waves-effect waves-light"><i class="mdi mdi-square-edit-outline"></i></a>
                                <a href="{{route('backend.user_active',$user->id)}}" class="btn btn-success btn-sm" id="user_active"><i class="mdi mdi-account-cancel-outline"></i></a>
                                <!-- <a href="{{route('backend.delete-users',$user->id) }}" id="delete" class="btn btn-sm btn-danger waves-effect waves-light"><i class="mdi mdi-trash-can-outline"></i></a> -->
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> <!-- end row -->



 <!-- Standard modal content -->
 <div id="InviteUser" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addcontact-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="user_form_submit">
                <div class="modal-header">
                    <h4 class="modal-title" id="addcontact-modalLabel">Invite User</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{old('first_name')}}">
                            <span class="text-danger" id="first_name"></span>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{old('last_name')}}">
                            <span class="text-danger" id="last_name"></span>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{old('email')}}">
                            <span class="text-danger" id="email"></span>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{old('phone')}}">
                            @error('city')
                            <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Position Title</label>
                            <input type="text" class="form-control @error('position_title') is-invalid @enderror" name="position_title" value="{{old('position_title')}}">
                            @error('position_title')
                            <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Role</label>
                            <select class="form-control @error('role') is-invalid @enderror" name="role" id="">
                                <option value="">Select Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="role"></span>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Office</label>
                            <select class="form-control @error('office') is-invalid @enderror" name="office" id="">
                            <option value="">Select Office</option>
                            @foreach($offices as $office)
                                <option value="{{ $office->id }}">{{ $office->office_name }}</option>
                            @endforeach
                            </select>
                            <span class="text-danger" id="office"></span>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Image</label>
                            <input type="file" class="form-control @error('user_image') is-invalid @enderror" name="profile_image" value="{{old('user_image')}}">
                            @error('user_image')
                            <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-2">
                        <label>Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                        value="{{old('password')}}">
                        <span class="text-danger" id="password"></span>
                    </div>    
                    <div class="col-md-6 mb-2">
                        <label>Confirm Password</label>
                        <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" name="password_confirmation"
                        value="{{old('password_confirmation')}}">
                        <span class="text-danger" id="password_confirmation"></span>
                    </div>
                    </div>
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary user_submit">Invite  </button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->




@endsection

@section('script')
<script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
<script>


    $('.user_submit').click(function(e){     
        e.preventDefault();
        $('#first_name').text('');
        $('#last_name').text('');
        $('#email').text('');
        $('#role').text('');
        $('#office').text('');
        $('#password').text('');
        $('#password_confirmation').text('');    
        var fromData = new FormData(document.getElementById("user_form_submit"));
            $.ajax({
                url: "{{route('backend.save-users')}}",
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
                    $('#InviteUser').modal("hide");
                    window.location.reload();
                },
                error: function(response) {
                    //console.log(response);
                    $('#first_name').text(response.responseJSON.errors.first_name);
                    $('#last_name').text(response.responseJSON.errors.last_name);
                    $('#email').text(response.responseJSON.errors.email);
                    $('#role').text(response.responseJSON.errors.role);
                    $('#office').text(response.responseJSON.errors.office);
                    $('#password').text(response.responseJSON.errors.password);
                    $('#password_confirmation').text(response.responseJSON.errors.password_confirmation);
                }
            });
    })
   
    //user delete-----------------
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

    //user inactive-----------------
    $(document).on('click', '#user_active', function(e) {
        e.preventDefault();
        var Id = $(this).attr('href');

        swal({
                title: "Are you sure?",
                text: "do you want to inactive!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    swal("Successfully active!", {
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