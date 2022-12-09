@extends('backend.layouts.app')
@section('css')

@endsection
@section('content')
<div class="card">
	<div class="card-body">
		<ul class="nav nav-tabs nav-bordered border-0">
			<li class="nav-item">
				<a href="{{ route('backend.setting-workflow') }}" class="nav-link active">
					Workflow List
				</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('backend.setting-document-checklist') }}" class="nav-link">	
					Document Checklist
				</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('backend.setting-document-type') }}" class="nav-link">			
					Document Type
				</a>
			</li>
		</ul>
	</div>
</div>

@if(Session::has('success'))
<div class="alert alert-success">
	{{ Session::get('success') }}
</div>
@endif


<div class="card">
	<div class="card-body table-responsive">
		<a href="{{ route('backend.add-workflow') }}" class="btn btn-outline-primary float-end"> + Add</a>
		<table class="table">
			<thead>
				<tr>
					<th>General Services</th>
					<th>Total Partners</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach($settingWorkflows as $workflow)
				<tr>
					<td>{{ $workflow->name }}</td>
					<td>3</td>
					<td><span class="badge bg-primary rounded-pill">Active</span></td>
					<td>
						<a href="{{ route('backend.edit-setting-workflow', ['id'=> $workflow->id ]) }}" class="btn btn-sm btn-primary">
							<i class="mdi mdi-square-edit-outline"></i>
						</a>
						<!-- <a href="#" class="btn btn-sm btn-warning"><i class="mdi mdi-close-box-outline"></i></a> -->
						<a href="{{ route('backend.delete-setting-workflow', ['id'=> $workflow->id ]) }}" id="delete" class="btn btn-sm btn-danger">
							<i class="mdi mdi-delete-outline"></i>
						</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

@endsection

@section('script')
<script>
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