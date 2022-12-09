@extends('backend.layouts.app')
@section('content')
<h4 class="mt-0 header-title text-end mb-2">
    <a href="{{ route('backend.agent-add') }}" class="btn btn-primary">Add Agent</a>
</h4>
<div class="card">
    <div class="card-body">
        <ul class="nav nav-tabs nav-bordered border-0">
            <li class="nav-item">
                <a href="{{ route('backend.agent-active-list') }}" class="nav-link active">
                    Active
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('backend.agent-inactive-list') }}" class="nav-link">
                    Inactive
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
        <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Structure</th>
                    <th>Phone</th>
                    <th>City</th>
                    <th>Associated Office</th>
                    <th>Clients Count </th>
                    <th>Applications Count </th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($agents as $agent)
                <tr>
                    <td>
                        @if($agent->agent_structure == 1)
                        <div class="overflow-hidden">
                            <div class="float-start me-2">
                                <img src="{{ asset($agent->profile_image) }}" alt="user-img" title="Mat Helme" class="rounded-circle img-thumbnail avatar-md">
                            </div>
                            <div>
                                <div class="text-truncate">
                                    <a href="{{ url('/partner/applications') }}">
                                        {{ $agent->full_name }}
                                    </a>
                                </div>
                                <div class="text-truncate">
                                    <a href="#">{{ $agent->email }}</a>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="overflow-hidden">
                            <div class="float-start me-2">
                                <img src="{{ asset($agent->profile_image) }}" alt="user-img" title="Mat Helme" class="rounded-circle img-thumbnail avatar-md">
                            </div>
                            <div>
                                <div class="text-truncate">
                                    <a href="{{ url('/partner/applications') }}">
                                        {{ $agent->business_name }}
                                    </a>
                                </div>
                                <div class="text-truncate">
                                    <a href="#">{{ $agent->email }}</a>
                                </div>
                            </div>
                        </div>
                        @endif
                    </td>
                    <td>
                        @if($agent->super_agent == 1 && $agent->sub_agent == 1)
                            {{'Super Agent','Sub Agent'}}
                        @elseif($agent->super_agent == 1)
                            {{'Super Agent'}}
                        @elseif($agent->sub_agent == 1)
                            {{'Sub Agent'}}
                        @endif
                    </td>
                    <td>
                        @if($agent->agent_structure == 1)
                            {{'Individual'}}
                        @elseif($agent->agent_structure == 2)
                            {{'Business'}}
                        @endif
                    </td>
                    <td>{{$agent->phone_number}}</td>
                    <td>{{$agent->city}}</td>
                    <td>{{$agent->office->office_name}}</td>
                    <td>0</td>
                    <td>3</td>
                    <td>
                        <a href="{{ route('backend.agent-edit', ['id' => $agent->id]) }}" class="btn btn-sm btn-primary">
                            <i class="mdi mdi-square-edit-outline"></i>
                        </a>
                        <a href="" class="btn btn-sm btn-info">
                            <i class="mdi mdi-forum-outline"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-success">
                            <i class="mdi mdi-email-outline"></i>
                        </a>
                        @if($agent->status == 1)
                            <a href="{{ route('backend.agent-inactive', ['id' => $agent->id]) }}" id="inactive" class="btn btn-sm btn-danger">
                                <i class="mdi mdi-account-cancel-outline"></i>
                            </a>
                        @else
                            <a href="{{ route('backend.agent-active', ['id' => $agent->id]) }}" id="active" class="btn btn-sm btn-success">
                                <i class="mdi mdi-account-cancel-outline"></i>
                            </a>
                        @endif
                    </td>
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

<script>
    //inactive sweetalert
    $(document).on('click', '#inactive', function(e) {
        e.preventDefault();
        var Id = $(this).attr('href');
        swal({
                title: "Are you sure?",
                text: "You want to inactive!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    swal("Successfully inactive!", {
                        icon: "success",
                    });
                    window.location.href = Id;
                } else {
                    swal("safe!");
                }
            });
    });

    //active sweetalert
    $(document).on('click', '#active', function(e) {
        e.preventDefault();
        var Id = $(this).attr('href');
        swal({
                title: "Are you sure?",
                text: "You want to active!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    swal("Successfully active!", {
                        icon: "success",
                    });
                    window.location.href = Id;
                } else {
                    swal("safe!");
                }
            });
    });
</script>

@endsection