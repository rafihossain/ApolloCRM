@extends('backend.layouts.app')
@section('css')
 
@endsection
@section('content')
 <h4 class="mt-0 header-title text-end">
    <a href="{{ url('/client') }}" class="btn btn-primary">  Client List </a>
</h4>

<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body"> 
                @include('backend.client.include.client-sidebar')
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-body"> 
                @include('backend.client.include.client-header')
            </div>
        </div> 

        <div class="card">
            <div class="card-body">
                <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap w-100">
                    <thead>         
                        <tr>                         
                            <th>Id</th>
                            <th>Date</th>
                            <th>Start</th> 
                            <th>End</th> 
                            <th>Session Time</th> 
                            <th>Visit Purpose</th>  
                            <th>Assignee</th>  
                            <th>Status</th>  
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

<!-- Standard modal content -->

 
 
@endsection

@section('script')
 <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
 
 <script>
     //archived sweetalert
    $(document).on('click', '#client-delete', function(e) {
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