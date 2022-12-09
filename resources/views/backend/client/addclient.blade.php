@extends('backend.layouts.app')
@section('css')

<link rel="stylesheet" href="//unpkg.com/bootstrap-select-country@4.0.0/dist/css/bootstrap-select-country.min.css" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.18/css/intlTelInput.css" />
<link href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/libs/clockpicker/bootstrap-clockpicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
<style type="text/css">
    body .iti {
        display: block;
    }

    body .dropdown-toggle.btn-default {
        color: #292b2c;
        background-color: #fff;
        border-color: #ccc;
    }

    body .bootstrap-select.show>.dropdown-menu>.dropdown-menu {
        display: block;
    }

    body .bootstrap-select>.dropdown-menu>.dropdown-menu li.hidden {
        display: none;
    }

    body .bootstrap-select>.dropdown-menu>.dropdown-menu li a {
        display: block;
        width: 100%;
        padding: 3px 1.5rem;
        clear: both;
        font-weight: 400;
        color: #292b2c;
        text-align: inherit;
        white-space: nowrap;
        background: 0 0;
        border: 0;
        text-decoration: none;
    }

    body .bootstrap-select>.dropdown-menu>.dropdown-menu li a:hover {
        background-color: #f4f4f4;
    }

    body .bootstrap-select>.dropdown-toggle {
        width: 100%;
    }

    body .dropdown-menu>li.active>a {
        color: #fff !important;
        background-color: #337ab7 !important;
    }

    body .bootstrap-select .check-mark {
        line-height: 14px;
    }

    body .bootstrap-select .check-mark::after {
        font-family: "FontAwesome";
        content: "\f00c";
    }

    body .bootstrap-select button {
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Make filled out selects be the same size as empty selects */
    body .bootstrap-select.btn-group .dropdown-toggle .filter-option {
        display: inline !important;
    }

    .main-content .body-content {
        border: 1px solid #dbdbdb;
    }

    .main-content .body-content .body-item {
        border-bottom: 1px solid #dbdbdb;
        display: flex;
    }

    .main-content .body-content .body-item .body-title {
        flex: 2;
        justify-content: space-between;
        padding: 0.6rem;
        width: 60%;
    }

    .main-content .body-content .body-item .body-workflow {
        border-left: 1px solid #dbdbdb;
        padding: 0.6rem;
        min-width: 160px;
        width: 20%;
    }

    .main-content .body-content .body-item .body-stage {
        border-left: 1px solid #dbdbdb;
        padding: 0.6rem;
        min-width: 160px;
        width: 20%;
    }

    .main-content .heading-content {
        display: flex;
    }

    .main-content .heading-content .heading-application {
        flex: 2;
        text-align: left;
        width: 60%;
    }

    .main-content .heading-content .heading-name {
        flex: 1;
        text-align: right;
        width: 20%;
    }
</style>
@endsection
@section('content')
<h4 class="mt-0 header-title mb-4">
    Add New Client or Prospect
</h4>
<form action="{{route('backend.save-client')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card">
        <div class="card-body">
            <h4 class="header-title mb-2">Personal Details</h4>
            <div class="row">
                <div class="col-md-3">
                    <label class="form-label">Profile image <span class="text-danger">*</span></label>
                    <input type="file" class="dropify" name="client_image" data-default-file="" data-height="205" />
                    @error('client_image')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{old('first_name')}}">
                                @error('first_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{old('last_name')}}">
                                @error('last_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">D.O.B</label>
                                <input type="text" class="form-control basic-datepicker @error('client_dob') is-invalid @enderror" name="client_dob" value="{{old('client_dob')}}">
                                <span>Date must be in YYYY-MM-DD (2012-12-22) format.</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Client Id</label>
                                <input type="text" class="form-control @error('client_id') is-invalid @enderror" name="client_id" value="{{old('client_id')}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h4 class="header-title">Address</h4>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>Street</label>
                    <input type="text" class="form-control @error('street') is-invalid @enderror" name="street" value="{{old('street')}}">
                </div>
                <div class="col-md-4 mb-3">
                    <label>City</label>
                    <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{old('city')}}">
                </div>
                <div class="col-md-4 mb-3">
                    <label>State</label>
                    <input type="text" class="form-control @error('state') is-invalid @enderror" name="state" value="{{old('state')}}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label>Post Code</label>
                    <input type="text" class="form-control " name="post_code" value="{{old('post_code')}}">
                </div>
                <div class="col-md-4">
                    <label>Country</label>
                    <select name="country_id" id="" class="form-control" data-toggle="select2" data-width="100%">
                        <option value="">Select country</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->countryname }}</option>
                        @endforeach
                    </select>
                    @error('country_id')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h4 class="header-title">Contact Details</h4>
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{old('email')}}">
                        @error('email')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" value="{{old('phone')}}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Contact Preference</label>
                        <div class="d-flex">
                            <div class="form-check me-2">
                                <input class="form-check-input" type="radio" name="ContactPreference" id="ContactPreferenceemail" value="1" checked>
                                <label class="form-check-label" for="ContactPreferenceemail">
                                    Email
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="ContactPreference" id="ContactPreferencephone" value="0">
                                <label class="form-check-label" for="ContactPreferencephone">
                                    Phone
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h4 class="header-title">Current Visa Information</h4>
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Preferred Intake</label>
                        <input type="text" class="form-control basic-datepicker" name="preferred_intake" value="{{old('preferred_intake')}}">
                        <span>Date must be in YYYY-MM-DD (2012-12-22) format.</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Country of Passport</label>

                        <select name="country_passport" id="pass_country" class="form-control" data-toggle="select2" data-width="100%">
                            <option value="">Select country</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->countryname }}</option>
                            @endforeach
                        </select>

                        @error('country_passport')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Passport Number</label>
                        <input type="text" class="form-control @error('passport_number') is-invalid @enderror" name="passport_number" value="{{old('passport_number')}}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Visa Type</label>
                        <input type="text" class="form-control " name="visa_type" value="{{old('visa_type')}}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Visa Expiry Date</label>
                        <input type="text" class="form-control basic-datepicker" name="visa_expiry" value="{{old('visa_expiry')}}">
                        <span>Date must be in YYYY-MM-DD (2012-12-22) format.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h4 class="header-title">Applications</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">Application</label>
                        <select class="form-control application_select" id="Applicationselect" name="application" data-width="100%">

                        </select>
                        <div id="applicationList"></div>
                    </div>
                </div>
            </div>

            <div class="main-content">
                <div class="heading-content">
                    <h6 class="heading-application">Selected Applications
                        <small style="font-size: 8px;">(1 item selected)</small>
                    </h6>
                    <h6 class="heading-name">Workflow</h6>
                    <h6 class="heading-name">Stage</h6>
                </div>
                <div class="body-content application-append"></div>
            </div>

        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h4 class="header-title">Internal</h4>
            <div class="row align-items-end">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Assignee <span class="text-danger">*</span></label>
                        <select class="form-control @error('assignee_id') is-invalid @enderror" name="assignee_id" id="">
                            <option value="">Select Assignee</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->first_name.' '.$user->last_name.' ( '.$user->office->office_name.' ) ' }}</option>
                            @endforeach
                        </select>
                        @error('assignee_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Followers</label>
                        <select class="form-control @error('followers') is-invalid @enderror" name="follower_id" id="">
                            @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->first_name.' '.$user->last_name.' ( '.$user->office->office_name.' ) ' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Choose a source</label>
                        <select class="form-control @error('source') is-invalid @enderror" name="source_id" id="source">
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Tag Name</label>
                        <select class="form-control" id="search" name="tag_id" data-toggle="select2" data-width="100%"></select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary"> Save and New </button>
</form>
@endsection

@section('script')
<!-- Datatables init -->
<script src="//unpkg.com/bootstrap-select-country@4.0.0/dist/js/bootstrap-select-country.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.18/js/intlTelInput.min.js"></script>
<script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ asset('assets/libs/spectrum-colorpicker2/spectrum.min.js') }}"></script>
<script src="{{ asset('assets/libs/clockpicker/bootstrap-clockpicker.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var tagpath = "{{ route('backend.manage-autocomplete') }}";
        $('#search').select2({
            placeholder: 'Select an tag',
            ajax: {
                url: tagpath,
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });
        var sourcepath = "{{ route('backend.manage-autosource') }}";
        $('#source').select2({
            placeholder: 'Select an source',
            ajax: {
                url: sourcepath,
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    console.log(data);
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });
        var applicationpath = "{{ route('backend.manage-autoapplication') }}";
        $('#Applicationselect').select2({
            placeholder: 'Select an source',
            ajax: {
                url: applicationpath,
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: data
                    }
                },
                cache: false
            },
            allowClear: true,
            placeholder: 'Select at least one element',
            templateResult: function(d) {
                return $(d.text);
            },
            templateSelection: function(d) {
                return $(d.text);
            }
        });
        $('.application_select').change(function() {
            var productId = $(this).val();
            $.ajax({
                url: "{{ route('backend.application-info-append') }}",
                data: {
                    product_id: productId,
                },
                dataType: 'json',
                success: function(row) {

                    // console.log(row.workflow.service_workflow);

                    // var workflow_array = '';
                    // for(var i=0; i< row.workflow.length; i++){
                    //     workflow += '<option value="">'+row.workflow.service_workflow+'</option>';
                    // }

                    // var stage = '';
                    // for(var i=0; i< row.stage_id.length; i++){
                    //     stage += '<option value="1">Application</option><option value="2">Offer Letter</option><option value="3">Fee Payment</option><option value="4">COE</option><option value="5">Visa Application</option><option value="6">Enrolment</option><option value="7">Course Ongoing</option><option value="8">Completed</option>';
                    // }

                    var html = '';
                    html += '<input type="hidden" name="product_id" value="' + row.id + '"><input type="hidden" name="partner_id" value="' + row.partner.id + '"><div class="body-item"><div class="body-title mb-2"><div><p class="m-0">' + row.name + '</p><small>' + row.partner.name + ' ( ' + row.partner_branches.name + ')</small></div></div><div class="body-workflow"><select name="workflow_id" id="workflow" class="form-control"><option value="' + row.workflow.id + '">' + row.workflow.service_workflow + '</option></select></div><div class="body-stage"><select name="stage_id" id="application" class="form-control"><option value="1">Application</option><option value="2">Offer Letter</option><option value="3">Fee Payment</option><option value="4">COE</option><option value="5">Visa Application</option><option value="6">Enrolment</option><option value="7">Course Ongoing</option><option value="8">Completed</option></select></div><div><i class="mdi mdi-delete-outline text-danger mdi-18px removetr"></i></div></div>';

                    $('.application-append').append(html);

                }
            });
        });
        $('.countrypicker').countrypicker();
        $('.dropify').dropify();
        $(".basic-datepicker").flatpickr();
        $(".basic-timepicker").flatpickr({
            enableTime: !0,
            noCalendar: !0,
            dateFormat: "H:i"
        });

        $('[data-toggle="select2"]').select2();

    });

    $(document).delegate('.removetr', 'click', function() {
        $(this).parent().parent('.body-item').remove();
    });
    var countryData = window.intlTelInputGlobals.getCountryData(),
        input = document.querySelector("#phone");
    for (var i = 0; i < countryData.length; i++) {
        var country = countryData[i];
        country.name = country.name.replace(/.+\((.+)\)/, "$1");
    }
    window.intlTelInput(input, {
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.18/js/utils.min.js" // just for formatting/placeholders etc
    });

    // pass_country


</script>
@endsection