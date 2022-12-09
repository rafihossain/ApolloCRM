@extends('backend.layouts.app')
@section('content')

<style>
    .innerTitle {
        font-weight: 600;
        font-size: 0.8rem;
        padding: 15px 30px;
        text-transform: uppercase;
    }
    .formPage-lg {
        padding: 10px 30px;
    }
</style>


<div class="card">
	<div class="card-body">
		<form action="{{route('backend.update-offices')}}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $office->id }}">

            <h4 class="bg-light innerTitle m-0">PRIMARY INFORMATION</h4>
            <div class="formPage-lg mb-2">
                <label>Office Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('office_name') is-invalid @enderror" name="office_name"
                value="{{ $office->office_name }}">
                @error('office_name')
                <strong class="text-danger">{{ $message }}</strong>
                @enderror
            </div>
            <h4 class="bg-light innerTitle m-0">ADDRESS</h4>
            <div class="row formPage-lg">
                <div class="col-md-4">
                    <label>Street</label>
                    <input type="text" class="form-control @error('street') is-invalid @enderror" name="street"
                    value="{{ $office->street }}">
                    @error('street')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>    
                <div class="col-md-4">
                    <label>City</label>
                    <input type="text" class="form-control @error('city') is-invalid @enderror" name="city"
                    value="{{ $office->city }}">
                    @error('city')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>    
                <div class="col-md-4">
                    <label>State</label>
                    <input type="text" class="form-control @error('state') is-invalid @enderror" name="state"
                    value="{{ $office->state }}">
                    @error('state')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>    
            </div>
            <div class="row formPage-lg">
                <div class="col-md-4">
                    <label>Zip/Post Code</label>
                    <input type="text" class="form-control " name="post_code"
                    value="{{ $office->post_code }}">
                    @error('post_code')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>    
                <div class="col-md-4">
                    <label>Country <span class="text-danger">*</span></label>
                    <select name="country" id="" class="form-control @error('country') is-invalid @enderror">
                        <option value="">---Country---</option>
                        <option value="1" selected>Antarctica</option>
                        <option value="2">Australia</option>
                        <option value="3">Austria</option>
                        <option value="4">Azerbaijan</option>
                        <option value="5">Belarus</option>
                        <option value="6">Bermuda</option>
                    </select>
                    @error('country')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
            </div>
            <h4 class="bg-light innerTitle m-0">CONTACT DETAILS</h4>
            <div class="row formPage-lg">
                <div class="col-md-4">
                    <label>Email <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{ $office->email }}">
                    @error('email')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>    
                <div class="col-md-4">
                    <label>Phone</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone"
                    value="{{ $office->phone }}">
                    @error('phone')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>    
                <div class="col-md-4">
                    <label>Mobile</label>
                    <input type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile"
                    value="{{ $office->mobile }}">
                    @error('mobile')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>    
            </div>
            <div class="row formPage-lg">
                <div class="col-md-4">
                    <label>Contact Person</label>
                    <input type="text" class="form-control " name="contact_person"
                    value="{{ $office->contact_person }}">
                    @error('contact_person')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
            </div>
            <h4 class="bg-light innerTitle m-0">OTHER INFORMATION</h4>
            <div class="formPage-lg mb-2">
                <label>Choose Admin</label>
                <input type="text" class="form-control @error('choose_admin') is-invalid @enderror" name="choose_admin"
                value="{{ $office->choose_admin }}">
                @error('choose_admin')
                <strong class="text-danger">{{ $message }}</strong>
                @enderror
            </div>
			<div class="text-center">
		        <button type="submit" class="btn btn-primary" type="submit"> Save </button>
		    </div>
		</form>
	</div>
</div>

@endsection