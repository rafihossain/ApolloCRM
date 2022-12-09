@extends('backend.layouts.app')
@section('css')
<link href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />
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

        <div class="card">
            <div class="card-body">
                <div class="overflow-hidden mb-2">
                    @if(Session::has('success'))
                    <div class="alert alert-success" style="text-align: center;">
                        {{ Session::get('success') }}
                    </div>
                    @endif
                    <button class="btn btn-sm btn-primary float-end" id="addEducation">+ Add</button>
                    <h4 class="media-heading mt-0">Education Background</h4>
                </div>

                @foreach($educations as $education)
                <div class="row mb-2">
                    <div class="col-md-4">
                        <div><strong>{{ $education->degree_title }}</strong></div>
                        <div><small>{{ $education->institution }}</small></div>
                    </div>
                    <div class="col-md-6 col-9">
                        <div><span class="badge bg-light text-dark rounded-pill">{{ date('F-Y', strtotime($education->course_start)) }}</span> -
                            <span class="badge bg-light text-dark rounded-pill">{{ date('F-Y', strtotime($education->course_end)) }}</span>
                        </div>
                        <div>
                            @if($education->score_status == 2)
                            <strong class="text-primary">Score: {{$education->score}} GPA</strong>
                            @elseif($education->score_status == 1)
                            <strong class="text-primary">Score: {{$education->score}} %</strong>
                            @endif
                        </div>
                        <div>
                            <small>@if(isset($education->degreelevel)){{ $education->degreelevel->name }} >> @endif @if(isset($education->subjectarea)){{ $education->subjectarea->name }} >> @endif @if(isset($education->subject)){{ $education->subject->name }}@endif</small>
                        </div>
                    </div>
                    <div class="col-md-2 col-3 text-end">
                        <a href="javascript:void(0)" class="left-user-info editEducationModel" data-id="{{ $education->id }}" data-client="{{ $education->client_id }}">
                            <i class="mdi mdi-square-edit-outline mdi-18px"></i>
                        </a>
                        <a href="{{ route('backend.deleteclient-education', ['id' => $education->id, 'client_id'=> $education->client_id ]) }}" id="delete" class="left-user-info">
                            <i class="mdi mdi-delete-outline mdi-18px"></i>
                        </a>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <button class="btn btn-sm btn-primary float-end" id="editTestScore">+ Edit</button>

                <h4 class="media-heading mt-0">English Test Scores</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Listening</th>
                            <th>Reading</th>
                            <th>Writing</th>
                            <th>Speaking</th>
                            <th>Overall Scores</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($englishtestscores as $englishtest)
                        <tr>
                            <td>{{ $englishtest->name }}</td>
                            <td>{{ $englishtest->listening }}</td>
                            <td>{{ $englishtest->reading }}</td>
                            <td>{{ $englishtest->writing }}</td>
                            <td>{{ $englishtest->speaking }}</td>
                            <td><span class="bg-success rounded-circle circle-icon border-0 text-light">{{ $englishtest->overall_scores }}</span> </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <button class="btn btn-sm btn-primary float-end" id="editOtherTestScore">+ Edit</button>
                <h4 class="media-heading mt-0">Other Test Scores</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Sat I</th>
                            <th>Sat II</th>
                            <th>Gre</th>
                            <th>Gmat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Overall Scores</td>
                            <td><span class="bg-success rounded-circle circle-icon border-0 text-light">{{ $othertestscore->sat_one }}</span></td>
                            <td><span class="bg-success rounded-circle circle-icon border-0 text-light">{{ $othertestscore->sat_two }}</span></td>
                            <td><span class="bg-success rounded-circle circle-icon border-0 text-light">{{ $othertestscore->gre }}</span></td>
                            <td><span class="bg-success rounded-circle circle-icon border-0 text-light">{{ $othertestscore->gmat }}</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Standard modal content -->
<div id="addEducationModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addcontact-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addEducationFrom">
                <div class="modal-header">
                    <h4 class="modal-title" id="addcontact-modalLabel"> Add Education Background </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="client_id" value="{{ $client->id }}">
                    <div class="mb-2">
                        <label class="form-label">Degree Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="degree_title">
                        <span class="text-danger" id="titleError"></span>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Degree Level <span class="text-danger">*</span></label>
                        <select name="degree_level" class="form-control" data-toggle="select2" data-width="100%">
                            <option value="">Please select degree level</option>
                            @foreach($degrees as $degree)
                            <option value="{{ $degree->id }}">{{ $degree->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger" id="levelError"></span>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Institution <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="institution">
                        <span class="text-danger" id="institutionError"></span>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label class="form-label">Course Start</label>
                            <input type="text" class="form-control basic-datepicker" name="course_start" placeholder="Select Date">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Course End</label>
                            <input type="text" class="form-control basic-datepicker" name="course_end" placeholder="Select Date">
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Subject Area</label>
                        <select name="subject_area" id="getSubject" class="form-control" data-toggle="select2" data-width="100%">
                            <option value="">Please select subject area</option>
                            @foreach($subjectareas as $subjectarea)
                            <option value="{{ $subjectarea->id }}">{{ $subjectarea->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Subject</label>
                        <select name="subject_id" id="subjectinfo" class="form-control" data-toggle="select2" data-width="100%">
                            <option value="">Please select subject</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Academic Score</label>
                        <div class="d-flex">
                            <div class="form-check me-2">
                                <input type="radio" id="customRadio1" name="score_status" class="form-check-input" value="1">
                                <label class="form-check-label" for="customRadio1">Percentage</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" id="customRadio2" name="score_status" class="form-check-input" value="2">
                                <label class="form-check-label" for="customRadio2">GPA</label>
                            </div>
                            <input type="number" class="form-control ms-3" name="score">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveEducation">Submit</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Standard modal content -->
<div id="updateEducation" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="updateEducationForm" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Edit Education</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body updateEducationContent">

                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="updateTestScoreModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addcontact-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="updateTestScoreFrom">
                <div class="modal-header">
                    <h4 class="modal-title" id="addcontact-modalLabel"> Edit english test scores </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Listening</th>
                                <th>Reading</th>
                                <th>Writing</th>
                                <th>Speaking</th>
                                <th>Overall Scores</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($englishtestscores as $englishtest)
                            <tr>
                                <td>
                                    <input type="hidden" name="id[]" value="{{ $englishtest->id }}">
                                </td>
                                <td>
                                    {{ $englishtest->name }}
                                <td>
                                <td>
                                    <input type="number" class="form-control" name="listening[]" value="{{ $englishtest->listening }}">
                                </td>
                                <td>
                                    <input type="number" class="form-control" name="reading[]" value="{{ $englishtest->reading }}">
                                </td>
                                <td>
                                    <input type="number" class="form-control" name="writing[]" value="{{ $englishtest->writing }}">
                                </td>
                                <td>
                                    <input type="number" class="form-control" name="speaking[]" value="{{ $englishtest->speaking }}">
                                </td>
                                <td>
                                    <input type="number" class="form-control" name="overall_scores[]" value="{{ $englishtest->overall_scores }}">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updateTestScore">Update</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="updateOtherScoreModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addcontact-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="updateOtherScoreFrom">
                <div class="modal-header">
                    <h4 class="modal-title" id="addcontact-modalLabel"> Edit other test scores </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <input type="hidden" name="id" value="{{ $othertestscore->id }}">
                    
                    <div class="mb-2">
                        <label class="form-label">SAT I</label>
                        <input type="number" class="form-control" name="sat_one" value="{{ $othertestscore->sat_one }}">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">SAT II</label>
                        <input type="number" class="form-control" name="sat_two" value="{{ $othertestscore->sat_two }}">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">GRE</label>
                        <input type="number" class="form-control" name="gre" value="{{ $othertestscore->gre }}">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">GMAT</label>
                        <input type="number" class="form-control" name="gmat" value="{{ $othertestscore->gmat }}">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updateOtherScore">Update</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection

@section('script')
<!-- Datatables init -->
<script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        //english score
        $('#editTestScore').on("click", function() {
            $('#updateTestScoreModal').modal("show");
        });
        $("#updateTestScore").click(function(e) {
            e.preventDefault();
            var serialize = $("#updateTestScoreFrom").serialize();
            $.ajax({
                url: "{{ route('backend.update-education-score') }}",
                type: "POST",
                data: serialize,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    // console.log(response);
                    $('#addEducationModal').modal("hide");
                    window.location.reload();
                }
            });

        });

        //other score
        $('#editOtherTestScore').on("click", function() {
            $('#updateOtherScoreModal').modal("show");
        });
        $("#updateOtherScore").click(function(e) {
            e.preventDefault();
            var serialize = $("#updateOtherScoreFrom").serialize();
            $.ajax({
                url: "{{ route('backend.update-other-score') }}",
                type: "POST",
                data: serialize,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    // console.log(response);
                    $('#updateOtherScoreModal').modal("hide");
                    window.location.reload();
                }
            });

        });

        //education
        $('#addEducation').on("click", function() {
            $('#addEducationModal').modal("show");
        });

        $('#getSubject').on("change", function() {
            var subjectareaId = $(this).val();
            $.ajax({
                url: "{{ route('backend.subject_info') }}",
                data: {
                    'subjectarea_id': subjectareaId
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(data) {
                    if (data != undefined && data != null) {
                        var optionValue = '';
                        for (var i = 0; i < data.length; i++) {
                            optionValue += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                        }
                        $('#subjectinfo').append(optionValue);
                    }
                }
            });
        });

        $("#saveEducation").click(function(e) {
            e.preventDefault();
            var serialize = $("#addEducationFrom").serialize();
            $.ajax({
                url: "{{ route('backend.addclient-education') }}",
                type: "POST",
                data: serialize,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    // console.log(response);
                    $('#addEducationModal').modal("hide");
                    window.location.reload();
                },
                error: function(response) {
                    // console.log(response);
                    $('#titleError').text(response.responseJSON.errors.degree_title);
                    $('#levelError').text(response.responseJSON.errors.degree_level);
                    $('#institutionError').text(response.responseJSON.errors.institution);
                }
            });

        });

        $('.editEducationModel').on("click", function() {

            $('#updateEducation').modal("show");
            var educationId = $(this).data('id');
            var clientId = $(this).data('client');
            // console.log(contactId);

            $.ajax({
                url: "{{ route('backend.editclient-education') }}",
                type: "POST",
                data: {
                    education_id: educationId,
                    client_id: clientId,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {

                    var degree = '';
                    for (var i = 0; i < response.degrees.length; i++) {
                        if (response.education.degree_level == response.degrees[i].id) {
                            degree += '<option value="' + response.degrees[i].id + '" selected>' + response.degrees[i].name + '</option>';
                        } else {
                            degree += '<option value="' + response.degrees[i].id + '">' + response.degrees[i].name + '</option>';
                        }
                    }

                    var subjectarea = '';
                    for (var i = 0; i < response.subjectareas.length; i++) {
                        if (response.education.subject_area == response.subjectareas[i].id) {
                            subjectarea += '<option value="' + response.subjectareas[i].id + '" selected>' + response.subjectareas[i].name + '</option>';
                        } else {
                            subjectarea += '<option value="' + response.subjectareas[i].id + '">' + response.subjectareas[i].name + '</option>';
                        }
                    }

                    var subject = '';
                    for (var i = 0; i < response.subjects.length; i++) {
                        if (response.education.degree_level == response.subjects[i].id) {
                            subject += '<option value="' + response.subjects[i].id + '" selected>' + response.subjects[i].name + '</option>';
                        } else {
                            subject += '<option value="' + response.subjects[i].id + '">' + response.subjects[i].name + '</option>';
                        }
                    }

                    var percentage = '';
                    if (response.education.score_status == 1) {
                        percentage = '<input type="radio" id="customRadio1" name="score_status" class="form-check-input" value="1" checked>';
                    } else {
                        percentage = '<input type="radio" id="customRadio1" name="score_status" class="form-check-input" value="1">';
                    }

                    var gpa = '';
                    if (response.education.score_status == 2) {
                        gpa = '<input type="radio" id="customRadio2" name="score_status" class="form-check-input" value="2" checked>';
                    } else {
                        gpa = '<input type="radio" id="customRadio2" name="score_status" class="form-check-input" value="2">';
                    }

                    var html = '';

                    html += '<input type="hidden" name="education_id" value="' + response.education.id + '"><input type="hidden" name="client_id" value="' + response.education.client_id + '"><div class="mb-2"><label class="form-label">Degree Title <span class="text-danger">*</span></label><input type="text" class="form-control" name="degree_title" value="' + response.education.degree_title + '"><span class="text-danger titleError"></span></div><div class="mb-2"><label class="form-label">Degree Level <span class="text-danger">*</span></label><select name="degree_level" class="form-control" data-toggle="select2" data-width="100%"><option value="">Please select degree level</option>' + degree + '</select><span class="text-danger levelError"></span></div><div class="mb-2"><label class="form-label">Institution <span class="text-danger">*</span></label><input type="text" class="form-control" name="institution" value="' + response.education.institution + '"><span class="text-danger institutionError"></span></div><div class="row mb-2"><div class="col-6"><label class="form-label">Course Start</label><input type="text" class="form-control basic-datepicker" name="course_start" value="' + response.education.course_start + '"></div><div class="col-6"><label class="form-label">Course End</label><input type="text" class="form-control basic-datepicker" name="course_end" value="' + response.education.course_end + '"></div></div><div class="mb-2"><label class="form-label">Subject Area</label><select name="subject_area" class="form-control getSubject" data-toggle="select2" data-width="100%"><option value="">Please select subject area</option>' + subjectarea + '</select></div><div class="mb-4"><label class="form-label">Subject</label><select name="subject_id" class="form-control subjectinfo" data-toggle="select2" data-width="100%"><option value="">Please select subject</option>' + subject + '</select></div><div class="mb-2"><label class="form-label">Academic Score</label><div class="d-flex"><div class="form-check me-2">' + percentage + '<label class="form-check-label" for="customRadio1">Percentage</label></div><div class="form-check">' + gpa + '<label class="form-check-label" for="customRadio2">GPA</label></div><input type="number" class="form-control ms-3" name="score" value="' + response.education.score + '"></div></div><button type="button" class="btn btn-primary px-5 w-100" id="update"> Update </button>';

                    $('.updateEducationContent').html(html);

                    $('.getSubject').on("change", function() {
                        var subjectareaId = $(this).val();
                        $.ajax({
                            url: "{{ route('backend.subject_info') }}",
                            data: {
                                'subjectarea_id': subjectareaId
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: 'json',
                            success: function(data) {
                                if (data != undefined && data != null) {
                                    var optionValue = '';
                                    for (var i = 0; i < data.length; i++) {
                                        optionValue += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                                    }
                                    $('.subjectinfo').append(optionValue);
                                }
                            }
                        });
                    });

                    $(".basic-datepicker").flatpickr();
                    $('[data-toggle="select2"]').select2({
                        dropdownParent: $('#updateEducation')
                    });

                }
            });

        });

        $(document).delegate('#update', 'click', function(e) {
            e.preventDefault();
            var serialize = $("#updateEducationForm").serialize();
            $.ajax({
                url: "{{ route('backend.updateclient-education') }}",
                type: "POST",
                data: serialize,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    // alert(response);
                    $('#updateEducation').modal("show");
                    window.location.reload();
                },
                error: function(response) {
                    $('.titleError').text(response.responseJSON.errors.degree_title);
                    $('.levelError').text(response.responseJSON.errors.degree_level);
                    $('.institutionError').text(response.responseJSON.errors.institution);
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


        $(".basic-datepicker").flatpickr();
        $('[data-toggle="select2"]').select2({
            dropdownParent: $('#addEducationModal')
        });
    });
</script>
@endsection