@extends('backend.layouts.app')
@section('css')

@endsection
@section('content')

<div class="card">
	<div class="card-body overflowhidden">

		<ul class="nav nav-tabs nav-bordered border-0">
			<li class="nav-item">
				<a href="{{ route('backend.pp-type-list') }}" class="nav-link active">
					Product / Partner Type
				</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('backend.general-discontinued') }}" class="nav-link">
					Discontinued Reasons
				</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('backend.setting-general-others') }}" class="nav-link">
					Others
				</a>
			</li>
		</ul>
	</div>
</div>

<div class="row">
	<div class="col-12">
		<div class="mb-4 text-end">
			<a class="btn btn-primary" href="#" id="addType"><i class="mdi mdi-plus"></i> Add Type</a>
		</div>

		@if(Session::has('success'))
        <div class="alert alert-success" style="text-align: center;">
            {{ Session::get('success') }}
        </div>
        @endif

		<ul class="nav nav-tabs" id="myTab" role="tablist">
			<li class="nav-item" role="presentation">
				<button class="nav-link active" id="partner-tab" data-bs-toggle="tab" data-bs-target="#partner" type="button" role="tab" aria-controls="partner" aria-selected="true">Partner Type</button>
			</li>
			<li class="nav-item" role="presentation">
				<button class="nav-link" id="product-tab" data-bs-toggle="tab" data-bs-target="#product" type="button" role="tab" aria-controls="product" aria-selected="true">Product Type</button>
			</li>
		</ul>
		<div class="tab-content" id="myTabContent">
			<div class="tab-pane fade show active" id="partner" role="tabpanel" aria-labelledby="partner-tab">
				<div class="card">
					<div class="card-body table-responsive">
						<!-- <table id="responsive-datatable" class="table table-bordered table-bordered dt-responsive nowrap"> -->
						<table id="" class="table">
							<thead class="bg-primary text-white">
								<tr>
									<th>PARTNER TYPE</th>
									<th>MASTER CATEGORY</th>
									<th>STATUS</th>
									<th>ACTION</th>
								</tr>
							</thead>
							<tbody>
								@foreach($partnerTypes as $partner)
								<tr>
									<td>{{ $partner->partner_type }}</td>
									<td>{{ $partner->masterCategory->master_category }}</td>
									@if($partner->partner_status == 1)
									<td><span class="badge bg-success rounded-pill">Publish</span></td>
									@else
									<td><span class="badge bg-danger rounded-pill">Unpublish</span></td>
									@endif
									<td>
										<a href="{{ route('backend.partner-edit', ['id'=> $partner->id ]) }}" class="btn btn-sm btn-primary waves-effect waves-light"><i class="mdi mdi-square-edit-outline"></i></a>
										<a href="{{ route('backend.partner-delete', ['id'=> $partner->id ]) }}" id="delete" class="btn btn-sm btn-danger waves-effect waves-light"><i class="mdi mdi-trash-can-outline"></i></a>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="tab-pane fade" id="product" role="tabpanel" aria-labelledby="product-tab">
				<div class="card">
					<div class="card-body table-responsive">
						<!-- <table id="responsive-datatable" class="table table-bordered table-bordered dt-responsive nowrap"> -->
						<table id="" class="table">
							<thead class="bg-primary text-white">
								<tr>
									<th>PRODUCT TYPE</th>
									<th>MASTER CATEGORY</th>
									<th>STATUS</th>
									<th>ACTION</th>
								</tr>
							</thead>
							<tbody>
								@foreach($productTypes as $product)
								<tr>
									<td>{{ $product->product_type }}</td>
									<td>{{ $product->masterCategory->master_category }}</td>
									@if($product->product_status == 1)
									<td><span class="badge bg-success rounded-pill">Publish</span></td>
									@else
									<td><span class="badge bg-danger rounded-pill">Unpublish</span></td>
									@endif
									<td>
										<a href="{{ route('backend.product-edit', ['id'=> $product->id ]) }}" class="btn btn-sm btn-primary waves-effect waves-light"><i class="mdi mdi-square-edit-outline"></i></a>
										<a href="{{ route('backend.product-delete', ['id'=> $product->id ]) }}" id="delete" class="btn btn-sm btn-danger waves-effect waves-light"><i class="mdi mdi-trash-can-outline"></i></a>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div> <!-- end row -->

<div class="modal fade" id="ppTypeAdd">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add Partner/Product Type</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="ppForm">
					<div class="mb-2">
						<label>Master Category <span class="text-danger">*</span></label>
						<select name="master_category_id" id="" class="form-control">
							<option value="">Select a Master Category</option>
							@foreach($masterCategories as $masterCategory)
							<option value="{{ $masterCategory->id }}">{{ $masterCategory->master_category }}</option>
							@endforeach
						</select>
					</div>
					<div class="mb-2">
						<label>Select Type <span class="text-danger">*</span></label>
						<br>
						<input type="radio" class="partner" name="type" value="partner" checked> Partner Type
						<input type="radio" class="product" name="type" value="product"> Product Type
					</div>
					<div class="partner-name">
						<div class="mb-2">
							<label>Partner Name <span class="text-danger">*</span></label>
							<input type="text" class="form-control" name="partner_name" placeholder="Partner Name">
						</div>
						<div class="form-check form-switch mb-2">
							<input type="checkbox" class="form-check-input" id="customSwitch1" name="partner_status" value="1">
							<label class="form-check-label" for="customSwitch1">Publish</label>
						</div>
					</div>
					<div class="product-name d-none">
						<div class="mb-2">
							<label>Product Name <span class="text-danger">*</span></label>
							<input type="text" class="form-control" name="product_name" placeholder="Product Name">
						</div>
						<div class="form-check form-switch mb-2">
							<input type="checkbox" class="form-check-input" id="customSwitch2" name="product_status" value="1">
							<label class="form-check-label" for="customSwitch2">Publish</label>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-primary" id="submit">Submit</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

@endsection

@section('script')
<script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#datatable2').DataTable();

		$('.partner').on('click', function() {
			$('.product-name').addClass('d-none');
			$('.partner-name').removeClass('d-none');
		});
		$('.product').on('click', function() {
			$('.partner-name').addClass('d-none');
			$('.product-name').removeClass('d-none');
		});
		$('#addType').click(function(e) {
			e.preventDefault();
			$('#ppTypeAdd').modal('show');
		});
		$('#submit').click(function(e) {
			e.preventDefault();
			var serialize = $('#ppForm').serialize();

			$.ajax({
				url: "{{ route('backend.pp-type-add') }}",
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				method: "POST",
				data: serialize,
				dataType: 'json',
				success: function(data) {
					$('#ppTypeAdd').modal('hide');
					window.location.reload();
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
	});
</script>
@endsection