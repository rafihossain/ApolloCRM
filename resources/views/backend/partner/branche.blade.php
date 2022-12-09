@extends('backend.layouts.app')
@section('css')
<link rel="stylesheet" href="//unpkg.com/bootstrap-select-country@4.0.0/dist/css/bootstrap-select-country.min.css" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.18/css/intlTelInput.css" />
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

        @if(Session::has('success'))
            <div class="alert alert-success" style="text-align: center;">
                {{ Session::get('success') }}
            </div>
        @endif


        <div class="text-end mb-3">
            <button type="button" class="btn btn-primary" id="branchModel" >+ Add</button>
        </div>
        <div class="row">

            @foreach($branches as $branch)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="dropdown float-end">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a href="javascript:void(0);" data-id="{{ $branch->id }}" class="dropdown-item editBranchModel">Edit</a>
                                <!-- item-->
                                 
                                <!-- item-->
                                <a href="{{ route('backend.deletepartner-branch', ['id' => $branch->id, 'partner_id'=> $branch->partner_id ] ) }}" id="delete" class="dropdown-item">Delete</a>
                            </div>
                        </div>
                        <h4 class="mb-0"> {{ $branch->name }} &nbsp; </h4>
                        <p> 
                            @if($branch->head_office == 1)
                                <span class="badge bg-primary rounded-pill">Head Office</span>
                            @endif
                        </p>
                        <p class="d-flex "> <i class="mdi mdi-map-marker-outline me-1 mdi-18px text-primary"></i> <small> {{ $branch->street }}</small></p>
                        <hr>
                        <p class="d-flex mb-0 align-items-center"> <i class="mdi mdi-phone-outline me-1 mdi-18px text-primary"></i> <small> {{ $branch->phone_number }} </small></p>
                        <p class="d-flex mb-0 align-items-center"> <i class="mdi mdi-email-outline me-1 mdi-18px text-primary"></i> <small> {{ $branch->email }} </small></p>
                        <div>
                            <span class="badge bg-success rounded-pill">Auto Synced</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            
        </div>
    </div>
</div>

<!-- Standard modal content -->
<div id="addbranch" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="branchForm">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Add new branch</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <input type="hidden" name="partner_id" value="{{ $partner->id }}">
                
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name">
                        <span class="text-danger" id="nameError"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="email">
                        <span class="text-danger" id="emailError"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Country</label>
                        <select name="country_id" class="form-control country" data-width="100%">
                            <option value="">Select Country</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->countryname }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">City</label>
                        <input type="text" class="form-control" name="city">
                    </div>

                    <div class="more_fields_value d-none">
                        <div class="mb-3">
                            <label class="form-label">State</label>
                            <input type="text" class="form-control" name="state">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Street</label>
                            <input type="text" class="form-control" name="street">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Zip Code</label>
                            <input type="text" class="form-control" name="post_code">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label><br>
                            <input type="tel" id="phone" class="form-control" name="phone_number">
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Head Office</label>
                        <input type="checkbox" name="head_office" value="1">
                    </div>

                    <div class="mb-2 more_fields">
                        <a href="javascript:void(0)" class="text-primary moreFields">More Fields</a>
                    </div>
                    <div class="mb-2 less_fields d-none">
                        <a href="javascript:void(0)" class="text-primary lessFields">Less Fields</a>
                    </div>

                </div>
                <div class="modal-footer">
                    <div class="mb-3">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="saveBranch" class="btn btn-primary">Save</button>
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
            <form id="updateBranchForm">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Update new branch</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body updateBranchContent">

                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection

@section('script')
<!-- Datatables init -->
<script src="//unpkg.com/bootstrap-select-country@4.0.0/dist/js/bootstrap-select-country.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.18/js/intlTelInput.min.js"></script>

<script type="text/javascript">

    $(document).ready(function(){
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
        $('#addbranch').modal("show");
    });
   
    $('#saveBranch').click(function(e) {
        e.preventDefault();

        var serialize = $('#branchForm').serialize();
        // console.log(serialize);

        $.ajax({
            url: "{{ route('backend.addpartner-branch') }}",
            type: "POST",
            data: serialize,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function(response) {
                // console.log(response);
                $('#addbranch').modal("hide");
                window.location.reload();
            },
            error: function (response) {
                // console.log(response);
                $('#nameError').text(response.responseJSON.errors.name);
                $('#emailError').text(response.responseJSON.errors.email);
            }
        });

    });

    $('.editBranchModel').on("click", function() {
        

        $('#updateBranch').modal("show");
        var branchId = $(this).data('id');

        $.ajax({
            url: "{{ route('backend.editpartner-branch') }}",
            type: "POST",
            data: {
                branch_id : branchId
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function(response) {

                var head_office = response.branch.head_office != 1 ? '<div class="mb-3"><label class="form-label">Head Office</label> <input type="checkbox" name="head_office" value="1"></div>' : '';
                
                var country = '';
                for(var i = 0; i < response.countries.length; i++){
                    var selected = response.branch.country == response.countries[i].id ? 'selected' : '';
                    country += '<option value="'+response.countries[i].id+'" '+selected+'>'+response.countries[i].countryname+'</option>';
                }

                var city = response.branch.city == null ? '' : response.branch.city;
                var state = response.branch.state == null ? '' : response.branch.state;
                var street = response.branch.street == null ? '' : response.branch.street;
                var post_code = response.branch.post_code == null ? '' : response.branch.post_code;
                var phone_number = response.branch.phone_number == null ? '' : response.branch.phone_number;
                
                
                var html = '';
                html += '<input type="hidden" name="branch_id" value="'+response.branch.id+'"><input type="hidden" name="partner_id" value="'+response.branch.partner_id+'"><div class="mb-3"><label class="form-label">Name <span class="text-danger">*</span></label><input type="text" class="form-control" id="name" name="name" value="' + response.branch.name + '"><span class="text-danger nameError"></span></div><div class="mb-3"><label class="form-label">Email <span class="text-danger">*</span></label><input type="text" class="form-control" id="email" name="email" value="' + response.branch.email + '"><span class="text-danger emailError"></span></div><div class="mb-3"><label class="form-label">Country</label><select name="country_id" class="form-control" id="country">'+country+'</select></div><div class="mb-3"><label class="form-label">City</label><input type="text" class="form-control" id="city" name="city" value="' + city + '"></div><div class="more_fields_value d-none"><div class="mb-3"><label class="form-label">State</label><input type="text" class="form-control" id="state" name="state" value="' + state + '"></div><div class="mb-3"><label class="form-label">Street</label><input type="text" class="form-control" id="street" name="street" value="' + street + '"></div><div class="mb-3"><label class="form-label">Zip Code</label><input type="text" class="form-control" id="postCode" name="post_code" value="' + post_code + '"></div><div class="mb-3"><label class="form-label">Phone Number</label><input type="tel" id="phone" class="form-control phone_number" name="phone_number" value="' + phone_number + '"></div></div>'+ head_office +'<div class="mb-2 more_fields"><a href="javascript:void(0)" class="text-primary moreFields">More Fields</a></div><div class="mb-2 less_fields d-none"><a href="javascript:void(0)" class="text-primary lessFields">Less Fields</a></div><button type="button" class="btn btn-primary px-5 w-100" id="update"> Update </button></div></div>';


                $('.updateBranchContent').html(html);

                $('#country').select2({
                    dropdownParent: $('#updateBranch'),
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

            }
        });


    });

    $(document).delegate('#update','click', function(e) {
        e.preventDefault();
        // alert('hello');

        var serialize = $('#updateBranchForm').serialize();
        // console.log(serialize);

        $.ajax({
            url: "{{ route('backend.updatepartner-branch') }}",
            type: "POST",
            data: serialize,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function(response) {
                // console.log(response);
                $('#updateBranch').modal("hide");
                window.location.reload();
            },
            error: function (response) {
                // console.log(response);
                $('.nameError').text(response.responseJSON.errors.name);
                $('.emailError').text(response.responseJSON.errors.email);
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

    $(document).ready(function() {
        $('[data-toggle="select2"]').select2();
        $('.countrypicker').countrypicker();
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