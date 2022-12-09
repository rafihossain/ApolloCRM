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
		<form action="{{route('backend.save-offices')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <h4 class="bg-light innerTitle m-0">PRIMARY INFORMATION</h4>
            <div class="formPage-lg mb-2">
                <label>Office Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('office_name') is-invalid @enderror" name="office_name"
                value="{{old('office_name')}}">
                @error('office_name')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <h4 class="bg-light innerTitle m-0">ADDRESS</h4>
            <div class="row formPage-lg">
                <div class="col-md-4">
                    <label>Street</label>
                    <input type="text" class="form-control @error('street') is-invalid @enderror" name="street"
                    value="{{old('street')}}">
                </div>    
                <div class="col-md-4">
                    <label>City</label>
                    <input type="text" class="form-control @error('city') is-invalid @enderror" name="city"
                    value="{{old('city')}}">
                </div>    
                <div class="col-md-4">
                    <label>State</label>
                    <input type="text" class="form-control @error('state') is-invalid @enderror" name="state"
                    value="{{old('state')}}">
                </div>    
            </div>
            <div class="row formPage-lg">
                <div class="col-md-4">
                    <label>Zip/Post Code</label>
                    <input type="text" class="form-control " name="post_code"
                    value="{{old('post_code')}}">
                </div>    
                <div class="col-md-4">
                    <label>Country <span class="text-danger">*</span></label>
                    <select name="country_id" class="form-control @error('country_id') is-invalid @enderror">
                        <option value="">Select Country</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->countryname }}</option>
                        @endforeach
                    </select>
                    @error('country_id')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <h4 class="bg-light innerTitle m-0">CONTACT DETAILS</h4>
            <div class="row formPage-lg">
                <div class="col-md-4">
                    <label>Email <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{old('email')}}">
                    @error('email')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>    
                <div class="col-md-4">
                    <label>Phone</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone"
                    value="{{old('phone')}}">
                </div>    
                <div class="col-md-4">
                    <label>Mobile</label>
                    <input type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile"
                    value="{{old('mobile')}}">
                </div>    
            </div>
            <div class="row formPage-lg">
                <div class="col-md-4">
                    <label>Contact Person</label>
                    <input type="text" class="form-control " name="contact_person"
                    value="{{old('contact_person')}}">
                    @error('contact_person')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <h4 class="bg-light innerTitle m-0">OTHER INFORMATION</h4>
            <div class="formPage-lg mb-2">
                <label>Choose Admin</label>
                <input type="text" class="form-control @error('choose_admin') is-invalid @enderror" name="choose_admin"
                value="{{old('choose_admin')}}">
            </div>
			<div class="text-center">
		        <button class="btn btn-primary" type="submit"> Save </button>
		    </div>
		</form>
	</div>
</div>

<script>
    // $(function(){
    //     new NiceCountryInput($("#example")).init();
    // });

    // function onChangeCallback(ctr){
    //     console.log("The country was changed: " + ctr);
    // }

</script>

@endsection