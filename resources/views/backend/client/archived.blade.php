@extends('backend.layouts.app')
@section('content')

<div class="card">
    <div class="card-body">
        <h4 class="m-0 header-title text-end float-end">
            <a href="{{ url('/admin/client/add') }}" class="btn btn-primary">+ Add</a>
        </h4>
        <ul class="nav nav-tabs nav-bordered border-0">
            <li class="nav-item">
                <a href="{{ url('/admin/client/prospects') }}" class="nav-link ">
                    Prospects
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/admin/client/clients') }}" class="nav-link ">
                    Clients
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/admin/client/archived') }}" class="nav-link active">
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
                    <th>Current City</th>
                    <th>Passport</th>
                    <th>Assignee</th>
                    <th>Archived By</th>
                    <th>Archived On</th>
                    <th>Added On</th>
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
                    <td>NEW LEAD</td>
                    <td>-</td>
                    <td>-</td>
                    <td>
                        <div><a href="{{route('backend.usersdetails', ['id'=>$client->user_info->id] )}}">{{ $client->user_info->first_name.' '.$client->user_info->last_name }}</a></div>
                        <small>{{ $client->office->office_name }}</small>
                    </td>
                    <td>
                        <div><a href="{{route('backend.usersdetails', ['id'=>$client->user_info->id] )}}">{{ $client->user_info->first_name.' '.$client->user_info->last_name }}</a></div>
                        <small>{{ $client->office->office_name }}</small>
                    </td>

                    <td>2022-09-07 {{ $client->updated_at }}</td>
                    <td>2022-09-07 {{ $client->created_at }}</td>
                    <td>
                        <a href="{{ route('backend.restore-client',['id'=> $client->id]) }}" id="client-restore" class="btn btn-sm btn-primary">
                            <i class="mdi mdi-redo-variant"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-danger">
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
    //restore sweetalert
    $(document).on('click', '#client-restore', function(e) {
        e.preventDefault();
        var Id = $(this).attr('href');
        swal({
                title: "Are you sure?",
                text: "You want to restore this client!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    swal("Successfully restore!", {
                        icon: "success",
                    });
                    window.location.href = Id;
                } else {
                    swal("Restore not completed!");
                }
            });
    });
</script>
@endsection