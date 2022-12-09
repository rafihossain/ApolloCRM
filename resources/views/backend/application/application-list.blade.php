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

        <div class="row">
            <div class="col-12">
                <div class="text-end">
                    <!-- <a class="btn btn-primary" href=""><i class="mdi mdi-plus"></i> Add Application</a> -->
                </div>
                @if(Session::has('success'))
                <div class="alert alert-success" style="text-align: center;">
                    {{ Session::get('success') }}
                </div>
                @endif
                <div class="card">
                    <div class="card-body table-responsive">
                        <table id="datatable" class="table table-bordered table-bordered dt-responsive nowrap">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>APPLICATION ID</th>
                                    <th>CLIENT NAME</th>
                                    <th>APPLIED INTAKE DATE</th>
                                    <th>CLIENT PHONE</th>
                                    <th>CLIENT ASSIGNEE</th>
                                    <th>APPLICATION ASSIGNEES</th>
                                    <th>PRODUCT</th>
                                    <th>PARTNER</th>
                                    <th>PARTNER BRANCH</th>
                                    <th>PARTNER'S CLIENT ID</th>
                                    <th>WORKFLOW</th>
                                    <th>STAGE</th>
                                    <th>APPLICATION START BY</th>
                                    <th>APPLICATION START BY BRANCH</th>
                                    <th>STATUS</th>
                                    <th>STAGE IN QUEUE</th>
                                    <th>CREATED AT</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($applications))
                                    @foreach($applications as $application)
                                    <tr>
                                        <td>{{ $application->id }}</td>
                                        <td>
                                            <a href="{{ url('/') }}/admin/client/activitie/{{ $application->client_id }}">{{ $application->full_clientname }}</a>
                                            <br>
                                            <a href="#"></a>
                                        </td>
                                        <td>{{ '-' }}</td>
                                        <td>{{ $application->client_phone }}</td>
                                        <td>
                                            <a href="">{{ $application->full_username }}</a>
                                            <br>
                                            {{ $application->office_name }}
                                        </td>
                                        <td>{{ '-' }}</td>
                                        <td>{{ $application->product_name }}</td>
                                        <td>{{ $application->partner_name }}</td>
                                        <td>{{ $application->office_name }}</td>
                                        <td>{{ '-' }}</td>
                                        <td>{{ $application->workflow }}</td>
                                        <td>{{ '-' }}</td>
                                        <td>{{ '-' }}</td>
                                        <td>{{ $application->office_name }}</td>
                                        <td>
                                            @if($application->status == 1)
                                                {{ 'In Progress' }}
                                            @elseif($application->status == 2)
                                                {{ 'Completed' }}
                                            @else
                                                {{ 'Not Apply' }}
                                            @endif
                                        </td>
                                        <td>{{ '-' }}</td>
                                        <td>{{ $application->created_at }}</td>
                                        <td>
                                            <a href="" class="btn btn-sm btn-primary waves-effect waves-light"><i class="mdi mdi-square-edit-outline"></i></a>
                                            <a href="" id="delete" class="btn btn-sm btn-danger waves-effect waves-light"><i class="mdi mdi-trash-can-outline"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    
                                    
                                    @php
                                        echo 'No result found';
                                    @endphp
                                    
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- end row -->
    </div>
</div>

@endsection

@section('script')
    <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
@endsection