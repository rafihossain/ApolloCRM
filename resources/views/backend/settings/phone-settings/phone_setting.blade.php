@extends('backend.layouts.app')
@section('css')
 
@endsection	
@section('content') 

<div class="card">
	<div class="card-body overflowhidden">
		<button class="btn btn-primary float-end ms-2"  data-bs-toggle="modal" data-bs-target="#AddNewPhoneNumbers">Add New Phone numbers </button>
		<button class="btn btn-outline-primary float-end"  data-bs-toggle="modal" data-bs-target="#BuyCredit">Buy Credit</button>
		<ul class="nav nav-tabs nav-bordered border-0">  
            <li class="nav-item">
                <a href="{{ route('backend.phone-setting') }}" class="nav-link active">
                    Phone Numbers  
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('backend.credit-balance') }}" class="nav-link">
                    Credit Balances
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('backend.phone-setting-log') }}" class="nav-link">
                    Logs
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('backend.regulatory-compliance') }}" class="nav-link">
                    Regulatory Compliance
                </a>
            </li>
        </ul>
	</div>
</div>

<div class="card">
	<div class="card-body">
		<div class="table-responsive">
			<table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
				<thead>
					<tr>				
						<th>PHONE NUMBER</th>
						<th>SERVICE AV.</th>
						<th>MONTHLY COST</th>
						<th>USER SHARING</th>
						<th>ADMIN USERS</th>
						<th>ACTION</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td> +61485868619</td>
						<td> <i class="mdi mdi-forum-outline"></i></td>
						<td>AUD 12.15</td>
						<td> <img class="flex-shrink-0 me-1 rounded-circle avatar-sm" alt="64x64" src="{{ asset('assets/images/users/user-4.jpg') }}"> <img class="flex-shrink-0 me-1 rounded-circle avatar-sm" alt="64x64" src="{{ asset('assets/images/users/user-1.jpg') }}"><img class="flex-shrink-0 me-1 rounded-circle avatar-sm" alt="64x64" src="{{ asset('assets/images/users/user-2.jpg') }}"><img class="flex-shrink-0 me-1 rounded-circle avatar-sm" alt="64x64" src="{{ asset('assets/images/users/user-3.jpg') }}"> + </td>
						<td><img class="flex-shrink-0 me-1 rounded-circle avatar-sm" alt="64x64" src="{{ asset('assets/images/users/user-5.jpg') }}"></td>
						<td><button class="btn btn-sm btn-danger"><i class="mdi mdi-delete-outline"></i></button> </td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- Standard modal content -->
<div id="AddNewPhoneNumbers" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addcontact-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h4 class="modal-title">Add New Phone Numbers</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                     <h5>Search Phone Numbers</h5>
                    <div class="mb-2">
                        <label class="form-label">Country </label>
                        <div class="row">
                        	<div class="col-7">
                        		<select class="form-control">
	                        		<option value="1">Austolia</option>
	                        		<option value="2">Bangladesh</option>
	                        	</select>
                        	</div>
                        	<div class="col-5">
                        		<button type="button" class="btn btn-outline-primary">Search Number</button>
                        	</div> 
                        </div>
                    </div>
                    <div class="mb-2">
                    	<h5>Regulatory Compliance Not Available</h5>
                    	<p><small>You must have approved regulatory bundle to purchase phone numbers</small></p>
                    	<div>
                    		<a class="btn btn-outline-primary" href="javasctipt:;"  data-bs-toggle="modal" data-bs-target="#AddNewRegulatoryCompliance">+ Add New Regulatory</a>
                    		<a class="btn btn-outline-primary" href="{{ url('/regulatorycompliance') }}">Go to Regulatory Compliance</a>
                    	</div>
                        
                    </div> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Next</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- Standard modal content -->
<div id="AddNewRegulatoryCompliance" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addcontact-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h4 class="modal-title">Add New Regulatory Compliance </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                    	<div class="col-md-6">
                    		<div class="mb-2">
		                        <label class="form-label">Country </label> 
	                        	<select class="form-control">
	                        		<option value="1">Austolia</option>
	                        		<option value="2">Bangladesh</option>
	                        	</select> 
		                      
		                    </div>
                    	</div>
                    	<div class="col-md-6">
                    		<label class="form-label">Phone Type</label>
                    		<select class="form-control">
                    			<option value="1">Mobile</option>
                    		</select>
                    	</div>
                    	<div class="col-md-12">
	                    	<h5>Enter Business Information</h5>
	                    	<p><small>We need you to provide information about the business that will be using Australia Mobile Phone Numbers</small></p>
                    	</div>
                    	<div class="col-md-6">
                    		<label class="form-label">Regulatory Friendly Name</label>
                    		<input type="text" class="form-control" name="">
                    	</div>
                    	<div class="col-md-6">
                    		<label class="form-label">Business Name</label>
                    		<input type="text" class="form-control" name="">
                    	</div>
                    	<div class="col-md-12">
	                    	<h5>Upload supporting documents</h5>
	                    	<p><small>To comply with local regulations, we need you to provide supporting documentation to carriers or local enforcement agencies. Supporting documents are used to verify the end-user's information.</small></p>
	                    	<a href="javasctipt:;"  data-bs-toggle="modal" data-bs-target="#AddNewRegulatorydoc">+ Add New Document</a>
                    	</div>
                    </div>
                    
                  
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Next</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- Standard modal content -->
<div id="AddNewRegulatorydoc" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addcontact-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h4 class="modal-title">Add New Regulatory Compliance > Upload supporting documents </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                    	<div class="col-md-12">
                    		<div class="mb-2">
		                        <label class="form-label">Types of supporting documents  </label> 
	                        	<select class="form-control">
	                        		<option value="1">Commercial registry or equivalent showing address</option>
	                        		<option value="2">Utility bill</option>
	                        		<option value="2">Tax notice</option>
	                        		<option value="2"> Rent receipt</option>
	                        		<option value="2">Title deed</option>
	                        	</select>
		                    </div>
                    	</div> 
                    	<div class="col-md-12"> 
                    		<input type="file" class="dropify" name="">
                    		<p><small>The file must be JPG, PNG, or PDF. Maximum file size: 5MB</small></p>
                    	</div>
                    	 
                    </div>
                    
                  
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Next</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- Standard modal content -->
<div id="BuyCredit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addcontact-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h4 class="modal-title">Buy Credit </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                    	<div class="col-md-6">
                    		<div class="mb-2">
		                        <label class="form-label">Select Phone Number</label> 
	                        	<select class="form-control">
	                        		<option value="1">All Number</option> 
	                        	</select>
		                    </div>
                    	</div> 
                    	<div class="col-md-12"> 
                    		<label class="form-label">Choose or Enter Credit Balance</label>
                    		<p><i class="mdi mdi-information-outline"></i> <small>Max custom amount can only be set upto 5000.00</small></p>
                    		<table>
                    			<tbody>
                    				<tr>
                    					<td>
                    						<button type="button" class="btn btn-outline-secondary">AUD 10.00</button>
                    					</td>
                    					<td>
                    						<button type="button" class="btn btn-outline-secondary">AUD 50.00</button>
                    					</td>
                    					<td>
                    						<button type="button" class="btn btn-outline-secondary">AUD 100.00</button>
                    					</td>
                    					<td>
                    						<button type="button" class="btn btn-outline-secondary">AUD 500.00</button>
                    					</td>
                    					<td>
                    						<button type="button" class="btn btn-outline-secondary">AUD 1000.00</button>
                    					</td>
                    				</tr>
                    			</tbody>
                    		</table>
                    	</div>
                    	
                    	<div class="col-md-12 mt-4 mb-2">
                    		<input type="checkbox" name="">
                    		I accept with <a href="#"> Agentcis Phone Subscription Terms & Conditions</a>
                    	</div> 

                    </div>
                    
                  
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Buy Now</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

 



@endsection

@section('script')
 <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
 <script type="text/javascript">
 	$(document).ready(function() { 
        $('.dropify').dropify(); 
    });
 </script>
@endsection