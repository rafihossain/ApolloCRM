@extends('backend.layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}" type="text/css" />
<link rel="stylesheet" href="//unpkg.com/bootstrap-select-country@4.0.0/dist/css/bootstrap-select-country.min.css" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.18/css/intlTelInput.css" />
<link rel="stylesheet" href="{{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" type="text/css"  />

<style type="text/css">
    body .iti {
        display: block;
    }
</style>
@endsection
@section('content')

<h4 class="mt-0 header-title text-end mb-2">
    <a href="{{ route('backend.agent-active-list') }}" class="btn btn-primary">Agent List</a>
</h4>

<form method="POST" action="{{ route('backend.agent-update') }}" enctype="multipart/form-data" class="pb-4">
    @csrf
    <input type="hidden" name="agent_id" value="{{ $agent->id }}">

    <div class="card">
        <div class="card-body">
            <h4 class="header-title"> Agent Type </h4>

            <div class="mt-3 d-flex">
                <div class="form-check me-2">
                    <input type="hidden" name="super_agent" value="0">
                    <input type="checkbox" class="form-check-input" id="customCheck1" name="super_agent" value="1"
                    {{ $agent->super_agent == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="customCheck1">Super Agent</label>
                </div>
                <div class="form-check">
                    <input type="hidden" name="sub_agent" value="0">
                    <input type="checkbox" class="form-check-input" id="customCheck2" name="sub_agent" value="1"
                    {{ $agent->sub_agent == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="customCheck2">Sub Agent</label>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h4 class="header-title">Agent Structure</h4>
            <div class="mt-3 d-flex">
                <input type="hidden" name="agent_structure" value="{{ $agent->agent_structure }}">
                <div class="form-check me-2">
                    <input type="radio" id="customRadio1" class="form-check-input individual"
                    data-id="{{$agent->agent_structure}}" name="agent_structure" value="1" disabled
                    {{ $agent->agent_structure == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="customRadio1">Individual</label>
                </div>
                <div class="form-check">
                    <input type="radio" id="customRadio2" class="form-check-input business"
                    data-id="{{$agent->agent_structure}}" name="agent_structure" value="2" disabled
                    {{ $agent->agent_structure == 2 ? 'checked' : '' }}>
                    <label class="form-check-label" for="customRadio2">Business</label>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="mb-2 show-personal">
                <h4 class="header-title mb-4">Personal Details</h4>
                <div class="row">
                    <div class="col-md-4">
                        <input type="file" class="dropify" name="personal_image" data-default-file="{{ asset($agent->profile_image) }}" data-height="205" />
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control" name="full_name" value="{{ $agent->full_name }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-2 show-business d-none">
                <h4 class="header-title mb-4">Business Details</h4>
                <div class="row">
                    <div class="col-md-4">
                        <input type="file" class="dropify" name="business_image" data-default-file="{{ asset($agent->profile_image) }}" data-height="205" />
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Business Name</label>
                                <input type="text" class="form-control" name="business_name" value="{{ $agent->business_name }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Contact Name</label>
                                <input type="text" class="form-control" name="contact_name" value="{{ $agent->contact_name }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tax Number</label>
                                <input type="text" class="form-control" name="tax_number" value="{{ $agent->tax_number }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Expiry Date</label>
                                <input type="text" class="form-control" id="datetime-datepicker" name="expiry_date" value="{{ $agent->expiry_date }}">
                            </div>
                        </div>
                    </div>
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
                        <label class="form-label">Phone No.</label>
                        <input type="tel" class="form-control" id="phone" name="phone_number" value="{{ $agent->phone_number }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="{{ $agent->email }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h4 class="header-title">Address</h4>
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Street</label>
                        <input type="text" class="form-control" name="street" value="{{ $agent->street }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">City</label>
                        <input type="text" class="form-control" name="city" value="{{ $agent->city }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">State</label>
                        <input type="text" class="form-control" name="state" value="{{ $agent->state }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Zip/Post Code</label>
                        <input type="text" class="form-control" name="post_code" value="{{ $agent->post_code }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Country</label>
                        <select class="form-control" name="country_id" data-toggle="select2" data-width="100%">
                            <option value="">Select Country</option>
                            @foreach($countries as $country)
                            <option value="{{ $country->id }}" 
                            {{ $agent->country_id == $country->id ? 'selected' : '' }}>{{ $country->countryname }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h4 class="header-title">Office and Income Sharing Details</h4>
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Related Office</label>
                        <select class="form-control" name="office_id" data-toggle="select2" data-width="100%">
                            <option value="">Please select an office</option>
                            @foreach($offices as $office)
                            <option value="{{ $office->id }}"
                            {{ $agent->office_id == $office->id ? 'selected' : '' }}>{{ $office->office_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary"> Save </button>
</form>


@endsection
@section('script')
<!-- Datatables init -->
<script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.18/js/intlTelInput.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="//unpkg.com/bootstrap-select-country@4.0.0/dist/js/bootstrap-select-country.min.js"></script>
<script src="{{ asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {

		var individual = $('.individual').data('id');
		if(individual == 1){
			$('.show-personal').removeClass('d-none');
            $('.show-business').addClass('d-none');
		}
		if(individual == 2){
			$('.show-personal').addClass('d-none');
            $('.show-business').removeClass('d-none');
		}

        $('.individual').on('change', function (){
            $('.show-personal').removeClass('d-none');
            $('.show-business').addClass('d-none');
        });
        $('.business').on('change', function (){
            $('.show-personal').addClass('d-none');
            $('.show-business').removeClass('d-none');
        });


        $('[data-toggle="select2"]').select2();
        $('#summereditor').summernote();
        $('.dropify').dropify();
        var countryData = window.intlTelInputGlobals.getCountryData(),
            input = document.querySelector("#phone");

        for (var i = 0; i < countryData.length; i++) {
            var country = countryData[i];
            country.name = country.name.replace(/.+\((.+)\)/, "$1");
        }

        $("#datetime-datepicker").flatpickr({
            enableTime: !0,
            dateFormat: "Y-m-d H:i"
        });

        window.intlTelInput(input, {
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.18/js/utils.min.js" // just for formatting/placeholders etc
        });
    });
</script>
@endsection