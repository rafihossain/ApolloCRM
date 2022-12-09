@extends('backend.layouts.app')
@section('css')

@endsection
@section('content')

@if(session()->has('success'))
<div class="alert alert-success">
    {{ session()->get('success') }}
</div>
@endif

<div class="card">
	<div class="card-body">
		<form method="post" action="{{ route('backend.setting-office-checkin-update') }}">
			@csrf
			<div class="row mb-2">
				<div class="col-md-4">
					<select class="form-control" name="office_id" id="officeInformation">
						@foreach($offices as $value)
						<option value="{{ $value->id }}" {{ $office->office_id == $value->id ? 'selected' : '' }}>{{ $value->office_name }}</option>
						@endforeach
					</select>
				</div>
			</div>

			<div class="mb-2">
				<label class="form-label mt-3">Set Visit Purpose mandatory while:</label>
				<div>
					<input type="hidden" name="purpose_mandatory" value="0">
					<input type="checkbox" name="purpose_mandatory" value="1" id="as1" {{ $office->purpose_mandatory == 1 ? 'checked' : '' }}> <label for="as1">Creating a new Office Check-In.</label>
				</div>
				<label class="form-label mt-3">Set a Comment mandatory while:</label>
				<div>
					<input type="hidden" name="attending" value="0">
					<input type="checkbox" name="attending" id="as2" value="1" {{ $office->attending == 1 ? 'checked' : '' }}> <label for="as2">Attending an Office Check-In.</label>
				</div>
				<div>
					<input type="hidden" name="completing" value="0">
					<input type="checkbox" name="completing" id="as4" value="1" {{ $office->completing == 1 ? 'checked' : '' }}> <label for="as4">Completing an Office Check-In.</label>
				</div>
				<div>
					<input type="hidden" name="archiving" value="0">
					<input type="checkbox" name="archiving" id="as3" value="1" {{ $office->archiving == 1 ? 'checked' : '' }}> <label for="as3">Archiving an Office Check-In.</label>
				</div>
				<label class="form-label mt-3">Set Assignee mandatory while:</label>
				<div>
					<input type="hidden" name="assignee_mandatory" value="0">
					<input type="checkbox" name="assignee_mandatory" id="as6" value="1" {{ $office->assignee_mandatory == 1 ? 'checked' : '' }}> <label for="as6">Creating a new Office Check-In.</label>
				</div>
			</div>
			<button type="submit" class="btn btn-primary">Save</button>
		</form>
	</div>
</div>


@endsection

@section('script')
<script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function() {

		$('#officeInformation').on('change', function() {
			var officeId = $(this).val();
			window.location.href = "{{ route('backend.setting-office-checkin') }}" + "/" + officeId;
		});

		$('.dropify').dropify();
	});
</script>
@endsection