@extends('backend.layouts.app')
@section('css')
<style type="text/css">
	.pricebox {
		border: 1px solid #eaeef1;
		padding: 10px;
		border-radius: 10px;
		cursor: pointer;
		position: relative;
	}

	.pricebox:hover,
	.pricebox.active {
		border: 1px solid #71b6f9;
	}

	.pricebox.active::before {
		content: "\f05e0";
		font: normal normal normal 24px/1 "Material Design Icons";
		position: absolute;
		right: 10px;
		color: #71b6f9;
	}

	.pricebox input[type='radio'] {
		position: absolute;
		left: 0;
		right: 0;
		top: 0;
		bottom: 0;
		opacity: 0;
	}

	#billyearly {
		display: none;
	}
</style>
@endsection
@section('content')
<a href="{{ route('backend.setting-subscription') }}" class="btn btn-primary"> <i class=" fas fa-caret-left"></i> Back to subscription</a>

<form id="billingFrom">
	<div class="row justify-content-center">

		<div class="col-md-8">
			<div class="card">
				<div class="card-body">
					<h4>Choose Plan</h4>
					<div class="d-flex mt-3 mb-3">
						<div class="form-check me-2">
							<input type="radio" id="bill1" name="choose_plan" class="form-check-input" value="1" checked="">
							<label class="form-check-label" for="bill1">Bill Monthly</label>
						</div>
						<div class="form-check">
							<input type="radio" id="bill2" name="choose_plan" class="form-check-input" value="2">
							<label class="form-check-label" for="bill2">Bill Annually</label>
						</div>
					</div>
					<div class="row" id="billmonthly">
						<div class="col-md-6 mb-3">
							<div class="pricebox active">
								<input type="radio" value="1" name="monthy_priceplan" checked="">
								<p class="m-0">BASIC</p>
								<div class="d-flex align-items-center">
									<h4>USD </h4>
									<h1>7 </h1>
								</div>
								<p class="m-0"><small>Per User Per Month</small></p>
							</div>
						</div>
						<div class="col-md-6 mb-3">
							<div class="pricebox">
								<input type="radio" value="2" name="monthy_priceplan">
								<p class="m-0">PROFESSIONAL</p>
								<div class="d-flex align-items-center">
									<h4>USD </h4>
									<h1>10 </h1>
								</div>
								<p class="m-0"><small>Per User Per Month</small></p>
							</div>
						</div>
						<div class="col-md-6 mb-3">
							<div class="pricebox">
								<input type="radio" value="3" name="monthy_priceplan">
								<p class="m-0">STANDARD</p>
								<div class="d-flex align-items-center">
									<h4>USD </h4>
									<h1>14 </h1>
								</div>
								<p class="m-0"><small>Per User Per Month</small></p>
							</div>
						</div>
						<div class="col-md-6 mb-3">
							<div class="pricebox">
								<input type="radio" value="4" name="monthy_priceplan">
								<p class="m-0">PREMIUM</p>
								<div class="d-flex align-items-center">
									<h4>USD </h4>
									<h1>21 </h1>
								</div>
								<p class="m-0"><small>Per User Per Month</small></p>
							</div>
						</div>

						<hr>

						<div class="card">
							<div class="card-body">
								<h4>Users & Addons</h4>
								<div class="row mb-2 align-items-center">
									<div class="col-8">
										<i class="mdi mdi-account-group mdi-18px text-primary"></i> No Of Users
									</div>
									<div class="col-4">
										<input type="number" class="form-control" value="1" name="basic_total_user">
									</div>
								</div>
								<div class="row mb-2 align-items-center">
									<div class="col-8"><i class="mdi mdi-database mdi-18px text-primary"></i> Storage Capacity</div>
									<div class="col-4">
										<select name="basic_storage_capacity" class="form-control">
											<option value="50"> 50 GB</option>
											<option value="100"> 100 GB</option>
											<option value="150"> 150 GB</option>
											<option value="200"> 200 GB</option>
											<option value="250"> 250 GB</option>
											<option value="500"> 500 GB</option>
											<option value="1000"> 1 TB</option>
											<option value="2000"> 2 TB</option>
											<option value="3000"> 3 TB</option>
											<option value="4000"> 4 TB</option>
											<option value="5000"> 5 TB</option>
										</select>
									</div>
								</div>
								<div class="row mb-2 align-items-center">
									<div class="col-8"><i class="mdi mdi-email-send-outline mdi-18px text-primary"></i> Monthly Inbox Email Capacity</div>
									<div class="col-4">
										<select name="monthly_inbox" class="form-control">
											<option value="2000"> 2000 Emails</option>
											<option value="3000"> 3000 Emails</option>
											<option value="4000"> 4000 Emails</option>
											<option value="5000"> 5000 Emails</option>
											<option value="10000"> 10000 Emails</option>
											<option value="20000"> 20000 Emails</option>
											<option value="40000"> 40000 Emails</option>
											<option value="80000"> 80000 Emails</option>
											<option value="160000"> 160000 Emails</option>
											<option value="320000"> 320000 Emails</option>
											<option value="640000"> 640000 Emails</option>
											<option value="1280000"> 1280000 Emails</option>
											<option value="2560000"> 2560000 Emails</option>
										</select>
									</div>
								</div>
								<div class="row mb-2 align-items-center">
									<div class="col-8"><i class="mdi mdi-email-receive-outline mdi-18px text-primary"></i> Monthly Outbox Capacity</div>
									<div class="col-4">
										<select name="monthly_outbox" class="form-control">
											<option value="2000"> 2000 Emails</option>
											<option value="3000"> 3000 Emails</option>
											<option value="4000"> 4000 Emails</option>
											<option value="5000"> 5000 Emails</option>
											<option value="10000"> 10000 Emails</option>
											<option value="20000"> 20000 Emails</option>
											<option value="40000"> 40000 Emails</option>
											<option value="80000"> 80000 Emails</option>
											<option value="160000"> 160000 Emails</option>
											<option value="320000"> 320000 Emails</option>
											<option value="640000"> 640000 Emails</option>
											<option value="1280000"> 1280000 Emails</option>
											<option value="2560000"> 2560000 Emails</option>
										</select>
									</div>
								</div>
								<button type="button" class="btn btn-primary reviewBilling">Review</button>
								<br>
								<br>
								<p>By clicking this button, I agree <a href="#"> Customer Terms</a> and <a href="#">Privacy Policy</a>.</p>
							</div>
						</div>

					</div>
					<div class="row" id="billyearly">

						<div class="col-md-6 mb-3">
							<div class="pricebox active">
								<input type="radio" value="1" name="yearly_priceplan" checked="">
								<p class="m-0">BASIC</p>
								<div class="d-flex align-items-center">
									<h4>USD </h4>
									<h1>5 </h1>
								</div>
								<p class="m-0"><small>Per User Per Month</small></p>
								<p class="m-0"> Billed <strong class="text-uppercase">usd 60 </strong> Per User Annually </p>
							</div>
						</div>
						<div class="col-md-6 mb-3">
							<div class="pricebox">
								<input type="radio" value="2" name="yearly_priceplan">
								<p class="m-0">PROFESSIONAL</p>
								<div class="d-flex align-items-center">
									<h4>USD </h4>
									<h1>7 </h1>
								</div>
								<p class="m-0"><small>Per User Per Month</small></p>
								<p class="m-0"> Billed <strong class="text-uppercase">usd 84 </strong> Per User Annually </p>
							</div>
						</div>
						<div class="col-md-6 mb-3">
							<div class="pricebox">
								<input type="radio" value="3" name="yearly_priceplan">
								<p class="m-0">STANDARD</p>
								<div class="d-flex align-items-center">
									<h4>USD </h4>
									<h1>10 </h1>
								</div>
								<p class="m-0"><small>Per User Per Month</small></p>
								<p class="m-0"> Billed <strong class="text-uppercase">usd 120 </strong> Per User Annually </p>
							</div>
						</div>
						<div class="col-md-6 mb-3">
							<div class="pricebox">
								<input type="radio" value="4" name="yearly_priceplan">
								<p class="m-0">PREMIUM</p>
								<div class="d-flex align-items-center">
									<h4>USD </h4>
									<h1>15 </h1>
								</div>
								<p class="m-0"><small>Per User Per Month</small></p>
								<p class="m-0"> Billed <strong class="text-uppercase">usd 180 </strong> Per User Annually </p>
							</div>
						</div>
						<hr>
						<div class="card">
							<div class="card-body">
								<h4>Users & Addons</h4>
								<div class="row mb-2 align-items-center">
									<div class="col-8">
										<i class="mdi mdi-account-group mdi-18px text-primary"></i> No Of Users
									</div>
									<div class="col-4">
										<input type="number" class="form-control" value="1" name="yearly_total_user">
									</div>
								</div>
								<div class="row mb-2 align-items-center">
									<div class="col-8"><i class="mdi mdi-database mdi-18px text-primary"></i> Storage Capacity</div>
									<div class="col-4">
										<select name="yearly_storage_capacity" class="form-control">
											<option value="50"> 50 GB</option>
											<option value="100"> 100 GB</option>
											<option value="150"> 150 GB</option>
											<option value="200"> 200 GB</option>
											<option value="250"> 250 GB</option>
											<option value="500"> 500 GB</option>
											<option value="1000"> 1 TB</option>
											<option value="2000"> 2 TB</option>
											<option value="3000"> 3 TB</option>
											<option value="4000"> 4 TB</option>
											<option value="5000"> 5 TB</option>
										</select>
									</div>
								</div>
								<div class="row mb-2 align-items-center">
									<div class="col-8"><i class="mdi mdi-email-send-outline mdi-18px text-primary"></i> Yearly Inbox Email Capacity</div>
									<div class="col-4">
										<select name="yearly_inbox" class="form-control">
											<option value="24000"> 24000 Emails</option>
											<option value="36000"> 36000 Emails</option>
											<option value="48000"> 48000 Emails</option>
											<option value="60000"> 60000 Emails</option>
											<option value="120000"> 120000 Emails</option>
											<option value="240000"> 240000 Emails</option>
											<option value="480000"> 480000 Emails</option>
											<option value="960000"> 960000 Emails</option>
											<option value="1920000"> 1920000 Emails</option>
											<option value="3840000"> 3840000 Emails</option>
											<option value="7680000"> 7680000 Emails</option>
											<option value="15360000"> 15360000 Emails</option>
											<option value="30720000"> 30720000 Emails</option>
										</select>
									</div>
								</div>
								<div class="row mb-2 align-items-center">
									<div class="col-8"><i class="mdi mdi-email-receive-outline mdi-18px text-primary"></i> Yearly Outbox Capacity</div>
									<div class="col-4">
										<select name="yearly_outbox" class="form-control">
											<option value="24000"> 24000 Emails</option>
											<option value="36000"> 36000 Emails</option>
											<option value="48000"> 48000 Emails</option>
											<option value="60000"> 60000 Emails</option>
											<option value="120000"> 120000 Emails</option>
											<option value="240000"> 240000 Emails</option>
											<option value="480000"> 480000 Emails</option>
											<option value="960000"> 960000 Emails</option>
											<option value="1920000"> 1920000 Emails</option>
											<option value="3840000"> 3840000 Emails</option>
											<option value="7680000"> 7680000 Emails</option>
											<option value="15360000"> 15360000 Emails</option>
											<option value="30720000"> 30720000 Emails</option>
										</select>
									</div>
								</div>
								<button type="button" class="btn btn-primary reviewBilling">Review</button>
								<br>
								<br>
								<p>By clicking this button, I agree <a href="#"> Customer Terms</a> and <a href="#">Privacy Policy</a>.</p>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</form>


<!-- Standard modal content -->
<div id="billingModel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="checkoutPaymentFrom">
				<div class="modal-header">
					<div class="row">
						<div class="col-md-12">
							<img class="img-fluid" src="{{ asset('assets/images/logo-dark.png') }}" alt="">
						</div>
						<div class="col-md-12">
							<p>Your Subscription Changes</p>
						</div>
					</div>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body append-billing-info">


				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary w-100" id="checkoutPayment">Proceed To Checkout </button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->




@endsection

@section('script')
<script type="text/javascript">
	$(document).ready(function() {

		// $('.saveBilling').on("click", function() {
		//     $('#billingModel').modal("show");
		// });


		$(".pricebox input[type='radio']").click(function() {
			console.log('hello');

			$('.pricebox').removeClass("active");
			if ($(".pricebox input[type='radio']").is(":checked")) {
				$(this).parent().addClass("active");
			}
		});
		$('input[type=radio][name=choose_plan]').change(function() {
			if (this.value == 1) {
				$('#billmonthly').show();
				$('#billyearly').hide();
			} else if (this.value == 2) {
				$('#billmonthly').hide();
				$('#billyearly').css("display", "flex");
			}
		});

		$(".reviewBilling").click(function(e) {
			e.preventDefault();

			$('.append-billing-info').html('');

			$('#billingModel').modal("show");
			var serialize = $("#billingFrom").serialize();
			$.ajax({
				url: "{{ route('backend.subscription-billing-review') }}",
				type: "POST",
				data: serialize,
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				dataType: 'json',
				success: function(response) {

					var html = '';

					if (response.total_user == 1) {
						var mode_total = response.mode_unit;
					} else {
						var mode_total = response.mode_total;
					}

					html += '<input type="hidden" name="plan_name" value="' + response.plan + '"><input type="hidden" name="mode_name" value="' + response.mode + '"><input type="hidden" name="total_user" value="' + response.total_user + '"><input type="hidden" name="mode_unit" value="' + response.mode_unit + '"><input type="hidden" name="mode_total" value="' + response.mode_total + '"><input type="hidden" name="storage_unit" value="' + response.storage_unit + '"><input type="hidden" name="storage_total" value="' + response.storage_total + '"><input type="hidden" name="inbox_unit" value="' + response.inbox_unit + '"><input type="hidden" name="inbox_total" value="' + response.inbox_total + '"><input type="hidden" name="outbox_total" value="' + response.outbox_total + '"><input type="hidden" name="outbox_unit" value="' + response.outbox_unit + '"><input type="hidden" name="total_amount" value="' + response.total + '"><div class="mb-3"><i class="fas fa-dot-circle fs-6"></i> <label for="">' + response.mode + ' x ' + response.total_user + ' </label><div class="float-end"><p>$' + mode_total + '</p></div></div><div class="mb-3"><i class="fas fa-dot-circle fs-6"></i> <label for="">Storage × ' + response.storage_total + '</label><div class="d-flex justify-content-between"><p>$' + response.storage_unit + ' for ' + response.storage_total + ' units</p><p>$' + response.storage_unit + '</p></div></div><div class="mb-3"><i class="fas fa-dot-circle fs-6"></i> <label for="">Email Inbox × ' + response.inbox_total + '</label><div class="d-flex justify-content-between"><p>$' + response.inbox_unit + ' for ' + response.inbox_total + ' units</p><p>$' + response.inbox_unit + '</p></div></div><div class="mb-3"><i class="fas fa-dot-circle fs-6"></i> <label for="">Email Outbox × ' + response.outbox_total + '</label><div class="d-flex justify-content-between"><p>$' + response.outbox_unit + ' for ' + response.outbox_total + ' units</p><p>$' + response.outbox_unit + '</p></div></div><hr><div class="d-flex justify-content-between"><label for="">Total</label><p>$' + response.total + '</p></div>';

					$('.append-billing-info').append(html);

				}
			});

		});

		$("#checkoutPayment").click(function(e) {
			e.preventDefault();
			var serialize = $("#checkoutPaymentFrom").serialize();
			$.ajax({
				url: "{{ route('backend.subscription-billing-save-review') }}",
				type: "POST",
				data: serialize,
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				dataType: 'json',
				success: function(response) {
					var id = response.billing_id;
					window.location.href = "{{ url('admin/stripe') }}" + "/" + id;
				},
			});

		});





	});
</script>
@endsection