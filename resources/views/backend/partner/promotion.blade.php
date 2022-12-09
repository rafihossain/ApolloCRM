@extends('backend.layouts.app')
@section('css')
<link href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/libs/clockpicker/bootstrap-clockpicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
<style type="text/css">
    .singleproduct {
        display: none;
    }
</style>
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
            <button type="button" class="btn btn-primary" id="addpromotion">+ Add</button>
        </div>

        @if(Session::has('success'))
            <div class="alert alert-success" style="text-align: center;">
                {{ Session::get('success') }}
            </div>
        @endif

        <div class="row">
            
            @foreach($promotions as $promotion)
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body p-2">
                        <div class="dropdown float-end">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="javascript:void(0);" data-id="{{ $promotion->id }}" data-partner="{{ $promotion->partner_id }}" class="dropdown-item editPromotionModel">Edit</a>
                                <a href="{{ route('backend.deletepartner-promotion', ['id' => $promotion->id, 'partner_id'=> $promotion->partner_id ]) }}" id="delete" class="dropdown-item">Delete</a>
                            </div>
                        </div>
                        <div class=" mb-3 ">
                            <h5 class="media-heading mt-0 mb-0">{{ $promotion->title }} <span class="badge bg-success rounded-pill">Active</span></h5>
                        </div>
                        <p>{{ $promotion->description }}</p>
                        <p> <span class="text-decoration-underline">For Branches</span> <span class="badge bg-primary rounded-pill">{{ count($branches) }}</span> </p>
                        <div class="branch-overlay ms-4">
                            @foreach($branches as $branch)
                                <li>{{ $branch->name }}</li>
                            @endforeach
                        </div>
                        
                        <p><span class="text-decoration-underline">For Products</span> <span class="badge bg-primary rounded-pill">{{ count($promotion->products) }}</span> </p>
                        <div class="product-overlay ms-4 mb-2">
                            @foreach($promotion->products as $product)
                                <li>{{ $product->name }}</li>
                            @endforeach
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <p class="mb-0"><strong>Date Start And End</strong></p>
                                <p class="mb-0"><small>{{ $promotion->date_start_end }}</small></p>
                            </div>
                            <!-- <div class="col-6 text-end">
                                <p class="mb-0"><strong>End Date</strong></p>
                                <p class="mb-0"><small>2022-09-16</small></p>
                            </div> -->
                        </div>

                    </div>
                    <div class="card-footer p-2">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" id="customSwitch1" checked="">
                                    <label class="form-check-label" for="customSwitch1">Active</label>
                                </div>
                            </div>
                            <div class="col-6 text-end">
                                <a href="javascript:void(0);" data-id="{{ $promotion->id }}" data-partner="{{ $promotion->partner_id }}" class="btn badge rounded-pill bg-primary viewPromotionModel">View</a>
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
<div id="addPromotionModel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addcontact-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="promotionFrom" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title" id="addcontact-modalLabel">Add New Promotion</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="partner_id" value="{{ $partner->id }}">
                    <div class="mb-2">
                        <label class="form-label">Promotion Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="title">
                        <span class="text-danger" id="titleError"></span>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="description"></textarea>
                        <span class="text-danger" id="descriptionError"></span>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Attachments</label>
                        <input type="file" class="dropify" name="attachment">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Date Start and End <span class="text-danger">*</span></label>
                        <input type="text" id="range-datepicker" class="form-control" placeholder="Select Date" name="date_start_end">
                        <p><small>Date must be in YYYY-MM-DD (2022-12-22) format.</small></p>
                        <span class="text-danger" id="dateError"></span>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Apply To: </label>
                        <div class="selectproduct">
                            <div class="form-check">
                                <input type="radio" id="customRadio1" name="apply_status" class="form-check-input" value="1" checked>
                                <label class="form-check-label" for="customRadio1">All Products</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" id="customRadio2" name="apply_status" class="form-check-input" value="2">
                                <label class="form-check-label" for="customRadio2">Select Products</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-2 singleproduct">
                        <select class="form-control" name="product_id">
                            <option value="">Select Product</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="savePromotion">Submit</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Standard modal content -->
<div id="updatePromotion" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="updatePromotionForm" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Edit Promotion</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body updatePromotionContent">

                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Standard modal content -->
<div id="viewPromotion" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">View Promotion</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body viewPromotionContent">

            </div>
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

        $('#addpromotion').on("click", function() {
            $('#addPromotionModel').modal("show");
        });

        $("#savePromotion").click(function(e) {
            e.preventDefault();
            var fromData = new FormData(document.getElementById("promotionFrom"));
            $.ajax({
                url: "{{ route('backend.addpartner-promotion') }}",
                type: "POST",
                data: fromData,
                cache:false,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    // console.log(response);
                    $('#addPromotionModal').modal("hide");
                    window.location.reload();
                },
                error: function(response) {
                    // console.log(response);
                    $('#titleError').text(response.responseJSON.errors.title);
                    $('#descriptionError').text(response.responseJSON.errors.description);
                    $('#dateError').text(response.responseJSON.errors.date_start_end);
                }
            });

        });

        $('.editPromotionModel').on("click", function() {

            $('#updatePromotion').modal("show");
            var promotionId = $(this).data('id');
            var partnerId = $(this).data('partner');
            // console.log(contactId);

            $.ajax({
                url: "{{ route('backend.editpartner-promotion') }}",
                type: "POST",
                data: {
                    promotion_id: promotionId,
                    partner_id: partnerId,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {

                    var product = '';
                    for(var i = 0; i < response.products.length; i++){
                        product += '<option value="'+response.products[i].id+'">'+response.products[i].name+'</option>';
                    }

                    var imagePath = '';
                    if(response.promotion.attachment){
                        url = $('meta[name="base_url"]').attr('content');
                        imagePath = url+'/'+response.promotion.attachment;
                    }
                    
                    var html = '';

                    html += '<input type="hidden" name="promotion_id" value="'+response.promotion.id+'"><input type="hidden" name="partner_id" value="'+ response.promotion.partner_id+'"><div class="mb-2"><label class="form-label">Promotion Title <span class="text-danger">*</span></label><input type="text" class="form-control" name="title" value="'+response.promotion.title+'"><span class="text-danger titleError"></span></div><div class="mb-2"><label class="form-label">Description <span class="text-danger">*</span></label><textarea class="form-control" name="description">'+response.promotion.description+'</textarea><span class="text-danger descriptionError"></span></div><div class="mb-2"><label class="form-label">Attachments</label><input type="file" class="dropify" name="attachment" data-default-file="'+imagePath+'"></div><div class="mb-2"><label class="form-label">Date Start and End <span class="text-danger">*</span></label><input type="text" class="form-control range-datepicker" placeholder="Select Date" name="date_start_end" value="'+response.promotion.date_start_end+'"><p><small>Date must be in YYYY-MM-DD (2022-12-22) format.</small></p><span class="text-danger dateError"></span></div><div class="mb-2"><label class="form-label">Apply To: </label><div class="selectproduct"><div class="form-check"><input type="radio" id="customRadio1" name="apply" class="form-check-input" value="1" checked><label class="form-check-label" for="customRadio1">All Products</label></div><div class="form-check"><input type="radio" id="customRadio2" name="apply" class="form-check-input" value="2"><label class="form-check-label" for="customRadio2">Select Products</label></div></div></div><div class="mb-2 singleproduct"><select class="form-control" name="product_id"><option value="">Select Product</option>'+product+'</select></div><button type="button" class="btn btn-primary px-5 w-100" id="update"> Update </button>';

                    $('.updatePromotionContent').html(html);

                    $('.dropify').dropify();
                    $(".range-datepicker").flatpickr({
                        mode: "range"
                    });
                    $("body").delegate('.selectproduct','change',function() {
                        // alert('test');
                        selected_value = $("input[name='apply']:checked").val();
                        if (selected_value == '2') {
                            $('.singleproduct').show();
                        } else {
                            $('.singleproduct').hide();
                        }
                    });

                }
            });

        });

        $(document).delegate('#update', 'click', function(e) {
            e.preventDefault();
            var fromData = new FormData(document.getElementById("updatePromotionForm"));
            $.ajax({
                url: "{{ route('backend.updatepartner-promotion') }}",
                type: "POST",
                data: fromData,
                cache:false,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    // alert(response);
                    $('#updateTask').modal("hide");
                    window.location.reload();
                },
                error: function(response) {
                    $('.titleError').text(response.responseJSON.errors.title);
                    $('.descriptionError').text(response.responseJSON.errors.description);
                    $('.dateError').text(response.responseJSON.errors.date_start_end);
                }
            });

        });
        
        $('.viewPromotionModel').on("click", function(e) {
            e.preventDefault();

            $('#viewPromotion').modal("show");
            var promotionId = $(this).data('id');
            var partnerId = $(this).data('partner');
            // console.log(contactId);

            $.ajax({
                url: "{{ route('backend.viewpartner-promotion') }}",
                type: "POST",
                data: {
                    promotion_id: promotionId,
                    partner_id: partnerId,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {

                    var product = '';
                    for(var i = 0; i < response.products.length; i++){
                        product += '<option value="'+response.products[i].id+'">'+response.products[i].name+'</option>';
                    }

                    var imagePath = '';
                    if(response.promotion.attachment){
                        url = $('meta[name="base_url"]').attr('content');
                        imagePath = url+'/'+response.promotion.attachment;
                    }
                    
                    var html = '';

                    html += '<div class="mb-2"><label class="form-label">Promotion Title</label><br><h4>'+response.promotion.title+'</h4></div><div class="mb-2"><label class="form-label">Description</label><br>'+response.promotion.description+'</div><div class="mb-2"><label class="form-label">Attachments</label><img src="'+imagePath+'" class="img-fluid"></div><div class="mb-2"><label class="form-label">Date Start and End</label><br>'+response.promotion.date_start_end+'</div>';

                    $('.viewPromotionContent').html(html);
                    $('.dropify').dropify();

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

        $('.dropify').dropify();
        $("#range-datepicker").flatpickr({
            mode: "range"
        });

        $('.selectproduct').change(function() {
            selected_value = $("input[name='apply_status']:checked").val();
            if (selected_value == '2') {
                $('.singleproduct').show();
            } else {
                $('.singleproduct').hide();
            }

        });

    });
</script>
@endsection