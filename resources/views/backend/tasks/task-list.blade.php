@extends('backend.layouts.app')
@section('css')
<link href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/libs/clockpicker/bootstrap-clockpicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')

<div class="card">
    <div class="card-body">
        <div class="d-flex">
            <div class="col-6 col-md-4">
                <select class="form-control">
                    <option value=""> Assigned to me </option>
                    <option value="1"> All </option>
                    <option value="2"> Assigned to me </option>
                    <option value="3"> My Todo </option>
                    <option value="4"> My Completed </option>
                    <option value="4"> Following </option>
                    <option value="4"> All Archived </option>
                </select>
            </div>
            <button type="button" class="btn btn-primary ms-auto" id="addtask"> + Add </button>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Task Title</th>
                            <th>Attachment</th>
                            <th>Priority</th>
                            <th></th>
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
                                @if($task->related == 1)
                                <div class="overflow-hidden">
                                    <div class="float-start me-2">
                                        @isset($task->client->client_image)
                                        <img src="{{ asset($task->client->client_image) }}" alt="user-img" title="Mat Helme" class="rounded-circle  avatar-sm">
                                        @endisset
                                    </div>
                                    <div>
                                        <div class="text-truncate">
                                            @isset($task->client)
                                            <a href="{{ url('/') }}/admin/client/activitie/{{ $task->client->id }}">
                                                {{$task->client->first_name.' '.$task->client->first_name}}
                                            </a>
                                            @endisset
                                        </div>
                                        <div class="text-truncate">
                                            <span class="badge bg-light text-dark">Client</span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if($task->related == 2)
                                <div class="overflow-hidden">
                                    <div class="float-start me-2">
                                        @isset($task->partner->partner_image)
                                            <img src="{{ asset($task->partner->partner_image) }}" alt="user-img" title="Mat Helme" class="rounded-circle  avatar-sm">
                                        @endisset
                                    </div>
                                    <div>
                                        <div class="text-truncate">
                                            @isset($task->partner->partner_image)
                                            <a href="{{ route('backend.partner-profile-application', ['id' => $task->partner->id]) }}">
                                                {{ $task->partner->name }}
                                            </a>
                                            @endisset
                                        </div>
                                        <div class="text-truncate">
                                            <span class="badge bg-light text-dark">Partner</span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if($task->related == 3)

                                @endif
                            </td>
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
                                {{-- <a href="javascript:void(0);" data-id="{{ $task->id }}" class="btn btn-sm btn-primary waves-effect waves-light editTaskModel"><i class="mdi mdi-square-edit-outline"></i></a> --}}
                                <a href="{{ route('backend.delete-task', ['id' => $task->id ]) }}" id="delete" class="btn btn-danger btn-sm"><i class="mdi mdi-delete-outline"></i></a>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="taskFrom" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Create New Task</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
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
                        <div class="col-md-6 mb-2 assignees_item">
                            <label class="form-label">Assignee</label>
                            <select class="form-control" name="assigee_id" id="assignees" data-width="100%"></select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Priority </label>
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
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" rows="4" name="description"></textarea>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Attachments:</label>
                            <input type="file" class="dropify" name="attachment" data-height="90">
                        </div>
                        <div class="col-md-6 mb-2 followeritems">
                            <label class="form-label">Followers</label>
                            <select class="form-control" name="follower_id" id="followers" data-width="100%"></select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Related To </label>
                            <div class="d-flex flex-wrap">
                                <div class="form-check me-2">
                                    <input class="form-check-input" type="radio" name="related" id="related1" value="1">
                                    <label class="form-check-label" for="related1">
                                        Contact
                                    </label>
                                </div>
                                <div class="form-check me-2">
                                    <input class="form-check-input" type="radio" name="related" id="related2" value="2">
                                    <label class="form-check-label" for="related2">
                                        Partner
                                    </label>
                                </div>
                                <div class="form-check me-2">
                                    <input class="form-check-input" type="radio" name="related" id="related3" value="3">
                                    <label class="form-check-label" for="related3">
                                        Application
                                    </label>
                                </div>
                                <div class="form-check me-2">
                                    <input class="form-check-input" type="radio" name="related" id="related4" value="4" checked="">
                                    <label class="form-check-label" for="related4">
                                        Internal
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" id="contact_itemss">
                            <div>
                                <label class="form-label">Contact Name</label>
                                <select class="form-control" id="contactname" name="contact_id" data-width="100%"></select>
                            </div>
                        </div>
                        <div class="col-md-12" id="partnersname_itemss">
                            <div>
                                <label class="form-label">Partner Name</label>
                                <select class="form-control" id="partnersname" name="partner_id" data-width="100%"></select>
                            </div>
                        </div>
                        <div class="col-md-12" id="Application_itemss">
                            <div class="mb-2">
                                <label class="form-label">Client Name</label>
                                <select class="form-control" id="applicationclientname" name="client_id" data-width="100%"></select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Application</label>
                                <select class="form-control" id="applicationname" name="application_id" data-width="100%"></select>
                            </div>
                            <div class="mb-2 applicationstage_item">
                                <label class="form-label">Stage</label>
                                <select class="form-control" name="stage_id" id="applicationstage" data-width="100%">
                                    <option value="1">Application</option>
                                    <option value="2">Offer Letter</option>
                                    <option value="3">Fee Payment</option>
                                    <option value="4">COE</option>
                                    <option value="5">Visa Application</option>
                                    <option value="6">Enrolment</option>
                                    <option value="7">Course Ongoing</option>
                                </select>
                            </div>
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
        //contactname
        var contactname = <?php echo json_encode($clients); ?>        
        var contactnamedata = [];
        for(var i=0; i<contactname.length; i++){
            contactnamedata.push(
                {
                    id:contactname[i].id, text:'<div>'+contactname[i].first_name+''+contactname[i].last_name+'</div><div><small>'+contactname[i].email+'</small> <div class="float-end"><span class="badge bg-info ">Lead</span> <br/><small> Head Office </small></div></div>'
                }
            );
        }
        $("#contactname").select2({
            data: contactnamedata,
            dropdownParent: $('#addTaskModal'),
            templateResult: function (d) { return $(d.text); },
            templateSelection: function (d) { return $(d.text); },
        });

        //assigne
        var assigne = <?php echo json_encode($users); ?>;        
        var assigneedata = [];
        for(var i=0; i<assigne.length; i++){
            assigneedata.push(
                {
                    id:assigne[i].id, text:'<div> '+assigne[i].first_name+' '+assigne[i].last_name+' </div><div><small>'+assigne[i].email+'</small> <span class="badge bg-info float-end">'+assigne[i].office.office_name+'</span></div>'
                }
            );
        }
        $("#assignees").select2({
            data: assigneedata,
            dropdownParent: $('#addTaskModal'),
            templateResult: function (d) { return $(d.text); },
            templateSelection: function (d) { return $(d.text); },
        });
        $("#followers").select2({
            data: assigneedata,
            dropdownParent: $('#addTaskModal'),
            templateResult: function (d) { return $(d.text); },
            templateSelection: function (d) { return $(d.text); },
        });

        //applicationclientname
        var clientname = <?php echo json_encode($clients); ?>;        
        var applicationclientname = [];
        for(var i=0; i<clientname.length; i++){
            applicationclientname.push(
                {
                    id:clientname[i].id, text:'<div>'+clientname[i].first_name+''+clientname[i].last_name+'</div><div><small>'+clientname[i].email+'</small></div>'
                }
            );
        }
        $("#applicationclientname").select2({
            data: applicationclientname,
            dropdownParent: $('#addTaskModal'),
            templateResult: function (d) { return $(d.text); },
            templateSelection: function (d) { return $(d.text); },
        });

        //partner
        var partner = <?php echo json_encode($partners); ?>;        
        var partnersnamedata = [];
        for(var i=0; i<partner.length; i++){
            partnersnamedata.push(
                {
                    id:partner[i].id, text:'<div>'+partner[i].name+'</div><div><small>'+partner[i].email+'</small></div>'
                }
            );
        }
        $("#partnersname").select2({
            data: partnersnamedata,
            dropdownParent: $('#addTaskModal'),
            templateResult: function (d) { return $(d.text); },
            templateSelection: function (d) { return $(d.text); },
        });

        $('#applicationclientname').on("change", function() {
            var clientId = $(this).val();
            $.ajax({
                url: "{{ route('backend.client-application-info') }}",
                data: {
                    client_id : clientId
                },
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                dataType: 'json',
                success: function(application) {
                    $("#applicationname").html('');

                    if(application !=''){
                        var applicationname = [];
                        for(var i=0; i<application.length; i++){
                            applicationname.push(
                                {
                                    id:application[i].id, text:'<div>'+application[i].product.name+'</div><div><small>'+application[i].partner.name+'</small> <div class="float-end"><span class="badge bg-info "> In Progress </span> </div></div>'
                                }
                            );
                        }
                        // console.log(applicationname);
                        $("#applicationname").select2({
                            data: applicationname,
                            dropdownParent: $('#addTaskModal'),
                            templateResult: function (d) { return $(d.text); },
                            templateSelection: function (d) { return $(d.text); },
                        });
                    }else{
                        $("#applicationname").append('<option value="">'+applicationname+'</option>');
                    }

                }
            });
        });

        $('#addtask').on("click", function() {
            $('#addTaskModal').modal("show");
        });

        $("#saveTask").click(function(e) {
            e.preventDefault();
            var fromData = new FormData(document.getElementById("taskFrom"));
            $.ajax({
                url: "{{ route('backend.add-task') }}",
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
                url: "{{ route('backend.edit-task') }}",
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
                    for (var i = 0; i < response.users.length; i++) {
                        if (response.task.assigee_id == response.users[i].id) {
                            users += '<option value="' + response.users[i].id + '" selected>' + response.users[i].first_name + ' ' + response.users[i].last_name + '</option>';
                        } else {
                            users += '<option value="' + response.users[i].id + '">' + response.users[i].first_name + ' ' + response.users[i].last_name + '</option>';
                        }
                    }
                    var taskcategories = '';
                    for (var i = 0; i < response.taskcategories.length; i++) {
                        if (response.task.category_id == response.taskcategories[i].id) {
                            taskcategories += '<option value="' + response.taskcategories[i].id + '" selected>' + response.taskcategories[i].task_name + '</option>';
                        } else {
                            taskcategories += '<option value="' + response.taskcategories[i].id + '">' + response.taskcategories[i].task_name + '</option>';
                        }
                    }
                    var priorities = '';
                    for (var i = 0; i < response.priorities.length; i++) {
                        if (response.task.priority_id == response.priorities[i].id) {
                            priorities += '<option value="' + response.priorities[i].id + '" selected>' + response.priorities[i].priority_name + '</option>';
                        } else {
                            priorities += '<option value="' + response.priorities[i].id + '">' + response.priorities[i].priority_name + '</option>';
                        }
                    }

                    var url = '';
                    var imagePath = '';
                    if (response.task.attachment) {
                        url = $('meta[name="base_url"]').attr('content');
                        imagePath = url + '/' + response.task.attachment;
                    }

                    var status = '';
                    if (response.task.status == 1) {
                        status = '<option value="">Choose Status</option><option value="1" selected>To Do</option><option value="2">In Progress</option><option value="3">On Review</option><option value="4">Complete</option>';
                    } else if (response.task.status == 2) {
                        status = '<option value="">Choose Status</option><option value="1">To Do</option><option value="2" selected>In Progress</option><option value="3">On Review</option><option value="4">Complete</option>';
                    } else if (response.task.status == 3) {
                        status = '<option value="">Choose Status</option><option value="1">To Do</option><option value="2">In Progress</option><option value="3" selected>On Review</option><option value="4">Complete</option>';
                    } else if (response.task.status == 4) {
                        status = '<option value="">Choose Status</option><option value="1">To Do</option><option value="2">In Progress</option><option value="3">On Review</option><option value="4" selected>Complete</option>';
                    } else {
                        status = '<option value="">Choose Status</option><option value="1">To Do</option><option value="2">In Progress</option><option value="3">On Review</option><option value="4">Complete</option>';
                    }

                    var html = '';

                    html += '<input type="hidden" name="task_id" value="' + response.task.id + '"><div class="row"><div class="col-md-6 mb-2"><label class="form-label">Title <span class="text-danger">*</span></label><input type="text" class="form-control" name="title" value="' + response.task.title + '"><span class="text-danger titleError"></span></div><div class="col-md-6 mb-2"><label class="form-label">Category <span class="text-danger">*</span></label><select class="form-control" name="category_id"><option value="">Choose Category</option>' + taskcategories + '</select><span class="text-danger categoryError"></span></div><div class="col-md-6 mb-2"><label class="form-label">Assignee</label><select class="form-control" name="assigee_id"><option value="">Choose Assignee</option>' + users + '</select></div><div class="col-md-6 mb-2"><label class="form-label">Priority</label><select class="form-control" name="priority_id"><option value="">Choose Assignee</option>' + priorities + '</select></div><div class="col-md-12 mb-2"><label class="form-label">Due Date</label><input type="text" class="form-control datetime-datepicker" placeholder="Date and Time" name="due_date" value="' + response.task.due_date + '"> </div><div class="col-md-12 mb-2"><label class="form-label">Description</label><textarea class="form-control" rows="4" name="description">' + response.task.description + '</textarea></div><div class="col-md-12 mb-2"><label class="form-label">Attachments:</label><input type="file" class="dropify" name="attachment" data-height="90" data-default-file="' + imagePath + '"></div><div class="col-md-12 mb-2"><label class="form-label">Followers</label><select class="form-control" name="follower_id"><option value="">Choose Assignee</option>' + users + '</select></div><div class="col-md-12 mb-2"><label class="form-label">Status</label><select class="form-control" name="status">' + status + '</select></div></div><button type="button" class="btn btn-primary px-5 w-100" id="update"> Update </button>';

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
                url: "{{ route('backend.update-task') }}",
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
        
        $('#contact_itemss').hide();
        $('#partnersname_itemss').hide();
        $('#Application_itemss').hide();

        $('input[type=radio][name=related]').change(function() {
            
            $('#contact_itemss').hide();
            $('#partnersname_itemss').hide();
            $('#Application_itemss').hide();
            if (this.value == '1') {
                $('#contact_itemss').show();
            }
            else if (this.value == '2') {
                $('#partnersname_itemss').show();
            }
            else if (this.value == '3') {
                $('#Application_itemss').show();
            }
            else if (this.value == '4') {
            // console.log(this.value);
            }

        });

        $('.dropify').dropify();
        $("#datetime-datepicker").flatpickr({
            enableTime: !0,
            dateFormat: "Y-m-d H:i"
        });

    });
</script>

@endsection