@extends('backend.layouts.app')
@section('css')
 <style>
 .newdiv {
    margin-bottom: 10px;
    text-align: right;
}
 </style>
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
    <div class="newdiv">
        <a href="{{ route('backend.client-profile-quotations-add',['id'=> $client->id ]) }}"  class="btn btn-primary">add</a>
    </div>
        <table  class="table table-bordered dt-responsive table-responsive nowrap yajra-datatable">
            <thead>
                <tr>                                                                  
                    <th>No</th>
                    <th>Status</th>
                    <th>Products</th>
                    <th>Total Fee </th>
                    <th>Due Date  </th>
                    <th>Created On</th>
                    <th>Created By</th> 
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
 <script type="text/javascript">
  $(function () {
    
    var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('backend.client-profile-quotationslist',['id'=> $client->id ]) }}",
        columns: [
            //{data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'id', name: 'id'},
            {data: 'status', name: 'status'},
            {data: 'product_item', name: 'product_item'},
            {data: 'total_fee', name: 'total_fee'},
            {data: 'due_date', name: 'due_date'},
            {data: 'due_date', name: 'due_date'},
            {data: 'created_at', name: 'created_at'},
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
        ]
    });
    
  });
</script>
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