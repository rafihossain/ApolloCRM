@extends('backend.layouts.app')
@section('content')
<h4 class="mt-0 header-title text-end">
    <a href="{{ route('backend.manage-partner') }}" class="btn btn-primary"> Partners List </a>
</h4>

<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                @include('backend.partner.include.partner-sidebar')
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-body">
                @include('backend.partner.include.partner-header')
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body widget-user">
                        <div class="text-center">
                            <h2 class="fw-normal text-primary" data-plugin="counterup">6599</h2>
                            <h5>Statistics</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body widget-user">
                        <div class="text-center">
                            <h2 class="fw-normal text-pink" data-plugin="counterup">1525</h2>
                            <h5>COMPLETED</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body widget-user">
                        <div class="text-center">
                            <h2 class="fw-normal text-warning" data-plugin="counterup">8567</h2>
                            <h5>DISCONTINUED</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body widget-user">
                        <div class="text-center">
                            <h2 class="fw-normal text-info" data-plugin="counterup">5540</h2>
                            <h5>ENROLLED</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body widget-user">
                        <h4 class="header-title mt-0 mb-3">YEARLY OVERVIEW 2022</h4>
                        <div class="chartjs-chart">
                            <canvas id="lineChart" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body widget-user">
                        <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>Client Name</th>
                                    <th>Assignee</th>
                                    <th> Product Name </th>
                                    <th>Workflow</th>
                                    <th> Current Stage</th>
                                    <th>Status</th>
                                    <th>Added On</th>
                                    <th>Last Updated </th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

@endsection

@section('script')
<!-- Datatables init -->
<!-- Widgets demo js-->
<script src="{{ asset('assets/libs/waypoints/lib/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('assets/libs/jquery.counterup/jquery.counterup.min.js') }}"></script>

<!-- Chart JS -->
<script src="{{ asset('assets/libs/chart.js/Chart.bundle.min.js') }}"></script>

<!-- Init js -->
<script src="{{ asset('assets/js/pages/chartjs.init.js') }}"></script>

<script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>

<script>
    //delete sweetalert
    $(document).on('click', '#partner-delete', function(e) {
        e.preventDefault();
        var Id = $(this).attr('href');

        swal({
                title: "Are you sure?",
                text: "You want to delete!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    swal("Successfully deleted!", {
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