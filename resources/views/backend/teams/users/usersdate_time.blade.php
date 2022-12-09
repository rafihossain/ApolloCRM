@extends('backend.layouts.app')
@section('css')

@endsection
@section('content')
<h4 class="mt-0 header-title text-end">
    <a href="{{ url('/usersactive') }}" class="btn btn-outline-primary">  Users List </a>
</h4>
<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body"> 
                <div class="text-center">
                   
                    <div>
                        <img src="{{ asset('assets/images/users/user-2.jpg') }}" alt="user-img" title="Mat Helme" class="rounded-circle img-thumbnail avatar-xl">
                    </div>
                    <h4>{{$user['first_name'].' '.$user['last_name']}}</h4>
                    <div>
                        <a href="#" class=" me-2 left-user-info">
                            <i class="mdi mdi-email-outline mdi-18px"></i>
                        </a> 
                        <a href="#" class=" me-2 left-user-info">
                            <i class="mdi mdi-forum-outline mdi-18px"></i>
                        </a>
                        <a href="{{ route('backend.edit-users',$user['id'])}}" class=" me-2 left-user-info">
                            <i class="mdi mdi-square-edit-outline mdi-18px"></i>
                        </a>
                    </div>
                </div>
                <hr/>
                <h5>PERSONAL INFORMATION:</h5>
                <div class="mb-2">
                  <strong> Offices: </strong>  <a href="#">Change Office</a>
                </div>
                <div class="mb-2">
                  {{$user['office']['office_name']}}
                </div>
                <div class="mb-2">
                <strong> Email:  </strong> {{$user['email']}}
                </div>

                <div class="mb-2">
                  <strong>Phone:   </strong> - {{$user['mobile']}}
                </div>
                <div class="mb-2">
                  <strong> Role: </strong>  Team Leader - {{$user['role']['name']}}
                </div>
                <div class="mb-2">
                  <strong>Position: </strong> Manager - {{$user['position']}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-body"> 
                <ul class="nav nav-tabs nav-bordered border-0">
                    <li class="nav-item">
                        <a href="{{route('backend.usersdetails',$user['id'])}}" class="nav-link">
                            Clients 
                        </a>
                    </li> 
                    <li class="nav-item">
                        <a href="{{ route('backend.user_datetime',$user['id'])}}" class="nav-link active">
                            Date & Time
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('backend.usersdetails',$user['id'])}}" class="nav-link ">
                            Permission
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('backend.user_kpi',$user['id'])}}" class="nav-link ">
                            KPI
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        @if(Session::has('success'))
            <div class="alert alert-success" style="text-align: center;">
                {{ Session::get('success') }}
            </div>
        @endif
        <div class="card">
            <div class="card-body">
                    <form method="post" action="{{route('backend.user_timezone_save',$user['id'])}}">
                        @csrf
                        <div class="form-group col-md-6">
                            <label for="">Select Timezone</label>
                            <select class="form-control  @error('user_timezone') is-invalid @enderror" name="user_timezone">
                                   <option value="">Please Select Timezone</option> 
                                   @foreach($timezone as $timezones) 
                                        <option value="{{$timezones['id']}}">{{$timezones['value']}}</option> 
                                   @endforeach
                            </select>
                            @error('user_timezone')
                            <strong class="text-danger">{{ $message }}</strong>
                            @enderror    
                            
                        </div>
                        <button class="btn btn-primary mt-3" type="submit">Save & Apply</button>
                    </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<!-- Datatables init -->
<script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
@endsection