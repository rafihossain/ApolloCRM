@extends('backend.layouts.app')
@section('css')
@endsection	
@section('content')
	<div class="card">
		<div class="card-body">
			<ul class="nav nav-tabs nav-bordered border-0"> 
		        <li class="nav-item">
		          <a href="{{ route('backend.company-profile') }}" class="nav-link active">
		              Company Profile 
		          </a>
		        </li>
		        <li class="nav-item">
		          <a href="{{ route('backend.domain-information') }}" class="nav-link">
		             Domain Information
		          </a>
		        </li>
		        <li class="nav-item">
		          <a href="{{ route('backend.preference-legal') }}" class="nav-link">
		             Legal
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
			<h4>Company Profile</h4>
			<form action="{{ route('backend.update-company-profile') }}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="row">
					<div class="col-md-4">
						<div class="mb-2">
							<label class="form-label">Current Logo</label>
							<input type="file" class="dropify" name="company_image" data-default-file="{{asset($company->company_image)}}">
						</div>
						<div>
							<strong>Preferred</strong> <br/>
							<strong>Type:</strong> png,jpg,jpeg<br/>
							<strong>Resolution:</strong> 200px x 100px<br/>
							<strong>Size:</strong> less than 2MB
						</div>
					</div>
					<div class="col-md-8">
						<div class="row">
							<div class="col-md-6 mb-2">
								<label class="form-label">Company Name <span class="text-danger">*</span></label>
								<input type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name"
								value="{{ $company->company_name }}">
								@error('company_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
							</div>
							<div class="col-md-6 mb-2">
								<label class="form-label">Company Email <span class="text-danger">*</span></label>
								<input type="email" class="form-control @error('company_email') is-invalid @enderror" name="company_email"
								value="{{ $company->company_email }}">
								@error('company_email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
							</div>
							<div class="col-md-6 mb-2">
								<label class="form-label">Company Phone <span class="text-danger">*</span></label>
								<input type="text" class="form-control @error('company_phone') is-invalid @enderror" name="company_phone"
								value="{{ $company->company_phone }}">
								@error('company_phone')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
							</div>
							<div class="col-md-6 mb-2">
								<label class="form-label">Company Fax</label>
								<input type="text" class="form-control" name="company_fax"
								value="{{ $company->company_fax }}">
							</div>
							<div class="col-md-6 mb-2">
								<label class="form-label">Company Website</label>
								<input type="text" class="form-control " name="company_website"
								value="{{ $company->company_website }}">
							</div>
							<div class="col-md-6 mb-2">
								<label class="form-label">Street</label>
								<input type="text" class="form-control " name="company_street"
								value="{{ $company->company_street }}">
							</div>
							<div class="col-md-6 mb-2">
								<label class="form-label">City</label>
								<input type="text" class="form-control" name="company_city"
								value="{{ $company->company_city }}">
							</div>
							<div class="col-md-6 mb-2">
								<label class="form-label">State</label>
								<input type="text" class="form-control" name="company_state"
								value="{{ $company->company_state }}">
							</div>
							<div class="col-md-6 mb-2">
								<label class="form-label">Zip Code</label>
								<input type="text" class="form-control" name="company_zipcode"
								value="{{ $company->company_zipcode }}">
							</div>
							<div class="col-md-6 mb-2">
								<label class="form-label">Country <span class="text-danger">*</span></label>
								<select class="form-control @error('country_id') is-invalid @enderror" name="country_id">
									<option value="">Select country</option>
									@foreach($countries as $country)
										<option value="{{ $country->id }}" 
										{{ $country->id == $company->country_id ? 'selected' : '' }}> {{ $country->countryname }}
										</option>
									@endforeach
								</select>
								@error('country_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
							</div>
							<div class="col-md-12 mt-2">
								<button type="submit" class="btn btn-primary w-100"> Update </button>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection

@section('script')
<script type="text/javascript">
	$(document).ready(function() { 
        $('.dropify').dropify();
    });
</script>
@endsection