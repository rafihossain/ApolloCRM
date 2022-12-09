@extends('backend.layouts.app')
@section('content')

<div class="card">
    <div class="card-body">
        <h4 class="m-0 header-title text-end float-end">
            <a href="{{ url('/admin/client/add') }}" class="btn btn-primary">+ Add</a>
        </h4>
        <ul class="nav nav-tabs nav-bordered border-0">
            <li class="nav-item">
                <a href="{{ url('/admin/client/prospects') }}" class="nav-link active">
                    Prospects
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/admin/client/clients') }}" class="nav-link ">
                    Clients
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('/admin/client/archived') }}" class="nav-link">
                    Archived
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
                    <th>Name</th>
                    <th>Added From</th>
                    <th>Tag(s)</th>
                    <th>Rating</th>
                    <th>Internal Id</th>
                    <th>Client Id</th>
                    <th>Followers</th>
                    <th>Phone</th>
                    <th>Passport Number</th>
                    <th>Passport </th>
                    <th>Current City</th>
                    <th>Assignee</th>
                    <th>Added On</th>
                    <th>Last Updated</th>
                    <th>Preferred Intake</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clients as $client)
                <tr>
                    <td>
                        <div class="overflow-hidden">
                            <div class="float-start me-2">
                                <img src="{{ url('/') }}/{{$client->client_image }}" alt="user-img" title="Mat Helme" class="rounded-circle img-thumbnail avatar-md">
                            </div>
                            <div>
                                <div class="text-truncate">
                                    <a href="{{ url('/') }}/admin/client/activitie/{{ $client->id }}">
                                        {{$client->first_name }}
                                    </a>
                                </div>
                                <div class="text-truncate">
                                    <a href="mailto:{{ $client->email }}"> {{ $client->email }}</a>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>system</td>
                    <td>
                        @isset($client->tag_info->name)
                            {{ $client->tag_info->name }}
                        @endisset
                    </td>
                    <td>-</td>
                    <td>{{ $client->id }}</td>
                    <td>{{ $client->client_id }}</td>
                    <td>
                        <div><a href="{{route('backend.usersdetails', ['id'=>$client->user_info->id] )}}">{{ $client->user_info->first_name.' '.$client->user_info->last_name }}</a></div>
                        <small>{{ $client->office->office_name }}</small>
                    </td>
                    <td>{{ $client->phone }}</td>
                    <td>{{ $client->passport_number }}</td>
                    <td>{{ $client->country->countryname }}</td>
                    <td>
                        <span class="fs-4">{{ $client->city }}</span>
                        <br>
                        <p>{{ $client->country->countryname }}</p>
                    </td>
                    <td>
                        <div><a href="{{route('backend.usersdetails', ['id'=>$client->user_info->id] )}}">{{ $client->user_info->first_name.' '.$client->user_info->last_name }}</a></div>
                        <small>{{ $client->office->office_name }}</small>
                    </td>
                    <td>{{ $client->created_at }}</td>
                    <td></td>
                    <td>{{ $client->preferred_intake }}</td>
                    <td>
                        <a href="#" class="btn btn-sm btn-success">
                            <i class="mdi mdi-email-send-outline"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-info">
                            <i class="mdi mdi-comment-processing-outline"></i>
                        </a>
                        <a href="{{ route('backend.edit-client',['id'=> $client->id]) }}" class="btn btn-sm btn-primary">
                            <i class="mdi mdi-square-edit-outline"></i>
                        </a>
                        <a href="{{ route('backend.delete-client',['id'=> $client->id]) }}" id="delete" class="btn btn-sm btn-danger">
                            <i class="mdi mdi-delete-outline"></i>
                        </a>
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
    //archived sweetalert
    $(document).on('click', '#delete', function(e) {
        e.preventDefault();
        var Id = $(this).attr('href');

        swal({
                title: "Are you sure?",
                text: "You want to Archived!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    swal("Successfully Archived!", {
                        icon: "success",
                    });

                    window.location.href = Id;

                } else {
                    swal("Archived not completed!");
                }

            });
    });
</script>
@endsection