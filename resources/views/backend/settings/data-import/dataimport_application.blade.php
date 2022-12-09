@extends('backend.layouts.app')
@section('css')
 
@endsection	
@section('content') 

<div class="card">
	<div class="card-body overflowhidden">
		<button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addcontact">Import Partner & Product</button>
		<ul class="nav nav-tabs nav-bordered border-0"> 
            <li class="nav-item">
                <a href="{{ route('backend.dataimport-partner-product') }}" class="nav-link  ">
                   Partner & Product
                </a>
            </li> 
            <li class="nav-item">
                <a href="{{ route('backend.dataimport-contact') }}" class="nav-link ">
                   Contact
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('backend.dataimport-application') }}" class="nav-link active">
                    Application
                </a>
            </li> 
        </ul>
	</div>
</div> 

<div class="card">
	<div class="card-body">
		 								
		 <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
				<thead>
					<tr>   	 	 		  	 	 	           
						 <th>IMPORT ID</th>
						 <th>DATE & TIME</th>
						 <th>IMPORTED BY</th>
						 <th>SELECTED WORKFLOW</th> 
						 <th>MASTER CATEGORY</th>
						 <th>PARTNER TYPE</th>
						 <th>PRODUCT TYPE</th>
						 <th>STATUS</th>
						 <th>ACTION</th>
					</tr>
				</thead>
				<tbody>
					 
				</tbody>
			</table>
		 
	</div>
</div>

<!-- Standard modal content -->
<div id="addcontact" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addcontact-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h4 class="modal-title" id="addcontact-modalLabel">Import Partner & Product</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"> 
                    <div class="mb-2">
                        <label class="form-label">Upload Xml/Csv</label>
                         <input type="file" class="dropify" name="">
                        <br>
                        <br>
                        <a href="#">Download our sample file template</a>
                 	</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
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