@extends('backend.layouts.app')
@section('content')
<h4 class="mt-0 header-title text-end">
	<a href="{{ url('/product') }}" class="btn btn-primary">  Product List </a>
</h4>

<div class="row">
    <div class="col-md-3">
           @include('backend.product.product_side_nav')
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-body"> 
             @include('backend.product.product_nav')
            </div>
        </div>

        <div class="row"> 
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body widget-user">
                                  
                         <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>Client Name</th>
                                    <th>Assignee</th>
                                    <th>Product Name </th>
                                    <th>Workflow</th>
                                    <th>Current Stage</th>
                                    <th>Status</th>
                                    <th>Added On</th>
                                    <th>Last Updated </th>
                                    <th>Action</th>
                                </tr>
                            </thead>  
                            <tbody> 
                            	<tr>
                            		<td>
                            			 <div class="overflow-hidden">
						                    <div class="float-start me-2">
						                        <img src="{{ asset('assets/images/users/user-2.jpg') }}" alt="user-img" title="Mat Helme" class="rounded-circle img-thumbnail avatar-md">
						                    </div>
						                    <div>
						                        <div class="text-truncate">
						                             <a href="{{ url('/partner/applications') }}">
						                                 Jeel Patel
						                            </a>
						                        </div>
						                        <div class="text-truncate">
						                            <a href="mailto:jeelpatel6093@gmail.com">jeelpatel6093@gmail.com</a>
						                        </div>
						                    </div>
						                </div>
                            		</td>
                            		<td>
                            			<div>Navpreet Kour</div>
                						<small>Sydney - Head Office</small>
                            		</td>
                            		<td>City Campus</td>
                            		<td>Offshore Application</td>
                            		<td>Offer Letter Submitted</td>
                            		<td><span class="badge bg-primary rounded-pill">In Progress</span></td>
                            		<td>2022-09-06</td>
                            		<td>2022-09-06</td>
                            		<td>
                            			<a href="#" class="btn btn-sm btn-success">
						                    <i class="mdi mdi-email-send-outline"></i>
						                </a>
						                <button class="btn btn-sm btn-danger">
						                    <i class="mdi mdi-delete-outline"></i>
						                </button>
                            		</td>
                            	</tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

@endsection

@section('script')
<!-- Datatables init -->
<!-- Widgets demo js--> 
<script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
@endsection