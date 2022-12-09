@extends('backend.layouts.app')
@section('css')
<link href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/libs/clockpicker/bootstrap-clockpicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<h4 class="mt-0 header-title text-end">
    <a href="{{ route('backend.manage-partner') }}" class="btn btn-primary"> Partners List </a>
</h4>

<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                @include('backend.partner.include.partner-sidebar')
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-body">
                @include('backend.partner.include.partner-header')
            </div>
        </div>
        <div class="text-end mb-3">
            <button type="button" class="btn btn-primary" id="addappointment">+ Add</button>
        </div>
        
        @if(Session::has('success'))
            <div class="alert alert-success" style="text-align: center;">
                {{ Session::get('success') }}
            </div>
        @endif

        <div class="row">
        
            @foreach($appointments as $appointment)
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body p-2">
                        <div class="dropdown float-end">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="javascript:void(0);" data-id="{{ $appointment->id }}" data-partner="{{ $appointment->partner_id }}" class="dropdown-item editAppointmentModel">Edit</a>
                                <a href="{{ route('backend.deletepartner-appointment', ['id' => $appointment->id, 'partner_id'=> $appointment->partner_id ] ) }}" id="delete" class="dropdown-item">Delete</a>
                            </div>
                        </div>
                        <div class=" mb-3 ">
                            <h5 class="media-heading mt-0 mb-0">{{ $appointment->title }}</h5>
                        </div>
                        <p></p>
                        <p class="d-flex mb-0 align-items-center"> <i class="mdi mdi-clock-time-four-outline me-1 mdi-18px text-primary"></i> <small>{{ date('d-m-Y h:i a', strtotime($appointment->time )) }} </small></p>
                        <p class="d-flex mb-0 align-items-center"> <i class="mdi mdi-calendar-month me-1 mdi-18px text-primary"></i> <small>{{ date('d-m-Y h:i a', strtotime($appointment->date )) }}</small></p>
                        <p> <small>{{ $appointment->description }}</small></p>
                    </div>
                    <div class="card-footer p-2">
                        <h5>Created By:</h5>
                        <div class="d-flex align-items-center">
                            <a href="#"><img class="flex-shrink-0 me-1 rounded-circle avatar-sm" alt="64x64" src="{{ asset($appointment->user->avatar) }}"></a>
                            <div class="flex-grow-1">
                                <p class="mb-0"><a href="#">{{$appointment->user->first_name.' '.$appointment->user->last_name}}</a> </p>
                                <p class="mb-0"><small>{{ $appointment->user->email }}</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>

<!-- Standard modal content -->
<div id="addAppointmentModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addcontact-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form id="appointmentFrom">
                <div class="modal-header">
                    <h4 class="modal-title" id="addcontact-modalLabel">Add Appointment</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="partner_id" value="{{ $partner->id }}">
                        <input type="hidden" name="added_by" value="{{ $user->id }}">
                        <div class="col-6">
                            <div class="mb-2">
                                <label class="form-label">Related to:</label>
                                <div class="d-flex">
                                    <div class="form-check me-2">
                                        <input type="radio" id="customRadio1" name="related_to" class="form-check-input" value="1" disabled>
                                        <label class="form-check-label" for="customRadio1">Client</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" id="customRadio2" name="related_to" class="form-check-input" checked="" value="2" disabled>
                                        <label class="form-check-label" for="customRadio2">Partner</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Added by:</label>
                            <p class="mb-0"> {{$user->first_name.' '.$user->last_name}} </p>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Partner Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="partner_name" value="{{ $partner->name }}" readonly>
                        <span class="text-danger" id="partnernameError"></span>
                    </div>
                    <div class="mb-2">
                        <label>Timezone <span class="text-danger">*</span></label>
                        <select name="timezone_id" id="" class="form-control @error('timezone_id') is-invalid @enderror">
                            <option value="">Select timezone</option>
                            @foreach($timezones as $timezone)
                            <option value="{{ $timezone->id }}">{{ $timezone->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger" id="timezoneError"></span>
                    </div>
                    <div class="row">
                        <div class="col-7">
                            <div class="mb-2">
                                <label class="form-label">Date <span class="text-danger">*</span></label>
                                <input type="text" id="basic-datepicker" name="date" class="form-control" placeholder="Select Date">
                                <p><small>Date must be in YYYY-MM-DD (2012-12-22) format.</small></p>
                                <span class="text-danger" id="dateError"></span>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="mb-2">
                                <label class="form-label">Time <span class="text-danger">*</span></label>
                                <input type="text" id="basic-timepicker" class="form-control" name="time">
                                <span class="text-danger" id="timeError"></span>
                            </div>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="title">
                        <span class="text-danger" id="titleError"></span>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description"></textarea>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Invitees</label>
                        <input type="text" class="form-control" name="invite">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="saveAppointment">Submit</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Standard modal content -->
<div id="updateAppointment" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="updateAppointmentForm">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Edit Appointment</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body updateAppointmentContent">

                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection

@section('script')
<!-- Datatables init -->
<script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ asset('assets/libs/spectrum-colorpicker2/spectrum.min.js') }}"></script>
<script src="{{ asset('assets/libs/clockpicker/bootstrap-clockpicker.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>

<!-- Init js-->

<script type="text/javascript">
    $(document).ready(function() {

        $('#addappointment').on("click", function() {
            $('#addAppointmentModal').modal("show");
        });

        $('#saveAppointment').click(function(e) {
            e.preventDefault();

            var serialize = $('#appointmentFrom').serialize();
            // console.log(serialize);

            $.ajax({
                url: "{{ route('backend.addpartner-appointment') }}",
                type: "POST",
                data: serialize,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    // console.log(response);
                    $('#addNoteModal').modal("hide");
                    window.location.reload();
                },
                error: function(response) {
                    // console.log(response);
                    $('#partnernameError').text(response.responseJSON.errors.partner_name);
                    $('#timezoneError').text(response.responseJSON.errors.timezone_id);
                    $('#dateError').text(response.responseJSON.errors.date);
                    $('#timeError').text(response.responseJSON.errors.time);
                    $('#titleError').text(response.responseJSON.errors.title);
                }
            });

        });

        $('.editAppointmentModel').on("click", function() {

            $('#updateAppointment').modal("show");
            var appointmentId = $(this).data('id');
            var partnerId = $(this).data('partner');
            // console.log(contactId);

            $.ajax({
                url: "{{ route('backend.editpartner-appointment') }}",
                type: "POST",
                data: {
                    appointment_id: appointmentId,
                    partner_id: partnerId,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {

                    var timezone = '';
                    for(var i = 0; i < response.timezones.length; i++){

                        if(response.appointment.timezone_id == response.timezones[i].id){
                            timezone += '<option value="'+response.timezones[i].id+'" selected>'+response.timezones[i].name+'</option>';
                        }else{
                            timezone += '<option value="'+response.timezones[i].id+'">'+response.timezones[i].name+'</option>';
                        }
                    }

                    var html = '';
                    html += '<input type="hidden" name="appointment_id" value="'+response.appointment.id+'"><input type="hidden" name="partner_id" value="'+ response.appointment.partner_id+'"><input type="hidden" name="added_by" value="'+response.user.id+'"><div class="row"><div class="col-6"><div class="mb-2"><label class="form-label">Related to:</label><div class="d-flex"><div class="form-check me-2"><input type="radio" id="customRadio1" name="related_to" class="form-check-input" value="1" disabled><label class="form-check-label" for="customRadio1">Client</label></div><div class="form-check"><input type="radio" id="customRadio2" name="related_to" class="form-check-input" checked="" value="2" disabled><label class="form-check-label" for="customRadio2">Partner</label></div></div></div></div><div class="col-6"><label class="form-label">Added by:</label><p class="mb-0">'+response.user.first_name+' '+response.user.last_name +'</p></div></div><div class="mb-2"><label class="form-label">Partner Name <span class="text-danger">*</span></label><input type="text" class="form-control" name="partner_name" value="'+response.appointment.partner_name+'" readonly><span class="text-danger partnernameError"></span></div><div class="mb-2"><label>Timezone <span class="text-danger">*</span></label><select name="timezone_id" id="" class="form-control"><option value="">Select timezone</option>'+timezone+'</select><span class="text-danger timezoneError"></span></div><div class="row"><div class="col-7"><div class="mb-2"><label class="form-label">Date <span class="text-danger">*</span></label><input type="text" id="basic-datepicker" name="date" class="form-control" placeholder="Select Date" value="'+response.appointment.date+'"><p><small>Date must be in YYYY-MM-DD (2012-12-22) format.</small></p><span class="text-danger dateError"></span></div></div><div class="col-5"><div class="mb-2"><label class="form-label">Time <span class="text-danger">*</span></label><input type="text" id="basic-timepicker" class="form-control" name="time" value="'+response.appointment.time+'"><span class="text-danger timeError"></span></div></div></div><div class="mb-2"><label class="form-label">Title <span class="text-danger">*</span></label><input type="text" class="form-control" name="title" value="'+response.appointment.title+'"><span class="text-danger titleError"></span></div><div class="mb-2"><label class="form-label">Description</label><textarea class="form-control" name="description">'+response.appointment.description+'</textarea></div><div class="mb-2"><label class="form-label">Invitees</label><input type="text" class="form-control" name="invite"></div><button type="button" class="btn btn-primary px-5 w-100" id="update"> Update </button>';

                    $('.updateAppointmentContent').html(html);

                }
            });

        });

        $(document).delegate('#update', 'click', function(e) {
            e.preventDefault();
            // alert('hello');

            var serialize = $('#updateAppointmentForm').serialize();
            // console.log(serialize);

            $.ajax({
                url: "{{ route('backend.updatepartner-appointment') }}",
                type: "POST",
                data: serialize,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    // console.log(response);
                    $('#updateAppointment').modal("hide");
                    window.location.reload();
                },
                error: function(response) {
                    $('.partnernameError').text(response.responseJSON.errors.partner_name);
                    $('.timezoneError').text(response.responseJSON.errors.timezone_id);
                    $('.dateError').text(response.responseJSON.errors.date);
                    $('.timeError').text(response.responseJSON.errors.time);
                    $('.titleError').text(response.responseJSON.errors.title);
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
        
        //delete sweetalert
        $(document).on('click', '#partner-delete', function(e) {
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

        $("#basic-datepicker").flatpickr();
        $("#basic-timepicker").flatpickr({
            enableTime: !0,
            noCalendar: !0,
            dateFormat: "H:i"
        });
    });
</script>
@endsection