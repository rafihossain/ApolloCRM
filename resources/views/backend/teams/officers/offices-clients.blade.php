@extends('backend.layouts.app')
@section('content')
<div class="mb-2 text-end">
    <a href="{{ route('backend.manage-offices') }}" class="btn btn-outline-primary">Office List</a>
</div>

@include('backend.teams.officers.offices-include')

 <div class="card">
     <div class="card-body">
        <ul class="nav nav-tabs nav-bordered border-0 mb-4"> 
            <li class="nav-item">
                <a href="{{ route('backend.branch-details',['id'=>$office->id]) }}" class="nav-link ">
                    Users List 
                </a>
            </li> 
            <li class="nav-item">
                <a href="{{ route('backend.branch-clients',['id'=>$office->id]) }}" class="nav-link active">
                    Clients List
                </a>
            </li>
        </ul>

         <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
            <thead>
                <tr>                                            
                    <th>Name</th>
                    <th>DOB</th>
                    <th>Email</th>
                    <th>Workflow</th>
                    <th>Added By  </th>
                    <th>Office</th> 
                </tr>
            </thead>  
            <tbody>
                @foreach($clients as $client)
                <tr>  
                    <td><a href="{{ url('/') }}/admin/client/activitie/{{ $client->id }}">{{ $client->first_name.' '.$client->last_name }}</a></td> 
                    <td>{{$client->client_dob}}</td> 
                    <td>{{$client->email}}</td> 
                    <td>Australian Education, Insurance Service</td> 
                    <td>{{ $client->users->first_name.' '.$client->users->last_name }}</td> 
                    <td>{{ $client->office_info->office_name }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
     </div>
 </div>

@endsection

@section('script')
<!-- Datatables init -->

<script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
 
@endsection