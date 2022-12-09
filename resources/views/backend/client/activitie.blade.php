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
        
        <div class="overflow-hidden list_activity_item">
            <div class="float-start me-2">
                <img src="{{ asset('assets/images/users/user-3.jpg') }}" alt="user-img" title="Mat Helme" class="rounded-circle avatar-sm">
            </div>
            <div class="card">
                <i class="mdi mdi-triangle list_activity_item_arrow"></i>
                <div class="card-body">
                    <div class="d-flex mb-2">
                        <div>
                            <strong>Meem Tasfia </strong> updated an application
                        </div>
                        <div class="ms-auto">
                            07 Sep 2022, 02:50 PM
                        </div>
                    </div>
                    <div>
                        <strong> Bachelor of Nursing</strong>  
                    </div>
                    <div>Murdoch University</div>
                </div>
            </div>
        </div>
        <div class="overflow-hidden list_activity_item">
            <div class="float-start me-2">
                <img src="{{ asset('assets/images/users/user-1.jpg') }}" alt="user-img" title="Mat Helme" class="rounded-circle avatar-sm">
            </div>
            <div class="card">
                <i class="mdi mdi-triangle list_activity_item_arrow"></i>
                <div class="card-body">
                    <div class="d-flex mb-2">
                        <div>
                            <strong>Meem Tasfia </strong> updated an application
                        </div>
                        <div class="ms-auto">
                            07 Sep 2022, 02:50 PM
                        </div>
                    </div>
                    <div>
                        <strong> Bachelor of Nursing</strong>  
                    </div>
                    <div>Murdoch University</div>
                </div>
            </div>
        </div>
        <div class="overflow-hidden list_activity_item">
            <div class="float-start me-2">
                <img src="{{ asset('assets/images/users/user-2.jpg') }}" alt="user-img" title="Mat Helme" class="rounded-circle avatar-sm">
            </div>
            <div class="card">
                <i class="mdi mdi-triangle list_activity_item_arrow"></i>
                <div class="card-body">
                    <div class="d-flex mb-2">
                        <div>
                            <strong>Meem Tasfia </strong> updated an application
                        </div>
                        <div class="ms-auto">
                            07 Sep 2022, 02:50 PM
                        </div>
                    </div>
                    <div>
                        <strong> Bachelor of Nursing</strong>  
                    </div>
                    <div>Murdoch University</div>
                </div>
            </div>
        </div>

        
    </div>
</div>

 
@endsection

@section('script')
<script>
 $(document).ready(function() {
    $('#example').DataTable({
        dom: 'Blfrtip',
        ajax: {
          url: "../data/stateRestoreLoad.php",
          dataSrc: 'data'
        },
        deferRender:    true,
        scrollY:        200,
        scrollCollapse: true,
        buttons:[
            'createState',
            {
                extend: 'savedStates',
                config: {
                    ajax: '../data/stateRestoreSave.php'
                }
            }
        ]
    });
});

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