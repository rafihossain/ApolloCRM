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
                <a href="{{ route('backend.branch-details',['id'=>$office->id]) }}" class="nav-link active">
                    Users List
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('backend.branch-clients',['id'=>$office->id]) }}" class="nav-link ">
                    Clients List
                </a>
            </li>
        </ul>

        <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td><a href="{{route('backend.usersdetails',$user->id)}}">{{ $user->first_name.' '.$user->last_name }}</a></td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role->name }}</td>
                    <td>Active</td>
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