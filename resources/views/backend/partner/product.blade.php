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

            <div class="col-md-12">
                <div class="card">
                    <div class="card-body widget-user">
                        <div class="mb-4 text-end">
                            <a class="btn btn-primary" href="{{ route('backend.partner-product-add', ['id'=> $partner->id]) }}"><i class="mdi mdi-plus"></i> Add Product</a>
                        </div>

                        @if(Session::has('success'))
                            <div class="alert alert-success" style="text-align: center;">
                                {{ Session::get('success') }}
                            </div>
                        @endif

                        <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                            <thead>
                                <tr>
                                    <th> Product Name </th>
                                    <th> Sync </th>
                                    <th> Branches</th>
                                    <th> In Progress </th>
                                    <th> Action </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td>
                                        <a href="#" class="text-wrap">{{ $product->name }}</a>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary rounded-pill">Auto Synced</span>
                                    </td>
                                    <td>{{ $product->partnerBranches->name }}</td>
                                    <td>{{ $product->in_progress }}</td>
                                    <td>
                                        <a href="{{ url('/admin/editproduct') }}/{{ $product['id'] }}" class="btn btn-sm btn-primary waves-effect waves-light"><i class="mdi mdi-square-edit-outline"></i></a>
                                        <a href="{{ url('/admin/deleteproduct') }}/{{ $product['id'] }}" id="delete" class="btn btn-sm btn-danger waves-effect waves-light"><i class="mdi mdi-trash-can-outline"></i></a>
                                    </td>
                                </tr>
                                @endforeach
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
<script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>

<script>
    //delete sweetalert
    $(document).on('click', '#delete', function(e) {
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