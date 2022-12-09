@extends('backend.layouts.app')
@section('css')

@endsection
@section('content')
<div class="card">
	<div class="card-body">
		<a href="{{ route('backend.setting-workflow') }}" class="btn btn-outline-primary float-end"> Workflow </a>
		<h4>Edit Workflow</h4>
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
				<form method="POST" action="{{ route('backend.update-setting-workflow') }}">
					@csrf
					<input type="hidden" name="workflow_id" value="{{ $stage->id }}">

					<div class="mb-2">
						<label class="form-label">Workflow Name <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="name" value="{{ $stage->name }}">
					</div>
					<div class="mb-2">
						<label class="form-label">Workflow is accessible to <span class="text-danger">*</span></label>
						<div class="d-flex">
							<div class="form-check me-2">
								<input type="radio" id="office1" name="accessible_id" data-id="{{ $stage->accessible_id }}"
								class="form-check-input allOffice" value="1"
								{{ $stage->accessible_id == 1 ? 'checked' : '' }}>
								<label class="form-check-label" for="office1">All Offices</label>
							</div>
							<div class="form-check">
								<input type="radio" id="office2" name="accessible_id" data-id="{{ $stage->accessible_id }}" 
								class="form-check-input selectedOffice" value="2"
								{{ $stage->accessible_id == 2 ? 'checked' : '' }}>
								<label class="form-check-label" for="office2">Selected Offices</label>
							</div>
						</div>
					</div>
					<div class="mb-2 showOffice">
						<label class="form-label">Accessible Offices : <span class="text-danger">*</span></label>
						<select class="form-control" name="office_id[]" data-toggle="select2" data-width="100%" multiple>
							<option value="">Select Office</option>
							@foreach($offices as $office)
								<option value="{{ $office->id }}">{{ $office->office_name }}</option>

								@if($relatedOffice != '')
									@foreach($relatedOffice as $office_new)
										<option value="{{ $office->id }}" 
										{{$office_new->id == $office->id ? 'selected' : ''}}>{{ $office->office_name }}</option>
									@endforeach
								@endif

							@endforeach
						</select>
					</div>
					<div class="mb-2 workflowstage">
						<div class="row mb-2">
							<div class="col-10">
								<label class="form-label">Workflow Stages</label>
								<div>
									<small><i class="mdi mdi-information-outline"></i> You can create up to 20 stages in a workflow with atleast 2 active stages.</small>
								</div>
							</div>
							<div class="col-2">
								<label class="form-label">Win Stage</label>
							</div>
						</div>
						
						@foreach($stage->stage as $key => $new_stage)
						<div class="row mb-2 align-items-center">
							<div class="col-10">
								<div class="d-flex align-items-center gap-2">
									<!-- <input type="text" name="stage_name[]" value="{{ $new_stage->id }}"> -->
									<input type="text" class="form-control" name="stage_name[]" value="{{ $new_stage->stage_name }}">
									<div class="d-flex gap-1">
										<i data-bs-toggle="tooltip" data-bs-placement="top" title="Require Partner's Client ID">#</i>
										<i class="mdi mdi-calendar-month" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Start and End date"></i>
										<i class="mdi mdi-note-outline" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Notes"></i>
										<i class="mdi mdi-calendar-check-outline" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Application Intake field"></i>
										@if($key !== 0 && $key !== 1)
											<a href="{{ route('backend.delete-setting-workflow-stage', ['id' => $new_stage->id, 'workflow_id' => $stage->id ]) }}" id="delete">
												<i class="mdi mdi-delete-outline" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete your Workflow Stage"></i>
											</a>
										@endif
									</div>
								</div>
							</div>
							<div class="col-2 text-center">
								<i class="mdi mdi-trophy-variant" data-bs-toggle="tooltip" data-bs-placement="top" title="Set as Win Stage"></i>
							</div>
						</div>
						@endforeach
					</div>

					<div class="mt-4 mb-4 d-flex gap-1">
						<input type="text" class="form-control workflow_value" id="add_workflow_input" value="">
						<label for="add_workflow_input" class="btn btn-primary addwakinput"><i class="mdi mdi-plus"></i> </label>
					</div>
					<button type="submit" class="btn btn-primary">Save</button>
				</form>
			</div>
			<div class="col-md-3">
				<div class="bg-light p-3">
					<p> <i class="mdi mdi-information-outline"></i> Points to remember A workflow will always have atleast 2 stages by default</p>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('script')
<script type="text/javascript">
	
	$(document).ready(function() {
		// alert('hello');
		var selected_office = $('.selectedOffice').data('id');
		if(selected_office == 1){
			$('.showOffice').addClass('d-none');
		}
		if(selected_office == 2){
			$('.showOffice').removeClass('d-none');
		}

        $('[data-toggle="select2"]').select2();
    });

	$(".allOffice").on('change',function() {
		$('.showOffice').addClass('d-none');
	});
	$(".selectedOffice").on('change',function() {
		$('.showOffice').removeClass('d-none');
	});

	$(".addwakinput").click(function() {

		var workflow_value = $('.workflow_value').val();
		
		if(workflow_value == ''){
			workflow_value = '';
		}else{
			workflow_value = $('.workflow_value').val();
		}

		$(".workflowstage").append('<div class="row workflowstageitem mb-2 align-items-center"> <div class="col-10"> <div class="d-flex align-items-center gap-2"> <input type="text" class="form-control" name="stage_name[]" placeholder="Your stage name here" value="'+workflow_value+'"> <div class="d-flex gap-1"> <i data-bs-toggle="tooltip" data-bs-placement="top" title="Require Partners Client ID">#</i> <i class="mdi mdi-calendar-month" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Start and End date"></i> <i class="mdi mdi-note-outline" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Notes"></i> <i class="mdi mdi-calendar-check-outline" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Application Intake field"></i> <i class="mdi mdi-delete-outline" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete your Workflow Stage"></i> <div class="form-check form-switch"> <input type="checkbox" class="form-check-input" checked=""> </div> </div> </div> </div> <div class="col-2 text-center"> <i class="mdi mdi-trophy-variant" data-bs-toggle="tooltip" data-bs-placement="top" title="Set as Win Stage"></i> </div> </div>');

		$('.workflow_value').val('');

	});
	$('body').delegate('.workflowstageitem .mdi-delete-outline', 'click', function() {
		$(this).closest('.workflowstageitem').remove();
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


</script>
@endsection