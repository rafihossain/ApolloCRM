@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
    	<div class="mb-4 text-end">
    		<a class="btn btn-primary" href="{{ route('backend.add-offices') }}"><i class="mdi mdi-plus"></i> Add New Offices</a>
    	</div>
        @if(Session::has('success'))
        <div class="alert alert-success" style="text-align: center;">
            {{ Session::get('success') }}
        </div>
        @endif
        <div class="card">
            <div class="card-body table-responsive"> 
                <table id="datatable" class="table table-bordered table-bordered dt-responsive nowrap">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>City</th>
                            <th>Country</th>
                            <th>Mobile</th>
                            <th>Phone</th>
                            <th>Contact Person</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($offices as $office)
	                    <tr>
	                        <td><a href="{{ route('backend.branch-details', ['id'=>$office->id]) }}">{{ $office->office_name }}</a></td>
	                        <td>{{ $office->city }}</td>
	                        <td>{{ $office->all_country->countryname }}</td>
	                        <td>{{ $office->mobile }}</td>
	                        <td>{{ $office->phone }}</td>
	                        <td>{{ $office->contact_person }}</td> 
	                        <td>
	                        	<a href="{{ route('backend.edit-offices', ['id' => $office->id ]) }}" class="btn btn-sm btn-primary waves-effect waves-light"><i class="mdi mdi-square-edit-outline"></i></a> 
	                        	<a href="{{ route('backend.delete-offices', ['id' => $office->id ]) }}" id="delete" class="btn btn-sm btn-danger waves-effect waves-light"><i class="mdi mdi-trash-can-outline"></i></a>
	                        </td>
	                    </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> <!-- end row -->
<div id="addcatagory" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        	<div class="modal-header">
	            <h4 class="modal-title" id="standard-modalLabel">Add Brand </h4>
	            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	        </div>
            <div class="modal-body">
                <form class="px-3" action="#">
                    <div class="mb-3">
                        <label for="CategoryName" class="form-label">Brand Name</label>
                        <input class="form-control" type="text" id="CategoryName" required="" placeholder=" ">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Brand Image / Icon</label>
                         <input type="file"  class="imageupload" name="">
                    </div>
                    <div class="mb-3 text-center">
                        <button class="btn btn-primary" type="submit">Add Brand</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection

@section('script')
<!-- Datatables init -->
<script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
@endsection
