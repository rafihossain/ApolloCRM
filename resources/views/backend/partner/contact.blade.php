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

        <div class="row">

            @if(Session::has('success'))
                <div class="alert alert-success" style="text-align: center;">
                    {{ Session::get('success') }}
                </div>
            @endif

            <div class="text-end mb-3">
                <button type="button" class="btn btn-primary" id="addcontact">+ Add</button>
            </div>

            @foreach($contacts as $contact)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body p-2">
                        <div class="dropdown float-end">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="javascript:void(0);" data-id="{{ $contact->id }}" data-partner="{{ $contact->partner_id }}" class="dropdown-item editContactModel">Edit</a>
                                <a href="{{ route('backend.deletepartner-contact', ['id' => $contact->id, 'partner_id'=> $contact->partner_id ] ) }}" id="delete" class="dropdown-item">Delete</a>
                            </div>
                        </div>
                        <div class="d-flex mb-3 align-items-center">
                            <img class="flex-shrink-0 me-1 rounded-circle avatar-md" alt="64x64" src="{{ asset('assets/images/users/user-4.jpg') }}">
                            <div class="flex-grow-1">
                                <h5 class="media-heading mt-0 mb-0">{{ $contact->name }}</h5>
                                <p class="mb-0"><small>{{ $contact->position }}</small></p>
                            </div>
                        </div>
                        <p class="d-flex mb-0 align-items-center"> <i class="mdi mdi-phone-outline me-1 mdi-18px text-primary"></i> <small> {{ $contact->phone_number }} </small></p>
                        <p class="d-flex mb-0 align-items-center"> <i class="mdi mdi-fax me-1 mdi-18px text-primary"></i> <small>{{ $contact->fax }}</small></p>
                        <p class="d-flex mb-0 align-items-center"> <i class="mdi mdi-email-outline me-1 mdi-18px text-primary"></i> <small> {{ $contact->email }}</small></p>
                        <p class="d-flex "> <i class="mdi mdi-map-marker-outline me-1 mdi-18px text-primary"></i> <small>{{ $contact->branch->street }}</small></p>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>

<!-- Standard modal content -->
<div id="addcontactModel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addcontact-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="contactForm">
                <div class="modal-header">
                    <h4 class="modal-title" id="addcontact-modalLabel">Add new Contact</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="partner_id" value="{{ $partner->id }}">
                    <div class="mb-2">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name">
                        <span class="text-danger" id="contact-nameError"></span>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email">
                        <span class="text-danger" id="contact-emailError"></span>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Branch <span class="text-danger">*</span></label>
                        <select class="form-control" name="branch_id">
                            <option value="">Select Branch</option>
                            @foreach($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger" id="contact-branchError"></span>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Phone Number</label>
                        <input type="text" id="phone" class="form-control w-100" name="phone_number">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Fax</label>
                        <input type="text" class="form-control w-100" name="fax">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Department</label>
                        <input type="text" class="form-control w-100" name="department">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Position</label>
                        <input type="text" class="form-control w-100" name="position">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Primary Contact</label>
                        <input type="checkbox" name="primary_contact" value="1">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveContact">Save changes</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Standard modal content -->
<div id="updateContact" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="updateContactForm">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Update Contact</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body updateContactContent">

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
    $('#addcontact').on("click", function() {
        $('#addcontactModel').modal("show");
    });

    $('#saveContact').click(function(e) {
        e.preventDefault();

        var serialize = $('#contactForm').serialize();
        // console.log(serialize);

        $.ajax({
            url: "{{ route('backend.addpartner-contact') }}",
            type: "POST",
            data: serialize,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function(response) {
                // console.log(response);
                $('#addcontactModel').modal("hide");
                window.location.reload();
            },
            error: function(response) {
                // console.log(response);
                $('#contact-nameError').text(response.responseJSON.errors.name);
                $('#contact-emailError').text(response.responseJSON.errors.email);
                $('#contact-branchError').text(response.responseJSON.errors.branch_id);
            }
        });

    });

    $('.editContactModel').on("click", function() {
        
        $('#updateContact').modal("show");
        var contactId = $(this).data('id');
        var partnerId = $(this).data('partner');
        // console.log(contactId);

        $.ajax({
            url: "{{ route('backend.editpartner-contact') }}",
            type: "POST",
            data: {
                contact_id : contactId,
                partner_id : partnerId,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function(response) {

                // console.log(response);

                var primary_contact = '';
                if(response.contact.primary_contact != 1){
                    primary_contact = '<div class="mb-3"><label class="form-label">Primary Contact</label> <input type="checkbox" name="primary_contact" value="1"></div>';
                }

                var branch = '';
                for(var i=0; i<response.branches.length; i++){
                    if(response.contact.branch_id == response.branches[i].id){
                        branch += '<option value="'+response.branches[i].id+'" selected >'+response.branches[i].name+'</option>';
                    }else{
                        branch += '<option value="'+response.branches[i].id+'">'+response.branches[i].name+'</option>';
                    }
                }
            
                if(response.contact != undefined && response.contact != null){
                    var html = '';
                    html += '<input type="hidden" name="contact_id" value="'+response.contact.id+'"><input type="hidden" name="partner_id" value="'+response.contact.partner_id+'"><div class="mb-2"><label class="form-label">Name <span class="text-danger">*</span></label><input type="text" class="form-control" name="name" value="'+response.contact.name+'"><span class="text-danger nameError"></span></div><div class="mb-2"><label class="form-label">Email <span class="text-danger">*</span></label><input type="email" class="form-control" name="email" value="'+response.contact.email+'"><span class="text-danger emailError"></span></div><div class="mb-2"><label class="form-label">Branch <span class="text-danger">*</span></label><select class="form-control" name="branch_id"><option value="">Select Branch</option>'+branch+'</select><span class="text-danger branchError"></span></div><div class="mb-2"><label class="form-label">Phone Number</label><input type="text" id="phone" class="form-control w-100" name="phone_number" value="'+response.contact.phone_number+'"></div><div class="mb-2"><label class="form-label">Fax</label><input type="text" class="form-control w-100" name="fax" value="'+response.id+'"></div><div class="mb-2"><label class="form-label">Department</label><input type="text" class="form-control w-100" name="department" value="'+response.contact.department+'"></div><div class="mb-2"><label class="form-label">Position</label><input type="text" class="form-control w-100" name="position" value="'+response.contact.position+'"></div>'+primary_contact+'<button type="button" class="btn btn-primary px-5 w-100" id="update"> Update </button>';
                    $('.updateContactContent').html(html);
                }

            }
        });


    });

    $(document).delegate('#update','click', function(e) {
        e.preventDefault();
        // alert('hello');

        var serialize = $('#updateContactForm').serialize();
        // console.log(serialize);

        $.ajax({
            url: "{{ route('backend.updatepartner-contact') }}",
            type: "POST",
            data: serialize,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function(response) {
                // console.log(response);
                $('#updateContact').modal("hide");
                window.location.reload();
            },
            error: function (response) {
                // console.log(response);
                $('.nameError').text(response.responseJSON.errors.name);
                $('.emailError').text(response.responseJSON.errors.email);
                $('.branchError').text(response.responseJSON.errors.branch_id);
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