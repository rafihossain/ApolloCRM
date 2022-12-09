@extends('backend.layouts.app')
@section('content')

<div class="card">
    <div class="card-body">
        <h4 class="m-0 header-title text-end float-end">
            <button type="button" class="btn btn-primary" id="addWaiting">+ Add</button>
        </h4>

        <ul class="nav nav-tabs nav-bordered border-0">
            <li class="nav-item">
                <a href="{{ route('backend.office-visit-waiting') }}" class="nav-link active">
                    Waiting
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('backend.office-visit-attending') }}" class="nav-link ">
                    Attending
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('backend.office-visit-completed') }}" class="nav-link">
                    Completed
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('backend.office-visit-all') }}" class="nav-link">
                    All
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('backend.office-visit-archived') }}" class="nav-link">
                    Archived
                </a>
            </li>
        </ul>
    </div>
</div>

@if(Session::has('success'))
    <div class="alert alert-success" style="text-align: center;">
        {{ Session::get('success') }}
    </div>
@endif

<div class="row mb-3">
    <div class="col-md-8"></div>
    <div class="col-md-4">
        <div class="office-filter">
            <select class="form-control" id="office">
                <option value="">All Branches</option>
                @foreach($offices as $office)
                <option value="{{ $office->id }}">{{ $office->office_name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <table id="newdatatable" class="table table-bordered dt-responsive table-responsive nowrap">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Date</th>
                    <th>Start</th>
                    <th>Contact Name</th>
                    <th>Contact Type</th>
                    <th>Visit Purpose</th>
                    <th>Assignee</th>
                    <th class="d-none">Office</th>
                    <th>Wait Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i=1;
                @endphp

                @foreach($officeVisites as $officevisite)
                <tr>
                    <td>{{'# '.$i++ }}</td>
                    <td>
                        <div class="text-primary">{{ $officevisite->created_at->format('l') }}</div>
                        <div>{{ $officevisite->created_at->format('d-m-Y') }}</div>
                    </td>
                    <td>
                        {{ $officevisite->created_at->format('h:i A') }}
                    </td>
                    <td>
                        <div class="overflow-hidden">
                            <div class="float-start me-2">
                                <img src="{{ asset($officevisite->client->client_image) }}" alt="user-img" title="Mat Helme" class="rounded-circle img-thumbnail avatar-md">
                            </div>
                            <div>
                                <div class="text-truncate">
                                    <a href="{{ url('/client/activitie') }}">
                                        {{ $officevisite->client->first_name.' '.$officevisite->client->last_name }}
                                    </a>
                                </div>
                                <div class="text-truncate">
                                    <a href="#">{{ $officevisite->client->email }}</a>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td> Prospect </td>
                    <td> {{ $officevisite->visit_purpose }} </td>
                    <td>
                        <div class="overflow-hidden">
                            <div class="float-start me-2">
                                <img src="{{ asset($officevisite->user->avatar) }}" alt="user-img" title="Mat Helme" class="rounded-circle img-thumbnail avatar-md">
                            </div>
                            <div>
                                <div class="text-truncate">
                                    <a href="{{ url('/client/activitie') }}">
                                        {{ $officevisite->user->first_name.' '.$officevisite->user->last_name }}
                                    </a>
                                </div>
                                <div class="text-truncate">
                                    <a href="#">{{ $officevisite->user->email }}</a>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="d-none">{{ $officevisite->client->assignee_id }}</td>
                    <td>{{ $officevisite->created_at->diffForHumans() }}</td>
                    <td>
                        <a href="javascript:void(0)" data-id="{{ $officevisite->id }}" class="btn btn-sm btn-primary waves-effect waves-light editWaitingModel">
                            <i class="mdi mdi-square-edit-outline"></i>
                        </a>
                        <a href="{{ route('backend.delete-office-waiting', ['id' => $officevisite->id]) }}" id="delete" class="btn btn-sm btn-danger waves-effect waves-light">
                            <i class="mdi mdi-trash-can-outline"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- Standard modal content -->
<div id="addWaitingModel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addcontact-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addWaitingFrom">
                <div class="modal-header">
                    <h4 class="modal-title" id="addcontact-modalLabel">Create Office Check-In</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label class="form-label">Search Contact: <span class="text-danger">*</span></label>
                        <select class="form-control" name="contact_id" id="search_contact" data-width="100%"></select>
                        <span class="text-danger" id="contactError"></span>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Visit Purpose</label>
                        <textarea class="form-control" name="visit_purpose"></textarea>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Select CheckIn Assignee: </label>
                        <select class="form-control" id="CheckInAssignee" name="assigne_id" data-width="100%"></select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveWaiting">Submit</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Standard modal content -->
<div id="updateWaiting" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="updateWaitingForm" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Edit Office Check-In</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body updateWaitingContent">

                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection

@section('script')
<!-- Datatables init -->

<script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('[data-toggle="select2"]').select2();
        $('#addWaiting').click(function() {
            $('#addWaitingModel').modal("show");
        });
        $("#saveWaiting").click(function(e) {
            e.preventDefault();
            var serialize = $("#addWaitingFrom").serialize();
            $.ajax({
                url: "{{ route('backend.create-office-waiting') }}",
                type: "POST",
                data: serialize,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    $('#addWaitingModel').modal("hide");
                    window.location.reload();
                },
                error: function(response) {
                    $('#contactError').text(response.responseJSON.errors.contact_id);
                }
            });
        });
        $('.editWaitingModel').on("click", function() {

            $('#updateWaiting').modal("show");
            var visiteId = $(this).data('id');

            $.ajax({
                url: "{{ route('backend.edit-office-waiting') }}",
                data: {
                    visite_id: visiteId,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {

                    var clients = '';
                    for (var i = 0; i < response.clients.length; i++) {
                        if (response.officeVisite.contact_id == response.clients[i].id) {
                            var selected = 'selected';
                        } else {
                            var selected = '';
                        }
                        clients += '<option value="'+response.clients[i].id +'" '+selected+'>'+response.clients[i].first_name+' '+response.clients[i].last_name +'</option>';
                    }

                    var users = '';
                    for (var i = 0; i < response.users.length; i++) {
                        if (response.officeVisite.assigne_id == response.users[i].id) {
                            var selected = 'selected';
                        } else {
                            var selected = '';
                        }
                        users += '<option value="'+response.users[i].id+'" '+selected+'>'+response.users[i].first_name+' '+response.users[i].last_name+'</option>';
                    }

                    var html = '';

                    html += '<input type="hidden" name="visite_id" value="'+response.officeVisite.id+'"><div class="mb-2"><label class="form-label">Search Contact: <span class="text-danger">*</span></label><select class="form-control" name="contact_id" id="search_contact" data-width="100%"><option value="">Select Contact</option>'+clients+'</select><span class="text-danger contactError"></span></div><div class="mb-2"><label class="form-label">Visit Purpose</label><textarea class="form-control" name="visit_purpose">'+response.officeVisite.visit_purpose+'</textarea></div><div class="mb-2"><label class="form-label">Select CheckIn Assignee: </label><select class="form-control" id="CheckInAssignee" name="assigne_id" data-width="100%">'+users+'</select></div><button type="button" class="btn btn-primary px-5 w-100" id="update"> Update </button>';

                    $('.updateWaitingContent').html(html);

                }
            });

        });
        $(document).delegate('#update', 'click', function(e) {
            e.preventDefault();
            var serialize = $("#updateWaitingForm").serialize();
            $.ajax({
                url: "{{ route('backend.update-office-waiting') }}",
                type: "POST",
                data: serialize,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    $('#updateWaiting').modal("hide");
                    window.location.reload();
                },
                error: function(response) {
                    $('.contactError').text(response.responseJSON.errors.contact_id);
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
        var all_contact = <?php echo json_encode($clients); ?>;
        var contactdata = [];
        for (var i = 0; i < all_contact.length; i++) {

            var imagePath = '';
            if (all_contact[i].client_image) {
                url = $('meta[name="base_url"]').attr('content');
                imagePath = url + '/' + all_contact[i].client_image;
            }

            contactdata.push({
                id: all_contact[i].id,
                text: '<div class="overflow-hidden"><div class="float-end"><div class="text-end"><span class="badge bg-primary rounded-pill">Lead</span></div><div><small> Bangladesh Office </small></div></div><div class="float-start me-2"> <img src="' + imagePath + '" alt="user-img" title="Mat Helme" class="rounded-circle img-thumbnail avatar-md"> </div> <div> <div class="text-truncate"> Aadheya Chowdhury </div> <div class="text-truncate"><small>' + all_contact[i].email + '</small> | <small title="+61412076345">+61412076345</small> </div> </div> </div>',
            });
        }
        $("#search_contact").select2({
            placeholder: 'Select at least one element',
            dropdownParent: $('#addWaitingModel'),
            data: contactdata,
            templateResult: function(d) {
                return $(d.text);
            },
            templateSelection: function(d) {
                return $(d.text);
            },
        });
        var all_users = <?php echo json_encode($users); ?>;
        var datacheckin = [];
        for (var i = 0; i < all_users.length; i++) {
            datacheckin.push({
                id: all_users[i].id,
                text: '<div><div><strong>' + all_users[i].first_name + ' ' + all_users[i].last_name + '</strong></div><small>' + all_users[i].email + '</small></div>',
            });
        }
        $('#CheckInAssignee').select2({
            dropdownParent: $('#addWaitingModel'),
            data: datacheckin,
            templateResult: function(d) {
                return $(d.text);
            },
            templateSelection: function(d) {
                return $(d.text);
            },
        });
        var table = $('#newdatatable').DataTable();
        $("#newdatatable_filter.office-filter").append($("#office"));
        var officeIndex = 0;
        $("#newdatatable th").each(function(i) {
            if ($($(this)).html() == "Office") {
                officeIndex = i;
                return true;
            }
        });
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var officeItem = $('#office').val();
                var office = data[officeIndex];
                if (officeItem === "" || office.includes(officeItem)) {
                    return true;
                }
            }
        );
        $("#office").change(function(e) {
            table.draw();
        });
        table.draw();
    });
</script>
@endsection