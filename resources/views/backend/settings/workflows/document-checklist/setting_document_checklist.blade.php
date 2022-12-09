@extends('backend.layouts.app')
@section('css')

@endsection
@section('content')
<div class="card">
	<div class="card-body">
		<ul class="nav nav-tabs nav-bordered border-0">
			<li class="nav-item">
				<a href="{{ route('backend.setting-workflow') }}" class="nav-link">
					Workflow List
				</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('backend.setting-document-checklist') }}" class="nav-link active">	
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
		<a href="{{ route('backend.setting-document-checklist-add') }}" class="btn btn-outline-primary float-end"> + Add</a>
		<table class="table">
			<thead>
				<tr>	
					<th>Selected Workflow</th>
					<th>Total Checklist</th>
					<th>Added By</th>
					<th>Status</th>
					<th>Added On</th>
					<th>Last Updated</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach($documentChecklists as $checklist)
				<tr>
					<td>{{ $checklist->workflow->service_workflow }}</td>
					<td>{{ count($checklist->total_checklist) }}</td>
					<td>{{ $checklist->user->first_name.' '.$checklist->user->last_name }}</td>
					<td><span class="badge bg-primary rounded-pill">Active</span></td>
					<td>{{ $checklist->created_at }}</td>
					<td>{{ $checklist->updated_at }}</td>
					<td>
						<a href="{{ route('backend.setting-document-checklist-edit', ['id'=> $checklist->id ]) }}" class="btn btn-sm btn-primary">
							<i class="mdi mdi-square-edit-outline"></i>
						</a>
						<!-- <a href="#" class="btn btn-sm btn-warning"><i class="mdi mdi-close-box-outline"></i></a> -->
						<a href="{{ route('backend.setting-document-checklist-delete', ['id'=> $checklist->id ]) }}" id="delete" class="btn btn-sm btn-danger">
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