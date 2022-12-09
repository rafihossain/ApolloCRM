@extends('backend.layouts.app')

@section('content')
<div class="row"> 
    <div class="col-md-4 col-sm-3">
        <div class="card">
            <div class="card-body">  
                <h4 class="header-title mt-0 mb-4">Earnings</h4> 
                <div class="widget-chart-1">
                    <div class="  float-start " dir="ltr">
                       <div class="btn btn-soft-primary waves-effect waves-light fs-40">
                           <i class="mdi mdi-cash-multiple"></i>
                       </div>
                    </div>

                    <div class="widget-detail-1 text-end">
                        <h2 class="fw-normal pt-2 mb-1"> $256.00 </h2>
                        <p class="text-muted mb-1">Total Earnings</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end col -->
    <div class="col-md-4 col-sm-3">
        <div class="card">
            <div class="card-body">  
                <h4 class="header-title mt-0 mb-4">Customers</h4> 
                <div class="widget-chart-1">
                    <div class="  float-start " dir="ltr">
                       <div class="btn btn-soft-success waves-effect waves-light fs-40">
                           <i class="mdi mdi-account-group-outline"></i>
                       </div>
                    </div>

                    <div class="widget-detail-1 text-end">
                        <h2 class="fw-normal pt-2 mb-1"> 340 </h2>
                        <p class="text-muted mb-1">Total Customers</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end col -->
    <div class="col-md-4 col-sm-3">
        <div class="card">
            <div class="card-body">  
                <h4 class="header-title mt-0 mb-4">Ads</h4> 
                <div class="widget-chart-1">
                    <div class="  float-start " dir="ltr">
                       <div class="btn btn-soft-info waves-effect waves-light fs-40">
                           <i class="mdi mdi-cash-multiple"></i>
                       </div>
                    </div> 
                    <div class="widget-detail-1 text-end">
                        <h2 class="fw-normal pt-2 mb-1"> 541 </h2>
                        <p class="text-muted mb-1">Total Ads</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end col -->
    <div class="col-md-4 col-sm-3">
        <div class="card">
            <div class="card-body">  
                <h4 class="header-title mt-0 mb-4">Pending</h4> 
                <div class="widget-chart-1">
                    <div class="  float-start " dir="ltr">
                       <div class="btn btn-soft-warning waves-effect waves-light fs-40">
                           <i class="mdi mdi-cash-multiple"></i>
                       </div>
                    </div>

                    <div class="widget-detail-1 text-end">
                        <h2 class="fw-normal pt-2 mb-1"> 223 </h2>
                        <p class="text-muted mb-1">Pending Ads</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end col -->
    <div class="col-md-4 col-sm-3">
        <div class="card">
            <div class="card-body">  
                <h4 class="header-title mt-0 mb-4">Active</h4> 
                <div class="widget-chart-1">
                    <div class="  float-start " dir="ltr">
                       <div class="btn btn-soft-pink waves-effect waves-light fs-40">
                           <i class="mdi mdi-cash-multiple"></i>
                       </div>
                    </div>

                    <div class="widget-detail-1 text-end">
                        <h2 class="fw-normal pt-2 mb-1"> 321</h2>
                        <p class="text-muted mb-1">Active Ads</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end col -->
    <div class="col-md-4 col-sm-3">
        <div class="card">
            <div class="card-body">  
                <h4 class="header-title mt-0 mb-4">Featured</h4> 
                <div class="widget-chart-1">
                    <div class="  float-start " dir="ltr">
                       <div class="btn btn-soft-danger waves-effect waves-light fs-40">
                           <i class="mdi mdi-cash-multiple"></i>
                       </div>
                    </div>

                    <div class="widget-detail-1 text-end">
                        <h2 class="fw-normal pt-2 mb-1"> 43 </h2>
                        <p class="text-muted mb-1">Featured Ads</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end col -->
    <div class="col-md-12 col-sm-12">
        <div class="card">
            <div class="card-body">  
                <h4 class="header-title mt-0 mb-4">Statistics</h4> 
                <div id="morris-bar-example" dir="ltr" style="height: 280px;" class="morris-chart"></div>
            </div>
        </div>
    </div>
    <!-- end col --> 
    <div class="col-md-12 col-sm-12">
        <div class="card">
            <div class="card-body">  
                <h4 class="header-title mt-0 mb-4">Popular ads</h4> 
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                        <tr>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Published Date</th>
                            <th>Expire Date</th>
                            <th>Views</th> 
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><img src="{{ asset('assets/images/users/user-4.jpg') }}" alt="image" class="img-fluid avatar-md rounded"></td>
                                <td>Iphon 11 Pro v1</td>
                                <td>01/01/2022</td>
                                <td>26/04/2022</td> 
                                <td><span class="badge bg-success"><i class="mdi mdi-eye-outline"></i> 1230</span></td>
                            </tr>
                            <tr>
                                <td><img src="{{ asset('assets/images/users/user-1.jpg') }}" alt="image" class="img-fluid avatar-md rounded"></td>
                                <td>Xaiom  v1</td>
                                <td>01/01/2022</td>
                                <td>26/04/2022</td> 
                                <td><span class="badge bg-success"><i class="mdi mdi-eye-outline"></i> 1230</span></td>
                            </tr>
                            <tr>
                                <td><img src="{{ asset('assets/images/users/user-3.jpg') }}" alt="image" class="img-fluid avatar-md rounded"></td>
                                <td>realme  Pro  </td>
                                <td>01/01/2022</td>
                                <td>26/04/2022</td> 
                                <td><span class="badge bg-success"><i class="mdi mdi-eye-outline"></i> 1230</span></td>
                            </tr>
                             <tr>
                                <td><img src="{{ asset('assets/images/users/user-5.jpg') }}" alt="image" class="img-fluid avatar-md rounded"></td>
                                <td>Xaiom  v1</td>
                                <td>01/01/2022</td>
                                <td>26/04/2022</td> 
                                <td><span class="badge bg-success"><i class="mdi mdi-eye-outline"></i> 1230</span></td>
                            </tr>
                            <tr>
                                <td><img src="{{ asset('assets/images/users/user-6.jpg') }}" alt="image" class="img-fluid avatar-md rounded"></td>
                                <td>realme  Pro  </td>
                                <td>01/01/2022</td>
                                <td>26/04/2022</td> 
                                <td><span class="badge bg-success"><i class="mdi mdi-eye-outline"></i> 1230</span></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- end col -->
 

</div>
<!-- end row -->
@endsection