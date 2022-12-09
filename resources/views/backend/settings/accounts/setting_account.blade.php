@extends('backend.layouts.app')
@section('css')
<link rel="stylesheet" href="//unpkg.com/bootstrap-select-country@4.0.0/dist/css/bootstrap-select-country.min.css" type="text/css" />
@endsection
@section('content')
<div class="card">
	<div class="card-body">
		<div class="row justify-content-end">
			<div class="col-md-4">
				<select class="form-control">
					<option value="1">Head Office</option>
				</select>
			</div>
		</div>
	</div>
</div>
@if(Session::has('success'))
<div class="alert alert-success">
	{{ Session::get('success') }}
</div>
@endif
<div class="card">
	<div class="card-body">
		<h4>Business Registration Number</h4>
		<form method="POST" action="{{ route('backend.update-registration-number') }}">
			@csrf
			<div>
				<input type="hidden" name="id" value="{{ $businessregno->id }}">

				<label class="form-label">Enter your business registration number</label>
				<div class="d-flex">
					<input type="text" class="form-control" name="registration_number" value="{{ $businessregno->registration_number }}">
					<button type="submit" class="btn btn-primary ms-2">Save</button>
				</div>
			</div>
		</form>

		<form class="mt-4" method="POST" action="{{ route('backend.update-invoice-address') }}">
			@csrf
			<h4>Business Invoice Address</h4>
			<input type="hidden" name="id" value="{{ $businessinvoice->id }}">
			<div class="row">
				<div class="col-md-4">
					<div class="mb-3">
						<label class="form-label">Street</label>
						<input type="text" class="form-control" name="street" value="{{ $businessinvoice->street }}">
					</div>
				</div>
				<div class="col-md-4">
					<div class="mb-3">
						<label class="form-label">City</label>
						<input type="text" class="form-control" name="city" value="{{ $businessinvoice->city }}">
					</div>
				</div>
				<div class="col-md-4">
					<div class="mb-3">
						<label class="form-label">State</label>
						<input type="text" class="form-control" name="state" value="{{ $businessinvoice->state }}">
					</div>
				</div>
				<div class="col-md-4">
					<div class="mb-3">
						<label class="form-label">Zip/Post Code</label>
						<input type="text" class="form-control" name="post_code" value="{{ $businessinvoice->post_code }}">
					</div>
				</div>
				<div class="col-md-4">
					<div class="mb-3">
						<label class="form-label">Country</label>
						<select class="form-control" data-toggle="select2" data-width="100%" name="country_id">
							<option value="">Select Country</option>
							@foreach($countries as $country)
							<option value="{{ $country->id }}" {{ $businessinvoice->country_id == $country->id ? 'selected' : '' }}>{{ $country->countryname }}</option>
							@endforeach
						</select>
						@error('country_id')
						<strong class="text-danger">{{ $message }}</strong>
						@enderror
					</div>
				</div>
			</div>
			<button type="submit" class="btn btn-primary">Save</button>
		</form>

	</div>
</div>
<div class="card">
	<div class="card-body">
		<h4 class="mb-4 overflowhidden">
			Manual Payment Details
			<button class="btn btn-primary float-end" id="addPayment">Add New</button>
		</h4>
		<p><small>Looks like there are no Manual Payment Options. Click on "Add New" button to create your first Payment Option.</small></p>

		<table class="table">
			<thead>
				<tr>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach($paymentdetails as $payment)
				<tr>
					<td>{{ $payment->option_name }}</td>
					<td>{!! $payment->details_content !!}</td>
					<td>
						<a href="javascript:void(0);" data-id="{{ $payment->id }}" class="btn btn-sm btn-primary waves-effect waves-light editPaymentModel">
							<i class="mdi mdi-square-edit-outline"></i>
						</a>
						<a href="{{ route('backend.manual-payment-delete', ['id' => $payment->id ]) }}" id="delete" class="btn btn-danger btn-sm">
							<i class="mdi mdi-delete-outline"></i>
						</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

<div class="card">
	<div class="card-body">
		<form method="POST" action="{{ route('backend.tax-setting-update') }}">
			@csrf
			<h4>Tax Settings</h4>
			<p><small><i class="mdi mdi-information-outline"></i><em>This will be displayed while creating the invoice and amount will be calculated accordingly.</em></small></p>
			<div class="table-responsive mb-3">
				<table class="table align-baseline">
					<thead>
						<tr>
							<th>Tax Code</th>
							<th>Tax Rate (%)</th>
							<th>Set as default</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody id="taxlist">

						@if($taxsettings)
							@foreach($taxsettings as $taxsetting)
								<tr>
									<td>
										<!-- <input type="text" name="id[]" value="{{ $taxsetting->id }}"> -->
										<input type="text" class="form-control" name="tax_code[]" value="{{ $taxsetting->tax_code }}">
									</td>
									<td>
										<input type="number" class="form-control" name="tax_rate[]" value="{{ $taxsetting->tax_rate }}">
									</td>
									<td>
										<button type="button" class="btn btn-outline-primary">Set as Default</button>
									</td>
									<td>
										<a href="{{ route('backend.tax-setting-delete', ['id' => $taxsetting->id ]) }}" class="btn btn-danger" id="delete">
											<i class="mdi mdi-delete-outline mdi-10px"></i>
										</a>
									</td>
								</tr>
							@endforeach
						@endif


					</tbody>
				</table>
				<button type="button" class="btn btn-sm btn-outline-primary" id="addnewtax"> + Add New Tax</button>
			</div>
			<button type="submit" class="btn btn-primary">Save</button>
		</form>
	</div>
</div>

<!-- Standard modal content -->
<div id="addPaymentModel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="paymentFrom">
				<div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Add Payment Details</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
				<div class="modal-body">
					<div class="mb-3">
						<label class="form-label">Payment Option Name <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="option_name">
						<span class="text-danger" id="optionnameError"></span>
					</div>
					<div class="mb-3">
						<label class="form-label">Payment Details Content <span class="text-danger">*</span></label>
						<p><small><i class="mdi mdi-information-outline"></i><em>This will be displayed while creating the invoice and amount will be calculated accordingly.</em></small></p>
						<textarea id="summereditor" name="details_content"></textarea>
						<span class="text-danger" id="detailscontentError"></span>
					</div>
					<div class="mb-3">
						<label class="form-label">Default for Invoice Type</label>
						<p><small><i class="mdi mdi-information-outline"></i><em>Choose invoice types where you want to use this payment detail by default. You can choose different in the invoice as well.</em></small></p>
						<select class="form-control" data-width="100%" name="invoice_type">
							<option value="">Choose Invoice Type</option>
							<option value="1">Net Commission Invoice</option>
							<option value="2"> Gross Commission Invoice</option>
							<option value="3">Client General Invoice</option>
							<option value="4"> Partner General Invoice</option>
							<option value="5">Group Invoice</option>
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" id="savePayment">Add</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Standard modal content -->
<div id="updatePayment" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="updatePaymentForm" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Edit Payment Details</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body updatePaymentContent">

                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection

@section('script')
<script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
<script src="//unpkg.com/bootstrap-select-country@4.0.0/dist/js/bootstrap-select-country.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

<script type="text/javascript">
	$(document).ready(function() {

		$('#addPayment').on("click", function() {
            $('#addPaymentModel').modal("show");
        });

        $("#savePayment").click(function(e) {
            e.preventDefault();
            var serialize = $("#paymentFrom").serialize();
            $.ajax({
                url: "{{ route('backend.manual-payment-create') }}",
                type: "POST",
                data: serialize,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    $('#addPaymentModel').modal("hide");
                    window.location.reload();
                },
                error: function(response) {
                    $('#optionnameError').text(response.responseJSON.errors.option_name);
                    $('#detailscontentError').text(response.responseJSON.errors.details_content);
                }
            });

        });

        $('.editPaymentModel').on("click", function() {

            $('#updatePayment').modal("show");
            var paymentId = $(this).data('id');

            $.ajax({
                url: "{{ route('backend.manual-payment-edit') }}",
                data: {
                    payment_id: paymentId,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    
                    var invoice_type = '';
                    if(response.invoice_type == 1){
                        invoice_type = '<option value="">Choose Invoice Type</option><option value="1" selected>Net Commission Invoice</option><option value="2"> Gross Commission Invoice</option><option value="3">Client General Invoice</option><option value="4"> Partner General Invoice</option><option value="5">Group Invoice</option>';
                    }else if(response.invoice_type == 2){
                        invoice_type = '<option value="">Choose Invoice Type</option><option value="1">Net Commission Invoice</option><option value="2" selected> Gross Commission Invoice</option><option value="3">Client General Invoice</option><option value="4"> Partner General Invoice</option><option value="5">Group Invoice</option>';
                    }else if(response.invoice_type == 3){
                        invoice_type = '<option value="">Choose Invoice Type</option><option value="1">Net Commission Invoice</option><option value="2"> Gross Commission Invoice</option><option value="3" selected>Client General Invoice</option><option value="4"> Partner General Invoice</option><option value="5">Group Invoice</option>';
                    }else if(response.invoice_type == 4){
                        invoice_type = '<option value="">Choose Invoice Type</option><option value="1">Net Commission Invoice</option><option value="2"> Gross Commission Invoice</option><option value="3">Client General Invoice</option><option value="4" selected> Partner General Invoice</option><option value="5">Group Invoice</option>';
                    }else{
                        invoice_type = '<option value="">Choose Invoice Type</option><option value="1">Net Commission Invoice</option><option value="2"> Gross Commission Invoice</option><option value="3">Client General Invoice</option><option value="4"> Partner General Invoice</option><option value="5" selected>Group Invoice</option>';
                    }

                    var html = '';

                    html += '<input type="hidden" name="payment_id" value="'+response.id+'"><div class="mb-3"><label class="form-label">Payment Option Name <span class="text-danger">*</span></label><input type="text" class="form-control" name="option_name" value="'+response.option_name+'"><span class="text-danger optionnameError"></span></div><div class="mb-3"><label class="form-label">Payment Details Content <span class="text-danger">*</span></label><p><small><i class="mdi mdi-information-outline"></i><em>This will be displayed while creating the invoice and amount will be calculated accordingly.</em></small></p><textarea class="summereditor" name="details_content">'+response.details_content+'</textarea><span class="text-danger detailscontentError"></span></div><div class="mb-3"><label class="form-label">Default for Invoice Type</label><p><small><i class="mdi mdi-information-outline"></i><em>Choose invoice types where you want to use this payment detail by default. You can choose different in the invoice as well.</em></small></p><select class="form-control" data-width="100%" name="invoice_type">'+invoice_type+'</select></div><button type="button" class="btn btn-primary px-5 w-100" id="update"> Update </button>';

                    $('.updatePaymentContent').html(html);

					$('.summereditor').summernote();

                }
            });

        });

        $(document).delegate('#update', 'click', function(e) {
            e.preventDefault();
            var serialize = $("#updatePaymentForm").serialize();
            $.ajax({
                url: "{{ route('backend.manual-payment-update') }}",
                type: "POST",
                data: serialize,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    // alert(response);
                    $('#updatePayment').modal("hide");
                    window.location.reload();
                },
                error: function(response) {
                    $('.optionnameError').text(response.responseJSON.errors.option_name);
                    $('.detailscontentError').text(response.responseJSON.errors.details_content);
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


		$("#addnewtax").click(function() {
			$("#taxlist").append('<tr> <td><input type="text" class="form-control" name="tax_code[]" placeholder="Enter Tax Code"></td> <td><input type="number" class="form-control" name="tax_rate[]" value="0"></td> <td><button type="button" class="btn btn-outline-primary">Set as Default</button></td><td> <a href="javascript:void(0)" class="btn btn-danger removetr"><i class="mdi mdi-delete-outline mdi-10px"></i></a></td></tr>');
		});
		$('body').delegate('.removetr', 'click', function() {
			$(this).parent().parent('tr').remove();
		});


		$('[data-toggle="select2"]').select2();
		$('#summereditor').summernote();
	});
</script>
@endsection