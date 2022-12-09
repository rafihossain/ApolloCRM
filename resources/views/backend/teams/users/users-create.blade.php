@extends('backend.layouts.app')
@section('content')

<div class="card">
	<div class="card-body">
		<form action="{{route('backend.save-users')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-md-8 m-auto">
                <div class="row formPage-lg mb-2">
                    <div class="col-md-6">
                        <label>First Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name"
                        value="{{old('first_name')}}">
                        @error('first_name')
                        <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>    
                    <div class="col-md-6">
                        <label>Last Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name"
                        value="{{old('last_name')}}">
                        @error('last_name')
                        <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>   
                </div>
                <div class="row formPage-lg mb-2">
                    <div class="col-md-6">
                        <label>Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                        value="{{old('password')}}">
                        @error('password')
                        <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>    
                    <div class="col-md-6">
                        <label>Confirm Password</label>
                        <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" name="confirm_password"
                        value="{{old('confirm_password')}}">
                        @error('confirm_password')
                        <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>   
                </div>
                <div class="row formPage-lg mb-2">
                    <div class="col-md-6">
                        <label>Email <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" name="email"
                        value="{{old('email')}}">
                        @error('email')
                        <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>  
                    <div class="col-md-6">
                        <label>Phone </label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone"
                        value="{{old('phone')}}">
                        @error('city')
                        <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>  
                </div>
                <div class="row formPage-lg mb-2">
                    <div class="col-md-6">
                        <label>Position Title </label>
                        <input type="text" class="form-control @error('position_title') is-invalid @enderror" name="position_title"
                        value="{{old('position_title')}}">
                        @error('position_title')
                        <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>    
                    <div class="col-md-6">
                        <label>Role <span class="text-danger">*</span></label>

                        <select class="form-control @error('role') is-invalid @enderror" name="role" id="">
                            <option value="">Select Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>

                        @error('role')
                        <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>  
                </div>
                <div class="row formPage-lg mb-2">
                    <div class="col-md-6">
                        <label>Office <span class="text-danger">*</span></label>

                        <select class="form-control @error('office') is-invalid @enderror" name="office" id="">
                            @foreach($offices as $office)
                                <option value="{{ $office->id }}">{{ $office->office_name }}</option>
                            @endforeach
                        </select>

                        @error('office')
                        <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                </div>
                <div class="text-center mt-4">
                    <button class="btn btn-primary" type="submit"> Save </button>
                </div>
            </div>
		</form>
	</div>
</div>


@endsection