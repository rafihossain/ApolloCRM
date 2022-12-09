@extends('backend.layouts.app')
@section('content')

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
</style>
@endsection

<form action="{{route('backend.update-client')}}" method="POST" enctype="multipart/form-data">
    @csrf

    <input type="hidden" name="id" value="{{ $client->id }}">

    <div class="card">
        <div class="card-body">
            <h4 class="header-title">PERSONAL DETAILS</h4>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label>Client Image</label>
                    <input type="file" class="dropify form-control @error('client_image') is-invalid @enderror" name="client_image" data-default-file="{{ asset($client->client_image) }}">

                    @error('client_image')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="col-md-8">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ $client->first_name }}">
                            @error('first_name')
                            <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label>Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ $client->last_name }}">
                            @error('last_name')
                            <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>D.O.B</label>
                            <input type="text" class="form-control @error('client_dob') is-invalid @enderror" name="client_dob" value="{{ $client->client_dob }}">
                            <span>Date must be in YYYY-MM-DD (2012-12-22) format.</span>
                            @error('client_dob')
                            <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label>Client Id</label>
                            <input type="text" class="form-control @error('client_id') is-invalid @enderror" name="client_id" value="{{ $client->client_id }}">
                            @error('client_id')
                            <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h4 class="header-title">CONTACT DETAILS</h4>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label>Email</label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $client->email }}">
                    @error('email')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label>Phone</label>
                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" value="{{ $client->phone }}">
                    @error('phone')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label>Contact Preference</label>

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

    <div class="card">
        <div class="card-body">
            <h4 class="header-title">ADDRESS</h4>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label>Street</label>
                    <input type="text" class="form-control @error('street') is-invalid @enderror" name="street" value="{{ $client->street }}">
                    @error('street')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label>City</label>
                    <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ $client->city }}">
                    @error('city')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label>State</label>
                    <input type="text" class="form-control @error('state') is-invalid @enderror" name="state" value="{{ $client->state }}">
                    @error('state')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label>Zip/Post Code</label>
                    <input type="text" class="form-control " name="post_code" value="{{ $client->post_code }}">
                    @error('post_code')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label>Country <span class="text-danger">*</span></label>
                    <select name="country_id" id="" class="form-control @error('country_id') is-invalid @enderror" data-toggle="select2" data-width="100%" >
                        @foreach($countries as $country)
                        <option value="{{ $country->id }}" {{ $client->country_id==$country->id ? 'selected' :'' }}
                            >{{ $country->countryname }}</option>
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
            <h4 class="header-title">CURRENT VISA INFORMATION</h4>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label>Preferred Intake</label>
                    <input type="text" class="form-control @error('preferred_intake') is-invalid @enderror" name="preferred_intake" value="{{ $client->preferred_intake }}">
                    <span>Date must be in YYYY-MM-DD (2012-12-22) format.</span>
                    @error('preferred_intake')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Country of Passport</label>

                        <select name="country_passport" id="pass_country" class="form-control" data-toggle="select2" data-width="100%">
                            <option value="">Select country</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}" {{ $client->country_passport==$country->id ? 'selected' :'' }}
                                    >{{ $country->countryname }}</option>
                            @endforeach
                        </select>

                        @error('country_passport')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <label>Passport Number</label>
                    <input type="text" class="form-control @error('passport_number') is-invalid @enderror" name="passport_number" value="{{ $client->passport_number }}">
                    @error('passport_number')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label>Visa Type</label>
                    <input type="text" class="form-control" name="visa_type" value="{{ $client->visa_type }}">
                    @error('visa_type')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label>Visa Expiry Date</label>
                    <input type="text" class="form-control" name="visa_expiry" value="{{ $client->visa_expiry }}">
                    <span>Date must be in YYYY-MM-DD (2012-12-22) format.</span>
                    @error('visa_expiry')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h4 class="header-title">INTERNAL</h4>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label>Assignee <span class="text-danger">*</span></label>
                    <select class="form-control @error('assignee_id') is-invalid @enderror" name="assignee_id" id="">
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $client->assignee_id==$user->id ? 'selected' :'' }}
                            >{{ $user->first_name.' '.$user->last_name.' ( '.$user->office->office_name.' ) ' }}</option>
                        @endforeach
                    </select>
                    @error('assignee_id')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label>Followers</label>
                    <select class="form-control @error('follower_id') is-invalid @enderror" name="follower_id" id="">
                        <option value="">Please select & followers</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $client->follower_id==$user->id ? 'selected' :'' }}
                        >{{ $user->first_name.' '.$user->last_name.' ( '.$user->office->office_name.' ) ' }}</option>
                        
                        @endforeach
                    </select>
                    @error('follower_id')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label>Tag Name</label>
                    <select class="form-control" id="" name="tag_id" data-toggle="select2" data-width="100%">
                        <option value="">Search & Select tag</option>
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}" {{ $client->tag_id==$tag->id ? 'selected' :'' }}>{{ $tag->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label>Choose a source</label>
                    <select class="form-control @error('source_id') is-invalid @enderror" id="" name="source_id" data-toggle="select2" data-width="100%">
                        <option value="">Please select source list</option>
                        @foreach($sourceLists as $sourceList)
                            <option value="{{ $sourceList->id }}" {{ $client->source_id==$sourceList->id ? 'selected' :'' }} >{{ $sourceList->source_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center">
        <button class="btn btn-primary" type="submit"> Save </button>
    </div>
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
        $('[data-toggle="select2"]').select2();
        $('.countrypicker').countrypicker();
        $('.dropify').dropify();
        $(".basic-datepicker").flatpickr();
        $(".basic-timepicker").flatpickr({
            enableTime: !0,
            noCalendar: !0,
            dateFormat: "H:i"
        });

        // $('#search').select2({
        //     placeholder: 'Select an tag',
        //     ajax: {
        //         url: "{{ route('backend.manage-autocomplete') }}",
        //         dataType: 'json',
        //         delay: 250,
        //         processResults: function(data) {
        //             return {
        //                 results: $.map(data, function(item) {
        //                     return {
        //                         text: item.name,
        //                         id: item.id
        //                     }
        //                 })
        //             };
        //         },
        //         cache: true
        //     }
        // });
        // $('#source').select2({
        //     placeholder: 'Select an source',
        //     ajax: {
        //         url: "{{ route('backend.manage-autosource') }}",
        //         dataType: 'json',
        //         delay: 250,
        //         processResults: function(data) {
        //             return {
        //                 results: $.map(data, function(item) {
        //                     return {
        //                         text: item.name,
        //                         id: item.id
        //                     }
        //                 })
        //             };
        //         },
        //         cache: true
        //     }
        // });

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


</script>
@endsection