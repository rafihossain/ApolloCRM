@extends('backend.layouts.app')
@section('css')

@endsection
@section('content')
<div class="card">
	<div class="card-body">
		<a href="{{ route('backend.setting-document-checklist') }}" class="btn btn-outline-primary float-end"> Back Checklist </a>
		<h4>Edit Document Checklist</h4>
	</div>
</div>

@if(Session::has('success'))
<div class="alert alert-success">
	{{ Session::get('success') }}
</div>
@endif

<div class="card">
	<div class="card-body table-responsive">
		<div class="row">
			<div class="col-md-9">
				<form method="POST" action="{{ route('backend.setting-document-checklist-save') }}">
					@csrf
					<div class="mb-2">
						<label class="form-label">Document Checklist </label>
						<p>Create your document checklist based on your selected workflow stages</p>
					</div>
					<hr>
					<div class="mb-2">
						<div class="col-md-12">
							<label class="form-label">Document Collections </label>
							@foreach($checklists as $checklist)
								@if($checklist->checklist_status == 1)
								<div class="checklist-item row">
									<div class="col-md-6">
										<p>{{ $checklist->document->type_name }}</p>
									</div>
									<div class="col-md-6">
										@if($checklist->apply_to == 1)
											<span>All Partners</span>
										@else
											@php
												$explode = explode(',', $checklist->select_partner);
											@endphp
											
											<span> {{ count($explode) }} Partner</span>
										@endif
										<a href="{{ route('backend.setting-document-total-checklist-delete', ['id'=> $checklist->id, 'checklist_id' => $checklist->checklist_id ]) }}" id="delete">
											<i class="mdi mdi-delete mdi-18px"></i>
										</a>
										<a href="javascript:void(0)" data-id="{{ $checklist->id }}" class="editTotalChecklist">
											<i class="mdi mdi-pencil mdi-18px"></i>
										</a>
									</div>
								</div>
								@endif
							@endforeach
						</div>
						<a href="javascript:void(0)" class="addNewChecklist" data-id="1">+ Add New Checklist</a>
					</div>
					<div class="mb-2">
						<div class="col-md-8">
							<label class="form-label">Application Submitted </label>
							@foreach($checklists as $checklist)
								@if($checklist->checklist_status == 2)
								<div class="checklist-item row">
									<div class="col-md-6">
										<p>{{ $checklist->document->type_name }}</p>
									</div>
									<div class="col-md-6">
										@if($checklist->apply_to == 1)
											<span>All Partners</span>
										@else
											@php
												$explode = explode(',', $checklist->select_partner);
											@endphp
											
											<span> {{ count($explode) }} Partner</span>
										@endif
										<a href="{{ route('backend.setting-document-total-checklist-delete', ['id'=> $checklist->id, 'checklist_id' => $checklist->checklist_id ]) }}" id="delete">
											<i class="mdi mdi-delete mdi-18px"></i>
										</a>
										<a href="javascript:void(0)" data-id="{{ $checklist->id }}" class="editTotalChecklist"><i class="mdi mdi-pencil mdi-18px"></i></a>
									</div>
								</div>
								@endif
							@endforeach
						</div>
						<a href="javascript:void(0)" class="addNewChecklist" data-id="2">+ Add New Checklist</a>
					</div>
					<div class="mb-2">
						<div class="col-md-8">
							<label class="form-label">Payment Requested </label>
							@foreach($checklists as $checklist)
								@if($checklist->checklist_status == 3)
								<div class="checklist-item row">
									<div class="col-md-6">
										<p>{{ $checklist->document->type_name }}</p>
									</div>
									<div class="col-md-6">
										@if($checklist->apply_to == 1)
											<span>All Partners</span>
										@else
											@php
												$explode = explode(',', $checklist->select_partner);
											@endphp
											
											<span> {{ count($explode) }} Partner</span>
										@endif
										<a href="{{ route('backend.setting-document-total-checklist-delete', ['id'=> $checklist->id, 'checklist_id' => $checklist->checklist_id ]) }}" id="delete">
											<i class="mdi mdi-delete mdi-18px"></i>
										</a>
										<a href="javascript:void(0)" data-id="{{ $checklist->id }}" class="editTotalChecklist"><i class="mdi mdi-pencil mdi-18px"></i></a>
									</div>
								</div>
								@endif
							@endforeach
						</div>
						<a href="javascript:void(0)" class="addNewChecklist" data-id="3">+ Add New Checklist</a>
					</div>
					<div class="mb-2">
						<div class="col-md-8">
							<label class="form-label">Payment Made </label>
							@foreach($checklists as $checklist)
								@if($checklist->checklist_status == 4)
								<div class="checklist-item row">
									<div class="col-md-6">
										<p>{{ $checklist->document->type_name }}</p>
									</div>
									<div class="col-md-6">
										@if($checklist->apply_to == 1)
											<span>All Partners</span>
										@else
											@php
												$explode = explode(',', $checklist->select_partner);
											@endphp
											
											<span> {{ count($explode) }} Partner</span>
										@endif
										<a href="{{ route('backend.setting-document-total-checklist-delete', ['id'=> $checklist->id, 'checklist_id' => $checklist->checklist_id ]) }}" id="delete">
											<i class="mdi mdi-delete mdi-18px"></i>
										</a>
										<a href="javascript:void(0)" data-id="{{ $checklist->id }}" class="editTotalChecklist"><i class="mdi mdi-pencil mdi-18px"></i></a>
									</div>
								</div>
								@endif
							@endforeach
						</div>
						<a href="javascript:void(0)" class="addNewChecklist" data-id="4">+ Add New Checklist</a>
					</div>
					<div class="mb-2">
						<div class="col-md-8">
							<label class="form-label">Certificate Received </label>
							@foreach($checklists as $checklist)
								@if($checklist->checklist_status == 5)
								<div class="checklist-item row">
									<div class="col-md-6">
										<p>{{ $checklist->document->type_name }}</p>
									</div>
									<div class="col-md-6">
										@if($checklist->apply_to == 1)
											<span>All Partners</span>
										@else
											@php
												$explode = explode(',', $checklist->select_partner);
											@endphp
											
											<span> {{ count($explode) }} Partner</span>
										@endif
										<a href="{{ route('backend.setting-document-total-checklist-delete', ['id'=> $checklist->id, 'checklist_id' => $checklist->checklist_id ]) }}" id="delete">
											<i class="mdi mdi-delete mdi-18px"></i>
										</a>
										<a href="javascript:void(0)" data-id="{{ $checklist->id }}" class="editTotalChecklist"><i class="mdi mdi-pencil mdi-18px"></i></a>
									</div>
								</div>
								@endif
							@endforeach
						</div>
						<a href="javascript:void(0)" class="addNewChecklist" data-id="5">+ Add New Checklist</a>
					</div>
					<div class="mb-2">
						<div class="col-md-8">
							<label class="form-label">Certificate sent to the Client </label>
							@foreach($checklists as $checklist)
								@if($checklist->checklist_status == 6)
								<div class="checklist-item row">
									<div class="col-md-6">
										<p>{{ $checklist->document->type_name }}</p>
									</div>
									<div class="col-md-6">
										@if($checklist->apply_to == 1)
											<span>All Partners</span>
										@else
											@php
												$explode = explode(',', $checklist->select_partner);
											@endphp
											
											<span> {{ count($explode) }} Partner</span>
										@endif
										<a href="{{ route('backend.setting-document-total-checklist-delete', ['id'=> $checklist->id, 'checklist_id' => $checklist->checklist_id ]) }}" id="delete">
											<i class="mdi mdi-delete mdi-18px"></i>
										</a>
										<a href="javascript:void(0)" data-id="{{ $checklist->id }}" class="editTotalChecklist"><i class="mdi mdi-pencil mdi-18px"></i></a>
									</div>
								</div>
								@endif
							@endforeach
						</div>
						<a href="javascript:void(0)" class="addNewChecklist" data-id="6">+ Add New Checklist</a>
					</div>
					<div class="mb-2">
						<div class="col-md-8">
							<label class="form-label">Completed </label>
							@foreach($checklists as $checklist)
								@if($checklist->checklist_status == 7)
								<div class="checklist-item row">
									<div class="col-md-6">
										<p>{{ $checklist->document->type_name }}</p>
									</div>
									<div class="col-md-6">
										@if($checklist->apply_to == 1)
											<span>All Partners</span>
										@else
											@php
												$explode = explode(',', $checklist->select_partner);
											@endphp
											
											<span> {{ count($explode) }} Partner</span>
										@endif
										<a href="{{ route('backend.setting-document-total-checklist-delete', ['id'=> $checklist->id, 'checklist_id' => $checklist->checklist_id ]) }}" id="delete">
											<i class="mdi mdi-delete mdi-18px"></i>
										</a>
										<a href="javascript:void(0)" data-id="{{ $checklist->id }}" class="editTotalChecklist"><i class="mdi mdi-pencil mdi-18px"></i></a>
									</div>
								</div>
								@endif
							@endforeach
						</div>
						<a href="javascript:void(0)" class="addNewChecklist" data-id="7">+ Add New Checklist</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Standard modal content -->
<div id="addChecklistModel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addcontact-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addChecklistForm" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title" id="addcontact-modalLabel">Add New Checklist</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
					<input type="hidden" name="checklist_status" class="showStatus">
					<input type="hidden" name="checklist_id" value="{{ $checklist_id }}">
                    <div class="mb-2">
                        <label class="form-label">Document Type <span class="text-danger">*</span></label>
						<select name="document_type_id" data-toggle="select2" data-width="100%">
							<option value="">Select Type</option>
							@foreach($types as $type)
								<option value="{{ $type->id }}">{{ $type->type_name }}</option>
							@endforeach
						</select>
						<span class="text-danger" id="documenttypeError"></span>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Description <span class="text-danger">*</span></label>
						<textarea name="description" class="form-control"></textarea>
						<span class="text-danger" id="descriptionError"></span>
                    </div>
					<div class="mb-2">
						<label class="form-label">Apply To: </label>
						<div class="d-flex">
							<div class="form-check me-2">
								<input type="radio" id="partner1" name="apply_to" class="form-check-input allPartner" value="1" checked="">
								<label class="form-check-label" for="partner1">All Partners</label>
							</div>
							<div class="form-check">
								<input type="radio" id="partner2" name="apply_to" class="form-check-input selectedPartner" value="2">
								<label class="form-check-label" for="partner2">Selected Partners</label>
							</div>
						</div>
					</div>
					<div class="mb-2 showPartner d-none">
						<select class="form-control choosetoshowproduct" name="select_partner[]" data-toggle="select2" data-width="100%" multiple>
							<option value="">Please select partners</option>
							@foreach($partners as $partner)
								<option value="{{ $partner->id }}">{{ $partner->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="mb-2 showProductCheckBox d-none">
						<div class="d-flex">
							<div class="form-check me-2">
								<input type="radio" id="product1" name="product_to" class="form-check-input allProduct" value="1" checked="">
								<label class="form-check-label" for="product1">All Products (Selected Partners)</label>
							</div>
							<div class="form-check">
								<input type="radio" id="product2" name="product_to" class="form-check-input selectedProduct" value="2">
								<label class="form-check-label" for="product2">Select Products</label>
							</div>
						</div>
					</div>
					<div class="mb-3 showProduct d-none">
						<select class="form-control partnerrelatedproduct" name="select_product[]" data-toggle="select2" data-width="100%" multiple>
                            <option value="">Please select products</option>
                        </select>
					</div>
                    <div class="mb-2">
                        <label class="form-label"></label>
						<input type="checkbox" name="upload_document" value="1"> Allow clients to upload documents from client portal
                    </div>
                    <div class="mb-2">
                        <label class="form-label"></label>
						<input type="checkbox" name="mandatory_inorder" value="1"> Make this as mandatory inorder to proceed next stage
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveChecklist">Save</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Standard modal content -->
<div id="updateChecklist" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="updateChecklistForm" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Edit Checklist</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body updateChecklistContent">

                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection

@section('script')
<script type="text/javascript">
	
	$(document).ready(function() {

		$('.addNewChecklist').on("click", function() {
			$('#addChecklistModel').modal("show");
			var checklist_status = $(this).data('id');
			$('.showStatus').val(checklist_status);
		});
		
		$('[data-toggle="select2"]').select2({
    		dropdownParent: $('#addChecklistModel'),
    	});

    });

		
	$('.choosetoshowproduct').on("change", function() {
        var partnerId = $(this).val();
		$('.showProductCheckBox').removeClass('d-none');
		$.ajax({
            url: "{{ route('backend.related-partner-product-info') }}",
            data:{'partner_id':partnerId},
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: 'json',
            success: function(data) {
                if(data != undefined && data != null){
                    var optionValue = '';
                    for(var i = 0; i < data.length; i++){
                        optionValue +='<option value="'+data[i].id+'">'+data[i].name+'</option>';
                    }
                    $('.partnerrelatedproduct').append(optionValue);

                }
            }
        });
    });

	$("#saveChecklist").click(function(e) {
		e.preventDefault();

		var serialize = $("#addChecklistForm").serialize();
		$.ajax({
			url: "{{ route('backend.setting-document-total-checklist-create') }}",
			type: "POST",
			data: serialize,
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			dataType: 'json',
			success: function(response) {
				$('#addDocumentTypeModal').modal("hide");
				window.location.reload();
			},
			error: function(response) {
				$('#documenttypeError').text(response.responseJSON.errors.document_type_id);
				$('#descriptionError').text(response.responseJSON.errors.description);
			}
		});
	});

	$('.editTotalChecklist').on("click", function(e) {
		e.preventDefault();
		$('.showPartner').html('');
		$('#updateChecklist').modal("show");

		var total_checklist_id = $(this).data('id');

		$.ajax({
			url: "{{ route('backend.setting-document-total-checklist-edit') }}",
			data: {
				total_checklist_id: total_checklist_id,
			},
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			dataType: 'json',
			success: function(response) {

				var html = '';

				var all_type = <?= json_encode($types); ?>;
				var type = '';
				for (var i = 0; i < all_type.length; i++) {
					if(response.checklist.document.id == all_type[i].id){
						all_type_selected = 'selected';
					}else{
						all_type_selected = '';
					}
					type += '<option value="'+all_type[i].id+'" '+all_type_selected+'>'+all_type[i].type_name+'</option>';
				}

				if(response.checklist.mandatory_inorder == 1){
					var mandaory_check = 'checked';
				}else{
					var mandaory_check = '';
				}

				if(response.checklist.upload_document == 1){
					var document_check = 'checked';
				}else{
					var document_check = '';
				}

				if(response.checklist.apply_to == 1){
					var all_partner_checked = 'checked';
				}else{
					var all_partner_checked = '';
				}
				if(response.checklist.apply_to == 2){
					var selected_partner_checked = 'checked';
				}else{
					var selected_partner_checked = '';
				}

				if(response.checklist.product_to == 2){
					var selected_product_checked = 'checked';
				}else{
					var selected_product_checked = '';
				}

				var all_partner = <?= json_encode($partners); ?>;
				var partner = '';

				for (var i = 0; i < all_partner.length; i++) {
					partner += '<option value="'+all_partner[i].id+'">'+all_partner[i].name+'</option>';
					if(response.relatedPartner != undefined && response.relatedPartner != null ){
						for (var j = 0; j < response.relatedPartner.length; j++) {
							if(response.relatedPartner[j].id == all_partner[i].id){
								var all_partner_selected = 'selected';
							}else{
								var all_partner_selected = '';
							}
							partner += '<option value="'+response.relatedPartner[j].id+'" '+all_partner_selected+'>'+response.relatedPartner[j].name+'</option>';
						}
					}
				}
				
				var all_product = <?= json_encode($products); ?>;
				var product = '';
				for (var i = 0; i < all_product.length; i++) {
					product += '<option value="'+all_product[i].id+'">'+all_product[i].name+'</option>';
					if(response.relatedProduct != undefined && response.relatedProduct != null ){
						for (var j = 0; j < response.relatedProduct.length; j++) {
							if(response.relatedProduct[j].id == all_product[i].id){
								var all_product_selected = 'selected';
							}else{
								var all_product_selected = '';
							}
							product += '<option value="'+response.relatedProduct[j].id+'" '+all_product_selected+'>'+response.relatedProduct[j].name+'</option>';
						}
					}
				}


				html += '<input type="hidden" name="total_checklist_id" value="'+response.checklist.id+'"><div class="mb-2"><label class="form-label">Document Type <span class="text-danger">*</span></label><select name="document_type_id" data-toggle="select2" data-width="100%"><option value="">Select Type</option>'+type+'</select><span class="text-danger documenttypeError"></span></div><div class="mb-2"><label class="form-label">Description <span class="text-danger">*</span></label><textarea name="description" class="form-control">'+response.checklist.description+'</textarea><span class="text-danger descriptionError"></span></div><div class="mb-2"><label class="form-label">Apply To: </label><div class="d-flex"><div class="form-check me-2"><input type="radio" id="partner1" name="apply_to" class="form-check-input allPartner" value="1" '+all_partner_checked+'><label class="form-check-label" for="partner1">All Partners</label></div><div class="form-check"><input type="radio" id="partner2" name="apply_to" class="form-check-input selectedPartner" value="2" '+selected_partner_checked+'><label class="form-check-label" for="partner2">Selected Partners</label></div></div></div><div class="mb-2 showPartner d-none"><select class="form-control" name="select_partner[]" data-toggle="select2" data-width="100%" multiple><option value="">Please select partners</option>'+partner+'</select></div><div class="mb-2 showProductCheckBox d-none"><div class="d-flex"><div class="form-check me-2"><input type="radio" id="product1" name="product_to" class="form-check-input allProduct" value="1" checked=""><label class="form-check-label" for="product1">All Products (Selected Partners)</label></div><div class="form-check"><input type="radio" id="product2" name="product_to" class="form-check-input selectedProduct" value="2" '+selected_product_checked+'><label class="form-check-label" for="product2">Select Products</label></div></div></div><div class="mb-3 showProduct d-none"><select class="form-control partnerrelatedproduct" name="select_product[]" data-toggle="select2" data-width="100%" multiple><option value="">Please select products</option>'+product+'</select></div><div class="mb-2"><label class="form-label"></label><input type="checkbox" name="upload_document" value="1" '+document_check+'> Allow clients to upload documents from client portal</div><div class="mb-2"><label class="form-label"></label><input type="checkbox" name="mandatory_inorder" value="1" '+mandaory_check+'> Make this as mandatory inorder to proceed next stage</div><button type="button" class="btn btn-primary px-5 w-100" id="update"> Update </button>';

				$('.updateChecklistContent').html(html);


				var selected_partner = response.checklist.apply_to;
				if(selected_partner == 1){
					$('.showPartner').addClass('d-none');
				}
				if(selected_partner == 2){
					$('.showPartner').removeClass('d-none');
				}

				var selected_product = response.checklist.product_to;
				if(selected_product == 1){
					$('.showProduct').addClass('d-none');
					$('.showProductCheckBox').addClass('d-none');
				}
				if(selected_product == 2){
					$('.showProduct').removeClass('d-none');
					$('.showProductCheckBox').removeClass('d-none');
				}

				$('[data-toggle="select2"]').select2({
					dropdownParent: $('#updateChecklist'),
				});

				$(".allPartner").on('click',function() {
					$('.showPartner').addClass('d-none');
				});
				$(".selectedPartner").on('click',function() {
					$('.showPartner').removeClass('d-none');
				});

				$(".allProduct").on('click',function() {
					$('.showProduct').addClass('d-none');
				});
				$(".selectedProduct").on('click',function() {
					$('.showProduct').removeClass('d-none');
				});

			}
		});

	});

	$(document).delegate('#update', 'click', function(e) {
		e.preventDefault();
		var serialize = $("#updateChecklistForm").serialize();
		$.ajax({
			url: "{{ route('backend.setting-document-total-checklist-update') }}",
			type: "POST",
			data: serialize,
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			dataType: 'json',
			success: function(response) {
				// alert(response);
				$('#updateChecklist').modal("hide");
				window.location.reload();
			},
			error: function(response) {
				$('.documenttypeError').text(response.responseJSON.errors.document_type_id);
				$('.descriptionError').text(response.responseJSON.errors.description);
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

	$(".allPartner").on('click',function() {
		$('.showPartner').addClass('d-none');
	});
	$(".selectedPartner").on('click',function() {
		$('.showPartner').removeClass('d-none');
	});


	$(".allProduct").on('click',function() {
		$('.showProduct').addClass('d-none');
	});
	$(".selectedProduct").on('click',function() {
		$('.showProduct').removeClass('d-none');
	});

</script>
@endsection