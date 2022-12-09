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
				<a href="{{ route('backend.general-discontinued') }}" class="nav-link">
					Discontinued Reasons
				</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('backend.setting-general-others') }}" class="nav-link active">
					Others
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
	<div class="card-body">
		<h4>Discontinue Reasons</h4>
		<form method="POST" action="{{ route('backend.update-general-others') }}">
			@csrf
			<input type="hidden" name="id" value="{{ $other->id }}">
			<div class="mb-2">
				<label class="form-label">Choose default id to use as search criteria</label>
				<div class="">
					<div class="form-check">
						<input type="radio" id="customRadio1" name="choose_criteria" class="form-check-input" value="1" {{ $other->choose_criteria == 1 ? 'checked' : '' }}>
						<label class="form-check-label" for="customRadio1">Internal Id</label>
					</div>
					<div class="form-check">
						<input type="radio" id="customRadio2" name="choose_criteria" class="form-check-input" value="2" {{ $other->choose_criteria == 2 ? 'checked' : '' }}>
						<label class="form-check-label" for="customRadio2">Client Id</label>
					</div>
				</div>
			</div>
			<div class="mb-2">
				<label class="form-label">Internal Id Prefix</label>
				<input type="text" class="form-control" name="internal_prefix" value="{{ $other->internal_prefix }}">
			</div>
			<div class="mb-2">
				<label class="form-label">System Date Format</label>
				<select class="form-control" name="date_format">
					<option value="1">MM-DD-YYYY (12-22-2020)</option>
					<option value="2">DD-MM-YYYY (01-12-2020)</option>
					<option value="3">YYYY-MM-DD (2012-12-22)</option>
					<option value="4">DD-MM-YYYY (22-Dec-2020)</option>
					<option value="5">DD MMM, YYYY (22 Dec, 2020)</option>
					<option value="6">YYYY/MM/DD (2012/12/22)</option>
					<option value="7">DD/MM/YYYY (01/12/2020)</option>
					<option value="8">MM/DD/YYYY (04/22/2020)</option>
				</select>
			</div>
			<div class="mb-2">
				<label class="form-label">How did you hear about us ?</label>
			</div>
			<table class="table align-middle">
				<tbody class="tablereasons">
					@foreach($aboutUs as $about)
					<tr class="itemtrs">
						<td><input type="checkbox" name="" checked=""></td>
						<td><input type="text" class="form-control" name="about_us[]" value="{{$about->about_us}}"></td>
						<td>
							<a href="{{ route('backend.delete-general-others', ['id' => $about->id ] ) }}" id="delete">
								<i class="mdi mdi-close closetr"></i>
							</a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			<br>
			<button class="btn btn-outline-primary addreasons" type="button"> + Add new Reason</button>
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
			$(".tablereasons").append('<tr class="itemtrs"><td><input type="checkbox" name="" checked=""></td><td><input type="text" value="" class="form-control" name="about_us[]"></td><td><i class="mdi mdi-close closetr"></i></td></tr>');
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

	});
</script>
@endsection