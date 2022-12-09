@extends('backend.layouts.app')
@section('css')
<link href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/libs/clockpicker/bootstrap-clockpicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
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
        <div class="text-end mb-3">
            <button type="button" class="btn btn-primary" id="addtask">+ Add</button>
        </div>
        <div class="card">
            <div class="card-body">
                <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Task Title</th>
                            <th>Attachment</th>
                            <th>Priority</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tasks as $task)
                        <tr>
                            <td><input type="checkbox" value="1" name="" checked=""></td>
                            <td>{{ $task->title }}</td>
                            <td><a href="{{ asset($task->attachment) }}" target="_blank"><i class="mdi mdi-attachment"></i></a></td>
                            <td>Low</td>
                            <td>
                                <span class="badge bg-light text-dark rounded-pill"><i class="mdi mdi-clock"></i> {{ $task->due_date }}</span>
                            </td>
                            <td>
                                @if($task->status == 1)
                                <span class="badge bg-info rounded-pill">To Do</span>
                                @elseif($task->status == 2)
                                <span class="badge bg-warning rounded-pill">In Progress</span>
                                @elseif($task->status == 3)
                                <span class="badge bg-primary rounded-pill">On Review</span>
                                @elseif($task->status == 4)
                                <span class="badge bg-success rounded-pill">Complete</span>
                                @else
                                <span class="badge bg-white rounded-pill">No Status</span>
                                @endif
                            </td>
                            <td>
                                <a href="javascript:void(0);" data-id="{{ $task->id }}" data-client="{{ $task->client_id }}" class="btn btn-sm btn-primary waves-effect waves-light editTaskModel"><i class="mdi mdi-square-edit-outline"></i></a>
                                <a href="{{ route('backend.deleteclient-task', ['id' => $task->id, 'client_id'=> $task->client_id ]) }}" id="delete" class="btn btn-danger btn-sm"><i class="mdi mdi-delete-outline"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!-- Right modal content -->
<div id="addTaskModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="taskFrom" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Create New Task</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="client_id" value="{{ $client->id }}">

                        <div class="col-md-6 mb-2">
                            <label class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="title">
                            <span class="text-danger" id="titleError"></span>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Category <span class="text-danger">*</span></label>
                            <select class="form-control" name="category_id">
                                <option value="">Choose Category</option>
                                @foreach($taskCategories as $taskCategory)
                                <option value="{{ $taskCategory->id }}">{{ $taskCategory->task_name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="categoryError"></span>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Assignee</label>
                            <select class="form-control" name="assigee_id">
                                <option value="">Choose Assignee</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}">{{$user->first_name.' '.$user->last_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Priority</label>
                            <select class="form-control" name="priority_id">
                                <option value="">Choose Assignee</option>
                                @foreach($priorityCategories as $priorityCategory)
                                <option value="{{ $priorityCategory->id }}">{{ $priorityCategory->priority_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label class="form-label">Due Date</label>
                            <input type="text" id="datetime-datepicker" class="form-control" placeholder="Date and Time" name="due_date">
                        </div>
                        <div class="col-md-12 mb-2">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" rows="4" name="description"></textarea>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label class="form-label">Attachments:</label>
                            <input type="file" class="dropify" name="attachment" data-height="90">
                        </div>
                        <div class="col-md-12 mb-2">
                            <label class="form-label">Followers</label>
                            <select class="form-control" name="follower_id">
                                <option value="">Choose Assignee</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}">{{$user->first_name.' '.$user->last_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label class="form-label">Status</label>
                            <select class="form-control" name="status">
                                <option value="">Choose Status</option>
                                <option value="1">To Do</option>
                                <option value="2">In Progress</option>
                                <option value="3">On Review</option>
                                <option value="4">Complete</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveTask">Save</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- Standard modal content -->

<!-- Standard modal content -->
<div id="updateTask" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="updateTaskForm" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Edit Task</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body updateTaskContent">

                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection

@section('script')
<!-- Datatables init -->
<script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
<script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ asset('assets/libs/spectrum-colorpicker2/spectrum.min.js') }}"></script>
<script src="{{ asset('assets/libs/clockpicker/bootstrap-clockpicker.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>

<!-- Init js-->

<script type="text/javascript">
    $(document).ready(function() {
        $('#addtask').on("click", function() {
            $('#addTaskModal').modal("show");
        });

        $("#saveTask").click(function(e) {
            e.preventDefault();
            var fromData = new FormData(document.getElementById("taskFrom"));
            $.ajax({
                url: "{{ route('backend.addclient-task') }}",
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
                    // console.log(response);
                    $('#addTaskModal').modal("hide");
                    window.location.reload();
                },
                error: function(response) {
                    // console.log(response);
                    $('#titleError').text(response.responseJSON.errors.title);
                    $('#categoryError').text(response.responseJSON.errors.category_id);
                }
            });

        });

        $('.editTaskModel').on("click", function() {

            $('#updateTask').modal("show");
            var taskId = $(this).data('id');
            var clientId = $(this).data('client');
            // console.log(contactId);

            $.ajax({
                url: "{{ route('backend.editclient-task') }}",
                type: "POST",
                data: {
                    task_id: taskId,
                    client_id: clientId,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {

                    var users = '';
                    for(var i = 0; i < response.users.length; i++){
                        if(response.task.assigee_id == response.users[i].id){
                            users += '<option value="'+response.users[i].id+'" selected>'+response.users[i].first_name+' '+response.users[i].last_name+'</option>';
                        }else{
                            users += '<option value="'+response.users[i].id+'">'+response.users[i].first_name+' '+response.users[i].last_name+'</option>';
                        }
                    }
                    var taskcategories = '';
                    for(var i = 0; i < response.taskcategories.length; i++){
                        if(response.task.category_id == response.taskcategories[i].id){
                            taskcategories += '<option value="'+response.taskcategories[i].id+'" selected>'+response.taskcategories[i].task_name+'</option>';
                        }else{
                            taskcategories += '<option value="'+response.taskcategories[i].id+'">'+response.taskcategories[i].task_name+'</option>';
                        }
                    }
                    var priorities = '';
                    for(var i = 0; i < response.priorities.length; i++){
                        if(response.task.priority_id == response.priorities[i].id){
                            priorities += '<option value="'+response.priorities[i].id+'" selected>'+response.priorities[i].priority_name+'</option>';
                        }else{
                            priorities += '<option value="'+response.priorities[i].id+'">'+response.priorities[i].priority_name+'</option>';
                        }
                    }

                    var url = '';
                    var imagePath = '';
                    if(response.task.attachment){
                        url = $('meta[name="base_url"]').attr('content');
                        imagePath = url+'/'+response.task.attachment;
                    }

                    var status = '';
                    if(response.task.status == 1){
                        status = '<option value="">Choose Status</option><option value="1" selected>To Do</option><option value="2">In Progress</option><option value="3">On Review</option><option value="4">Complete</option>';
                    }else if(response.task.status == 2){
                        status = '<option value="">Choose Status</option><option value="1">To Do</option><option value="2" selected>In Progress</option><option value="3">On Review</option><option value="4">Complete</option>';
                    }else if(response.task.status == 3){
                        status = '<option value="">Choose Status</option><option value="1">To Do</option><option value="2">In Progress</option><option value="3" selected>On Review</option><option value="4">Complete</option>';
                    }else if(response.task.status == 4){
                        status = '<option value="">Choose Status</option><option value="1">To Do</option><option value="2">In Progress</option><option value="3">On Review</option><option value="4" selected>Complete</option>';
                    }else{
                        status = '<option value="">Choose Status</option><option value="1">To Do</option><option value="2">In Progress</option><option value="3">On Review</option><option value="4">Complete</option>';
                    }

                    var html = '';

                    html += '<input type="hidden" name="task_id" value="'+response.task.id+'"><input type="hidden" name="client_id" value="'+ response.task.client_id+'"><div class="row"><div class="col-md-6 mb-2"><label class="form-label">Title <span class="text-danger">*</span></label><input type="text" class="form-control" name="title" value="'+response.task.title+'"><span class="text-danger titleError"></span></div><div class="col-md-6 mb-2"><label class="form-label">Category <span class="text-danger">*</span></label><select class="form-control" name="category_id"><option value="">Choose Category</option>'+taskcategories+'</select><span class="text-danger categoryError"></span></div><div class="col-md-6 mb-2"><label class="form-label">Assignee</label><select class="form-control" name="assigee_id"><option value="">Choose Assignee</option>'+users+'</select></div><div class="col-md-6 mb-2"><label class="form-label">Priority</label><select class="form-control" name="priority_id"><option value="">Choose Assignee</option>'+priorities+'</select></div><div class="col-md-12 mb-2"><label class="form-label">Due Date</label><input type="text" class="form-control datetime-datepicker" placeholder="Date and Time" name="due_date" value="'+response.task.due_date+'"> </div><div class="col-md-12 mb-2"><label class="form-label">Description</label><textarea class="form-control" rows="4" name="description">'+response.task.description+'</textarea></div><div class="col-md-12 mb-2"><label class="form-label">Attachments:</label><input type="file" class="dropify" name="attachment" data-height="90" data-default-file="'+imagePath+'"></div><div class="col-md-12 mb-2"><label class="form-label">Followers</label><select class="form-control" name="follower_id"><option value="">Choose Assignee</option>'+users+'</select></div><div class="col-md-12 mb-2"><label class="form-label">Status</label><select class="form-control" name="status">'+status+'</select></div></div><button type="button" class="btn btn-primary px-5 w-100" id="update"> Update </button>';

                    $('.updateTaskContent').html(html);

                    $('.dropify').dropify();
                    $(".datetime-datepicker").flatpickr({
                        enableTime: !0,
                        dateFormat: "Y-m-d H:i"
                    });

                }
            });

        });

        $(document).delegate('#update', 'click', function(e) {
            e.preventDefault();
            var fromData = new FormData(document.getElementById("updateTaskForm"));
            $.ajax({
                url: "{{ route('backend.updateclient-task') }}",
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
                    // alert(response);
                    $('#updateTask').modal("hide");
                    window.location.reload();
                },
                error: function(response) {
                    $('.titleError').text(response.responseJSON.errors.title);
                    $('.categoryError').text(response.responseJSON.errors.category_id);
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

        $('.dropify').dropify();
        $("#datetime-datepicker").flatpickr({
            enableTime: !0,
            dateFormat: "Y-m-d H:i"
        });
    });
</script>

@endsection