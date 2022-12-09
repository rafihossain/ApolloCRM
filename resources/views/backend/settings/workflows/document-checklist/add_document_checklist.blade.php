@extends('backend.layouts.app')
@section('css')

@endsection
@section('content')
<div class="card">
	<div class="card-body">
		<a href="{{ route('backend.setting-document-checklist') }}" class="btn btn-outline-primary float-end"> Back Checklist </a>
		<h4>Add Document Checklist</h4>
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
			<div class="col-md-8">
				<form method="POST" action="{{ route('backend.setting-document-checklist-save') }}">
					@csrf
					<div class="mb-4">
						<label class="form-label">Selected Workflow <span class="text-danger">*</span> </label>
						<select name="workflow_id" id="workflow" data-width="100%">
							<option value="">Select workflow</option>
							@foreach($workflows as $workflow)
								<option value="{{ $workflow->id }}">{{ $workflow->service_workflow }}</option>
							@endforeach
						</select>
						@error('workflow_id')
							<strong class="text-danger">{{ $message }}</strong>
						@enderror
					</div>
					<div class="mb-2">
						<button type="submit" class="btn btn-primary">Save & next</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection

@section('script')
<script type="text/javascript">
    $('#workflow').select2();
</script>
@endsection