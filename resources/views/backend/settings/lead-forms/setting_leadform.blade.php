@extends('backend.layouts.app')
@section('css')
 
@endsection	
@section('content') 

<div class="card">
	@if(session()->has('success'))
	<div class="alert alert-success">
		{{ session()->get('success') }}
	</div>
	@endif
	<div class="card-body overflowhidden">
		<a class="btn btn-primary float-end ms-2" href="{{ route('backend.setting-leadform-create') }}">Add Lead Form </a>
	</div>
</div>

<div class="card">
	<div class="card-body">
		<div class="table-responsive">
			<table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
				<thead>
					<tr>             
						<th>BADGE</th> 
						<th>FORM NAME</th> 
						<th>URL</th> 
						<th>RELATED OFFICE</th> 
						<th>SOURCE</th> 
						<th>STATUS</th>  
						<th>ACTION</th>  
					</tr>
				</thead>
				<tbody>

				  @foreach($Leadform as $Leadforms)
				  	@php
						$system_fields=json_decode($Leadforms->system_fileds,true);
						$related_office=DB::table('offices')->where('id',$system_fields['related_office'])->get('office_name');
						$source=DB::table('source_lists')->where('id',$system_fields['source'])->get('source_name');
					@endphp
					<tr>
						 <td></td>
                         <td>{{$Leadforms->save_form_as}}</td>
						 <td>
                            <div class="text-truncate text-wrap"><a href="{{$Leadforms->lead_form_link}}">{{$Leadforms->lead_form_link}}</a></div>
                         </td>
						 <td>{{isset($related_office[0]) ? $related_office[0]->office_name : ''}}</td>
						 <td>{{isset($source[0]->source_name) ? $source[0]->source_name : ' '}}</td>
						 <td>
							@if($Leadforms->status == 1)
								<span class="badge bg-success">Active</span>
							@else
								<span class="badge bg-danger">Inactive</span>	
							@endif
						</td>
						 <td>
                            <div class="dropdown float-end">
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-start">
                                    <a href="{{route('backend.setting-leadform-edit',$Leadforms->id)}}" class="dropdown-item">Edit</a>
									@if($Leadforms->favourite_status == 0)
									<a href="{{route('backend.leadform-set-favourite',[$Leadforms->id,$Leadforms->favourite_status])}}" class="dropdown-item">Set as Favorite</a>
									@else
									<a href="{{route('backend.leadform-set-favourite',[$Leadforms->id,$Leadforms->favourite_status])}}" class="dropdown-item">Remove as Favorite</a>
									@endif
									@if($Leadforms->status == 1)
                                    	<a href="{{route('backend.leadform-active-deactive',[$Leadforms->id,$Leadforms->status])}}" class="dropdown-item">Make Inactive</a>
									@else
										<a href="{{route('backend.leadform-active-deactive',[$Leadforms->id,$Leadforms->status])}}" class="dropdown-item">Make Active</a>		
									@endif
                                    <a href="{{$Leadforms->lead_form_link}}" class="dropdown-item">Preview </a>
                                    <a href="javascript:void(0);" class="dropdown-item">Copy Embed Code </a>
                                    <a href="javascript:void(0);" class="dropdown-item"> Download QR Code </a>
                                </div>
                            </div>
                         </td>
						 
					</tr>
				@endforeach	
				</tbody>
			</table>
		</div>
	</div>
</div>
 


@endsection

@section('script')
 <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
@endsection