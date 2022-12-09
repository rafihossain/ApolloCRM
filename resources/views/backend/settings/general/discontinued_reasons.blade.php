@extends('backend.layouts.app')
@section('css')

@endsection
@section('content')

<div class="card">
	<div class="card-body overflowhidden">
		<ul class="nav nav-tabs nav-bordered border-0">
			<li class="nav-item">
				<a href="{{ route('backend.pp-type-list') }}" class="nav-link">
					Product / Partner Type
				</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('backend.general-discontinued') }}" class="nav-link active">
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

<div class="card">
	<div class="card-body">
		<h4>Discontinue Reasons</h4>
		<form method="POST" action="{{ route('backend.update-discontinue-reason') }}">
			@csrf
			<table class="table align-middle">
				<tbody class="tablereasons">
					@foreach($generalReason as $reason)
						<tr class="itemtrs">
							<td>
								<!-- <input type="hidden" name="status[]" value="0"> -->
								<input type="checkbox" name="status[]" value="1" {{ $reason->status == 1 ? 'checked' : '' }}>
							</td>
							<td><input type="text" class="form-control" name="reason_name[]" value="{{ $reason->reason_name }}"></td>
							<td>
								<a href="{{ route('backend.delete-discontinue-reason', ['id' => $reason->id ]) }}" id="delete">
									<i class="mdi mdi-close closetr"></i>
								</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			<br><br>
			<button type="button" class="btn btn-outline-primary addreasons"> + Add new Reason</button>
			<br><br>
			<button type="submit" class="btn btn-primary">Save</button>
		</form>
	</div>
</div>

@endsection

@section('script')
<script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#datatable2').DataTable();
	
		$(".addreasons").click(function() {
			$(".tablereasons").append('<tr class="itemtrs"><td><input type="checkbox" name="" checked></td><td><input type="text" class="form-control" name="reason_name[]"></td><td><a href="#" id="delete"><i class="mdi mdi-close closetr"></i></a></td> </tr>');
		});
		$('body').delegate('.closetr', 'click', function() {
			$(this).closest('.itemtrs').remove();
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