@extends('backend.layouts.app')
@section('content')
<h4 class="mt-0 header-title text-end">
	<a href="{{ url('/addproduct') }}" class="btn btn-primary">Add Product</a>
</h4>
<div class="card">
	<div class="card-body"> 

<table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
    <thead>
        <tr>  
            <th>Name</th>
            <th>Sync</th>
            <th>Associated Partner</th>
            <th>Product Type</th> 
            <th>Enrolled</th>
            <th>In Progress </th>
            <th>Branches </th>
            <th>Action</th>
        </tr>
    </thead>  
    <tbody>
        @foreach($products as $product)
        <tr>
            <td> 
                <div class="text-truncate">
                    <a href="{{ url('/product/applications') }}">
                      {{ $product['name'] }}
                    </a>
                </div>
            </td>
            <td><span class="badge bg-primary rounded-pill">Auto Synced</span></td>
            <td>
                <div class="text-truncate">
                   <a href="#"> Victoria University (VU)</a>
                </div>
           </td>  
            <td>Course</td> 
            <td>1</td>
            <td>1</td>
            <td><span class="badge bg-primary rounded-pill">Head Office</span> </td>
            <td>
                <a href="#" class="btn btn-sm btn-success">
                    <i class="mdi mdi-square-edit-outline"></i>
                </a>
                <button class="btn btn-sm btn-danger">
                    <i class="mdi mdi-delete-outline"></i>
                </button>
            </td>
        </tr> 
       @endforeach
    </tbody>
</table>
	</div>
</div>
@endsection

@section('script')
<!-- Datatables init -->

<script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
@endsection