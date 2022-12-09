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
                        <a href="{{route('backend.usersdetails',$user['id'])}}" class="nav-link active">
                            Clients 
                        </a>
                    </li> 
                    <li class="nav-item">
                        <a href="{{ route('backend.user_datetime',$user['id'])}}" class="nav-link ">
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
        <div class="card">
            <div class="card-body">
                                
                <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                            <thead>
                                <tr> 
                                    <th>NAME</th>
                                    <th>RATING</th>
                                    <th> DOB </th>
                                    <th>ASSIGNEE</th>
                                    <th> ASSIGNEE OFFICE </th>
                                    <th>ADDED ON</th>
                                    <th>CLIENT STATUS</th> 
                                </tr>
                            </thead>  
                            <tbody>
                               @foreach($user['clients'] as $user_clients)  
                                <tr>
                                    <td>
                                         <div class="overflow-hidden">
                                            <div class="float-start me-2">
                                                <img src="{{ asset('assets/images/users/user-2.jpg') }}" alt="user-img" title="Mat Helme" class="rounded-circle img-thumbnail avatar-md">
                                            </div>
                                            <div>
                                                <div class="text-truncate">
                                                     <a href="{{route('backend.manage-activitie',$user_clients['id'])}}">
                                                         {{$user_clients['first_name'].' '.$user_clients['last_name']}}
                                                    </a>
                                                </div>
                                                <div class="text-truncate">
                                                    <a href="mailto:{{$user_clients['email']}}">{{$user_clients['email']}}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td>-</td>
                                    <td></td>
                                    <td>{{$user['first_name'].' '.$user['last_name']}}</td> 
                                    <td>{{$user['office']['office_name']}}</td> 
                                    <td>{{\Carbon\Carbon::parse($user_clients['created_at'])->format('Y-m-d') }}</td>
                                    <td>
                                        @if($user_clients['client_status'] == 0)
                                            <p>Prospect</p>
                                        @elseif($user_clients['client_status'] == 1)
                                            <p>Client</p>
                                        @else
                                            <p>Archived</p>        
                                        @endif
                                    </td> 
                                </tr>
                             @endforeach   
                            </tbody>
                        </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<!-- Datatables init -->
<script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
@endsection