@extends('backend.layouts.app')
@section('css')

<link rel="stylesheet" href="//unpkg.com/bootstrap-select-country@4.0.0/dist/css/bootstrap-select-country.min.css" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.18/css/intlTelInput.css" />
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

@section('content')
<h4 class="mt-0 header-title ">
    Add New Partner
</h4>

@if(Session::has('error'))
<div class="alert alert-danger" style="text-align: center;">
    {{ Session::get('error') }}
</div>
@endif

<form id="partnerAdd" action="{{route('backend.save-partner')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card">
        <div class="card-body">
            <h4 class="header-title">Primary Information</h4>
            <div class="row">
                <div class="col-md-3">
                    <label class="form-label">Profile image <span class="text-danger">*</span></label>
                    <input type="file" name="partner_image" class="dropify" data-default-file="" data-height="205" />
                    @error('partner_image')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Master Category <span class="text-danger">*</span></label>
                                <select name="master_category_id" id="masterCategory" class="form-control" data-toggle="select2" data-width="100%">
                                    <option value="">Select a Master Category</option>
                                    @foreach($masterCategories as $masterCategory)
                                    <option value="{{ $masterCategory->id }}">
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
                                <select name="partner_type" id="partnerType" class="form-control" data-toggle="select2" data-width="100%">
                                    <option value="">Select a Partner Type</option>
                                </select>
                                @error('partner_type')
                                <span class="text-danger">{{ $message }}</s>
                                    @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Partner Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                @error('name')
                                <span class="text-danger">{{ $message }}</s>
                                    @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Business Registration Number</label>
                                <input type="text" class="form-control" name="registration_number">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Service Workflow <span class="text-danger">*</span></label>
                                <select name="workflow_id[]" class="form-control" data-toggle="select2" data-width="100%" multiple>
                                    @foreach($workflowCategories as $workflowCategory)
                                    <option value="{{ $workflowCategory->id }}">
                                        {{ $workflowCategory->service_workflow }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('workflow_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Currency <span class="text-danger">*</span></label>
                                <select name="currency_id" class="form-control" data-toggle="select2" data-width="100%">
                                    <option value="">Choose currency</option>
                                    @foreach($currencies as $currency)
                                    <option value="{{ $currency->id }}">{{ $currency->currency_code }}</option>
                                    @endforeach
                                </select>
                                @error('currency_id')
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
                        <input type="text" class="form-control" name="street" value="{{ old('street') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">City</label>
                        <input type="text" class="form-control" name="city" value="{{ old('city') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">State</label>
                        <input type="text" class="form-control" name="state" value="{{ old('state') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Zip/Post Code</label>
                        <input type="text" class="form-control" name="post_code" value="{{ old('post_code') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Country</label>
                        <select name="country_id" class="form-control" data-toggle="select2" data-width="100%">
                            <option value="">Select Country</option>
                            @foreach($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->countryname }}</option>
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
                        <input type="tel" class="form-control" id="phone" name="phone_number" value="{{ old('phone_number') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control partner_email" name="email" value="{{ old('email') }}">
                        @error('email')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Fax</label>
                        <input type="text" class="form-control" name="fax" value="{{ old('fax') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Website</label>
                        <input type="text" class="form-control" name="website" value="{{ old('website') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h4 class="header-title">Branch <span class="text-danger">*</span></h4>
            
            <!-- <div class="row align-items-end">
                <div class="col-md-3">
                    <div class="mb-3"><label class="form-label">Name <span class="text-danger">*</span></label><input type="text" class="form-control branch_name" name="branch_name" value="Head Office"></div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3"><label class="form-label">Email <span class="text-danger">*</span></label><input type="text" class="form-control branch_email" name="branch_email"></div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3"><label class="form-label">Country</label><input type="text" class="form-control" name="branch_country_id"></div>
                </div>
                <div class="col-md-2">
                    <div class="mb-3"><label class="form-label">City</label><input type="text" class="form-control" name="branch_city"></div>
                </div>
                <div class="col-md-1">
                    <div class="mb-3"><button type="button" class="btn btn-default" onclick="clickFunctionEdit(0)"><i class="mdi mdi-file-document-edit-outline"></i></button></div>
                </div>
            </div> -->
            <!-- <div class="row align-items-end singleBranch"></div> -->

            <div class="row align-items-end appendedBranch"></div>

            <a href="javascript:;" id="branchModel">+ Add another Branch</a>
            <textarea name="branch" class="d-none" id="branchData"></textarea>
        </div>
    </div>
    <button type="submit" class="btn btn-primary"> Save and New </button>
</form>


<!-- Standard modal content -->
<div id="addbranch" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form id="branchForm">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Add new branch</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="card">
                        <div class="card-body">
                            <div class="mb-2">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control name" name="name">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="text" class="form-control email" name="email">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Country</label>
                                <select name="country_id" class="form-control country" data-width="100%">
                                    <option value="">Select Country</option>
                                    @foreach($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->countryname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">City</label>
                                <input type="text" class="form-control city" name="city">
                            </div>

                            <div class="more_fields_value d-none">
                                <div class="mb-2">
                                    <label class="form-label">State</label>
                                    <input type="text" class="form-control state" name="state">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Street</label>
                                    <input type="text" class="form-control street" name="street">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Zip Code</label>
                                    <input type="text" class="form-control post_code" name="post_code">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Phone Number</label><br>
                                    <input type="tel" id="branch_phone" class="form-control phone" name="phone">
                                </div>
                            </div>

                            <div class="more_fields">
                                <a href="javascript:void(0)" class="text-primary moreFields">More Fields</a>
                            </div>
                            <div class="less_fields d-none">
                                <a href="javascript:void(0)" class="text-primary lessFields">Less Fields</a>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <div class="mb-2">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="saveBranch" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Standard modal content -->
<div id="updateBranch" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Update branch</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body updateBranchContent">

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


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

    $(document).ready(function() {
        $('.country').select2({
            dropdownParent: $('#addbranch'),
        });

        $('.more_fields').on("click", function() {
            $('.more_fields_value').removeClass('d-none');
            $('.less_fields').removeClass('d-none');
            $('.more_fields').addClass('d-none');
        });

        $('.lessFields').on("click", function() {
            $('.more_fields_value').addClass('d-none');
            $('.less_fields').addClass('d-none');
            $('.more_fields').removeClass('d-none');
        });
    });

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
        var country_id = $('.country').val();
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
            'country_id': country_id,
            'city': city,
            'state': state,
            'street': street,
            'post_code': post_code,
            'phone': phone,
        }
        console.log(arrBranch);

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

            var countries = <?php echo json_encode($countries); ?>;
            var countryValue = '';
            for (var j = 0; j < countries.length; j++) {
                if (data[i].country_id == countries[j].id) {
                    countryValue += '<option value="' + countries[j].id + '" selected>' + countries[j].countryname + '</option>';
                }
            }

            html += '<div class="col-md-3"><div class="mb-3"><label class="form-label">Name <span class="text-danger">*</span></label><input type="text" class="form-control branch_name" name="branch_name" value="' + data[i].name + '"></div></div><div class="col-md-3"><div class="mb-3"><label class="form-label">Email <span class="text-danger">*</span></label><input type="text" class="form-control branch_email" name="branch_email" value="' + data[i].email + '"></div></div><div class="col-md-3"><div class="mb-3"><label class="form-label">Country</label><select class="form-control branch_country_id" name="branch_country_id">' + countryValue + '</select></div></div><div class="col-md-2"><div class="mb-3"><label class="form-label">City</label><input type="text" class="form-control branch_city" name="branch_city" value="' + data[i].city + '"></div></div><div class="col-md-1"><div class="mb-3"><button type="button" class="btn btn-default" onclick="clickFunctionEdit(' + i + ')"><i class="mdi mdi-file-document-edit-outline"></i></button><button type="button" class="btn btn-default" onclick="branchDelete(' + i + ')" id="deleteBranch"><i class="mdi mdi-delete"></i></button></div></div>';
        }

        $('.appendedBranch').html(html);

    }

    function clickFunctionEdit(id) {
        $('#updateBranch').modal("show");
    
        var countries = <?php echo json_encode($countries); ?>;

        var country = '';
        for (var i = 0; i < countries.length; i++) {
            if(branchArray[id].country_id != ''){
                var selected = (branchArray[id].country_id == countries[i].id ? 'selected' : '');
            }
            country += '<option value="' + countries[i].id + '" ' + selected + '>' + countries[i].countryname + '</option>';
        }

        var html = '';
        html += '<div class="card"><div class="card-body"><div class="mb-2"><label class="form-label">Name <span class="text-danger">*</span></label><input type="text" class="form-control" id="name" name="name" value="' + branchArray[id].name + '"></div><div class="mb-2"><label class="form-label">Email <span class="text-danger">*</span></label><input type="text" class="form-control" id="email" name="email" value="' + branchArray[id].email + '"></div><div class="mb-2"><label class="form-label">Country</label><select name="country_id" class="form-control" id="country" data-width="100%"><option value="">Select Country</option>' + country + '</select></div><div class="mb-2"><label class="form-label">City</label><input type="text" class="form-control" id="city" name="city" value="' + branchArray[id].city + '"></div><div class="d-none" id="more_fields_value"><div class="mb-2"><label class="form-label">State</label><input type="text" class="form-control" id="state" name="state" value="' + branchArray[id].state + '"></div><div class="mb-2"><label class="form-label">Street</label><input type="text" class="form-control" id="street" name="street" value="' + branchArray[id].street + '"></div><div class="mb-2"><label class="form-label">Zip Code</label><input type="text" class="form-control" id="postCode" name="post_code" value="' + branchArray[id].post_code + '"></div><div class="mb-2"><label class="form-label">Phone Number</label><input type="tel" class="form-control" id="phone_number" name="phone" value="' + branchArray[id].phone + '"></div></div><div class="mb-2" id="more_fields"><a href="javascript:void(0)" class="text-primary" id="moreFields">More Fields</a></div><div class="mb-2 d-none" id="less_fields"><a href="javascript:void(0)" class="text-primary mb-2" id="lessFields">Less Fields</a></div><button type="button" class="btn btn-primary px-5 w-100" onclick="branchReplace(' + id + ')"> Update Groups</button></div></div>';

        $('.updateBranchContent').html(html);
        $('#country').select2({
            dropdownParent: $('#updateBranch'),
        });
        $('#more_fields').on("click", function() {
            $('#more_fields_value').removeClass('d-none');
            $('#less_fields').removeClass('d-none');
            $('#more_fields').addClass('d-none');
        });
        $('#lessFields').on("click", function() {
            $('#more_fields_value').addClass('d-none');
            $('#less_fields').addClass('d-none');
            $('#more_fields').removeClass('d-none');
        });

        var update_branch_phone = document.querySelector("#phone_number");
        window.intlTelInput(update_branch_phone, {
            initialCountry: 'bd',
            placeholderNumberType: 'FIXED_LINE',
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.18/js/utils.min.js"
        });
    }

    function branchReplace(id) {
        $('#updateBranch').modal('hide');

        var name = $('#name').val();
        var email = $('#email').val();
        var country_id = $('#country').val();
        var city = $('#city').val();
        var state = $('#state').val();
        var street = $('#street').val();
        var post_code = $('#postCode').val();
        var phone = $('#phone_number').val();

        var arrBranch = {
            'name': name,
            'email': email,
            'country_id': country_id,
            'city': city,
            'state': state,
            'street': street,
            'post_code': post_code,
            'phone': phone,
        }

        branchArray.splice(id, 1, arrBranch);
        console.log(branchArray);

        $('#branchData').val(JSON.stringify(branchArray));
        showInsertedBranchData(branchArray);
    }

    function branchDelete(id) {
        branchArray.splice(id, 1);
        $('#branchData').val(branchArray)
        var html = "";

        for (var i = 0; i < branchArray.length; i++) {
            var g = i + 1;

            html += '<div class="col-md-3"><div class="mb-3"><label class="form-label">Name <span class="text-danger">*</span></label><input type="text" class="form-control" name="" value="' + branchArray[i].name + '"></div></div><div class="col-md-3"><div class="mb-3"><label class="form-label">Email <span class="text-danger">*</span></label><input type="text" class="form-control" name="" value="' + branchArray[i].email + '"></div></div><div class="col-md-2"><div class="mb-3"><label class="form-label">Country</label><input type="text" class="form-control" name="" value="' + branchArray[i].country_id + '"></div></div><div class="col-md-2"><div class="mb-3"><label class="form-label">City</label><input type="text" class="form-control" name="" value="' + branchArray[i].city + '"></div></div><div class="col-md-2"><div class="mb-3"><button type="button" class="btn btn-default" onclick="clickFunctionEdit(' + i + ')"><i class="mdi mdi-file-document-edit-outline"></i></button><button type="button" class="btn btn-default" onclick="branchDelete(' + i + ')" id="deleteBranch"><i class="mdi mdi-delete"></i></button></div></div>';
        }

        $('.appendedBranch').html(html);
    }

    $(document).ready(function() {
        $('[data-toggle="select2"]').select2();
        $('.dropify').dropify();
    });

    var phone = document.querySelector("#phone");
    var branch_phone = document.querySelector("#branch_phone");
    window.intlTelInput(phone, {
        initialCountry: 'bd',
        placeholderNumberType: 'FIXED_LINE',
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.18/js/utils.min.js"
    });
    window.intlTelInput(branch_phone, {
        initialCountry: 'bd',
        placeholderNumberType: 'FIXED_LINE',
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.18/js/utils.min.js"
    });
</script>
@endsection