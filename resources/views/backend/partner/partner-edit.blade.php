@extends('backend.layouts.app')
@section('css')

<link rel="stylesheet" href="//unpkg.com/bootstrap-select-country@4.0.0/dist/css/bootstrap-select-country.min.css" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.18/css/intlTelInput.css" />

@endsection

@section('content')
<h4 class="mt-0 header-title ">
    Add New Partner
</h4>
<form id="partnerAdd" action="{{route('backend.updatepartner')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{ $partner->id }}">

    <div class="card">
        <div class="card-body">
            <h4 class="header-title">Primary Information</h4>
            <div class="row">
                <div class="col-md-3">
                    <label class="form-label">Profile image</label>
                    <input type="file" name="partner_image" class="dropify" data-default-file="{{ asset($partner->partner_image) }}" data-height="205" />
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Master Category <span class="text-danger">*</span></label>
                                <select name="master_category_id" id="" class="form-control" data-toggle="select2" data-width="100%">
                                    <option value="">Select a Master Category</option>
                                    @foreach($masterCategories as $masterCategory)
                                    <option value="{{ $masterCategory->id }}"
                                    {{ $masterCategory->master_category == $partner->masterCategory->master_category ? 'selected' : '' }}
                                    >
                                        {{ $masterCategory->master_category }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('master_category_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Partner Type <span class="text-danger">*</span></label>
                                <select name="partner_type" id="" class="form-control" data-toggle="select2" data-width="100%">
                                    <option value="">Select a Partner Type</option>
                                    @foreach($partnerTypes as $partnerType)
                                    <option value="{{ $partnerType->id }}"
                                    {{ $partnerType->partner_type == $partner->partnerType->partner_type ? 'selected' : '' }}
                                    >
                                        {{ $partnerType->partner_type }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('partner_type')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Partner Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" value="{{ $partner->name }}">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Business Registration Number</label>
                                <input type="text" class="form-control" name="registration_number" value="{{ $partner->registration_number }}">
                            </div>
                        </div>
                         @php
                            if($partner->workflow_id)
                            {
                                $workflow=explode(',',$partner->workflow_id);
                            }
                        @endphp
                           <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Service Workflow <span class="text-danger">*</span></label>
                                <select name="workflow_id[]" class="form-control" data-toggle="select2" data-width="100%" multiple>
                                    <option value="">Choose service workflow</option>
                                    @foreach($workflowCategories as $workflowCategory)
                                  
                                    @if($workflow != '')
                                       @foreach($workflow as $workflows)

                                            <option value="{{ $workflowCategory->id }}"
                                            {{ $workflowCategory->id == $workflows ? 'selected' : '' }}
                                            >
                                                {{ $workflowCategory->service_workflow }}
                                            </option>
                                        @endforeach
                                    @endif   
                                    @endforeach
                                </select>
                                @error('workflow_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
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
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Street</label>
                        <input type="text" class="form-control" name="street" value="{{ $partner->street }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">City</label>
                        <input type="text" class="form-control" name="city" value="{{ $partner->city }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">State</label>
                        <input type="text" class="form-control" name="state" value="{{ $partner->state }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Zip/Post Code</label>
                        <input type="text" class="form-control" name="post_code" value="{{ $partner->post_code }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Country</label>
                        <select name="country" class="form-control">
                            <option value="">Select Country</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}"
                                    {{ $country->id == $partner->country ? 'selected' : '' }}>{{ $country->countryname }}</option>
                            @endforeach
                        </select>
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
                        <label class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="phone" name="phone_number" value="{{ $partner->phone_number }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" value="{{ $partner->email }}">
                        @error('email')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Fax</label>
                        <input type="text" class="form-control" name="fax" value="{{ $partner->fax }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Website</label>
                        <input type="text" class="form-control" name="website" value="{{ $partner->website }}">
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

<!-- js validation -->
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<!-- <script src="{{ asset('js/jsvalidation.js') }}"></script> -->

<script type="text/javascript">
    var branchArray = [];

    $('#branchModel').on("click", function() {
        $('.name').val('');
        $('.email').val('');
        $('.city').val('');
        $('.state').val('');
        $('.street').val('');
        $('.post_code').val('');
        $('.phone').val('');
        $('#addbranch').modal("show");
    });

    $('#saveBranch').click(function(e) {
        e.preventDefault();

        var name = $('.name').val();
        var email = $('.email').val();
        var country = $('.country').val();
        var city = $('.city').val();
        var state = $('.state').val();
        var street = $('.street').val();
        var post_code = $('.post_code').val();
        var phone = $('.phone').val();

        if (name == '') {
            alert('Name is Empty');
            return;
        }
        if (email == '') {
            alert('Email is Empty');
            return;
        }

        var arrBranch = {
            'name': name,
            'email': email,
            'country': country,
            'city': city,
            'state': state,
            'street': street,
            'post_code': post_code,
            'phone': phone,
        }
        // console.log(arrBranch);

        branchArray.push(arrBranch);
        // showSuggestedBranch(branchArray);

        $('#branchData').val(JSON.stringify(branchArray));
        showInsertedBranchData(branchArray);
        $('#addbranch').modal("hide");

    });

    $('#masterCategory').on("change", function() {
        var master_category_id = $(this).val();
        $.ajax({
            url: "{{ route('backend.get-partner-type') }}",
            data: {
                'master_category_id': master_category_id
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function(data) {
                $('#partnerType').html("");
                if (data != undefined && data != null) {
                    var optionValue = '';
                    for (var i = 0; i < data.length; i++) {
                        optionValue += '<option value="' + data[i].id + '">' + data[i].partner_type + '</option>';
                    }
                    $('#partnerType').append(optionValue);
                }
            }
        });
    });

    function showInsertedBranchData(data) {

        $('.name').val('');
        $('.email').val('');
        $('.city').val('');
        $('.state').val('');
        $('.street').val('');
        $('.post_code').val('');
        $('.phone').val('');

        var html = "";

        for (var i = 0; i < data.length; i++) {
            var g = i + 1;

            html += '<div class="col-md-3"><div class="mb-3"><label class="form-label">Name <span class="text-danger">*</span></label><input type="text" class="form-control" name="" value="' + data[i].name + '"></div></div><div class="col-md-3"><div class="mb-3"><label class="form-label">Email <span class="text-danger">*</span></label><input type="text" class="form-control" name="" value="' + data[i].email + '"></div></div><div class="col-md-2"><div class="mb-3"><label class="form-label">Country</label><input type="text" class="form-control" name="" value="' + data[i].country + '"></div></div><div class="col-md-2"><div class="mb-3"><label class="form-label">City</label><input type="text" class="form-control" name="" value="' + data[i].city + '"></div></div><div class="col-md-2"><div class="mb-3"><button type="button" class="btn btn-default" onclick="clickFunctionEdit(' + i + ')"><i class="mdi mdi-file-document-edit-outline"></i></button><button type="button" class="btn btn-default" onclick="branchDelete(' + i + ')" id="deleteBranch"><i class="mdi mdi-delete"></i></button></div></div>';
        }

        $('.appendedBranch').html(html);

    }

    function clickFunctionEdit(id) {
        $('#updateBranch').modal("show");

        var html = '';
        html += '<div class="mb-3"><label class="form-label">Name <span class="text-danger">*</span></label><input type="text" class="form-control" id="name" name="name" value="' + branchArray[id].name + '"></div><div class="mb-3"><label class="form-label">Email <span class="text-danger">*</span></label><input type="text" class="form-control" id="email" name="email" value="' + branchArray[id].email + '"></div><div class="mb-3"><label class="form-label">Country</label><select name="country" class="selectpicker countrypicker form-control" id="country" data-width="100%"></select></div><div class="mb-3"><label class="form-label">City</label><input type="text" class="form-control" id="city" name="city" value="' + branchArray[id].city + '"></div><div class="mb-3"><label class="form-label">State</label><input type="text" class="form-control" id="state" name="state" value="' + branchArray[id].state + '"></div><div class="mb-3"><label class="form-label">Street</label><input type="text" class="form-control" id="street" name="street" value="' + branchArray[id].street + '"></div><div class="mb-3"><label class="form-label">Zip Code</label><input type="text" class="form-control" id="postCode" name="post_code" value="' + branchArray[id].post_code + '"></div><div class="mb-3"><label class="form-label">Phone Number</label><input type="tel" id="phone" class="form-control phone_number" name="phone_number" value="' + branchArray[id].phone + '"></div><button type="button" class="btn btn-primary px-5 w-100" onclick="branchReplace(' + id + ')"> Update Groups</button></div></div>';

        $('.updateBranchContent').html(html);
    }

    function branchReplace(id) {
        $('#updateBranch').modal('hide');

        var name = $('#name').val();
        var email = $('#email').val();
        var country = $('#country').val();
        var city = $('#city').val();
        var state = $('#state').val();
        var street = $('#street').val();
        var post_code = $('#postCode').val();
        var phone = $('.phone_number').val();

        var arrBranch = {
            'name': name,
            'email': email,
            'country': country,
            'city': city,
            'state': state,
            'street': street,
            'post_code': post_code,
            'phone': phone,
        }

        branchArray.splice(id, 1, arrBranch);

        $('#branchData').val(JSON.stringify(branchArray));
        showInsertedBranchData(branchArray);
    }

    function branchDelete(id) {
      branchArray.splice(id, 1);
      $('#branchData').val(branchArray)
      var html = "";

      for (var i = 0; i < branchArray.length; i++) {
         var g = i + 1;

         html += '<div class="col-md-3"><div class="mb-3"><label class="form-label">Name <span class="text-danger">*</span></label><input type="text" class="form-control" name="" value="' + branchArray[i].name + '"></div></div><div class="col-md-3"><div class="mb-3"><label class="form-label">Email <span class="text-danger">*</span></label><input type="text" class="form-control" name="" value="' + branchArray[i].email + '"></div></div><div class="col-md-2"><div class="mb-3"><label class="form-label">Country</label><input type="text" class="form-control" name="" value="' + branchArray[i].country + '"></div></div><div class="col-md-2"><div class="mb-3"><label class="form-label">City</label><input type="text" class="form-control" name="" value="' + branchArray[i].city + '"></div></div><div class="col-md-2"><div class="mb-3"><button type="button" class="btn btn-default" onclick="clickFunctionEdit(' + i + ')"><i class="mdi mdi-file-document-edit-outline"></i></button><button type="button" class="btn btn-default" onclick="branchDelete(' + i + ')" id="deleteBranch"><i class="mdi mdi-delete"></i></button></div></div>';
      }

      $('.appendedBranch').html(html);
   }

    $(document).ready(function() {
        $('[data-toggle="select2"]').select2();
        $('.countrypicker').countrypicker();
        $('.dropify').dropify();
    });

    // $("body").delegate(".countrypicker", function(){
    //     $(this).countrypicker();
    // });

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