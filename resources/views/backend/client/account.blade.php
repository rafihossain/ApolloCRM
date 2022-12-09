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
        <div class="row mb-3">
            <div class="col-md-8"></div>
            <div class="col-md-4">
                <select class="form-control">
                    <option>Create Invoice</option>
                    <option value="1"> Commission Invoice </option>
                    <option value="2">  General Invoice </option>
                </select>
            </div> 
        </div>
        
  <div class="card">
    <div class="card-body">  
        <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
            <thead>
                <tr>               
                    <th>Invoice No.</th>
                    <th>Issue Date </th>
                    <th>Service</th>
                    <th>Invoice Amount</th>
                    <th>Discount Given</th>
                    <th>Income Shared </th>
                    <th>Status</th> 
                    <th>Actions</th> 
                </tr>
            </thead>  
            <tbody>
               
            </tbody>
        </table>
    </div>
</div>
      
       
        
    </div>
</div>

 
@endsection

@section('script')
<!-- Datatables init --> 
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