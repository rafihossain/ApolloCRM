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

<h4 class="mt-0 header-title text-end">
	<a href="{{ route('backend.add-product') }}" class="btn btn-primary">Add Product</a>
</h4>
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
                                    <th>Name</th>
                                    <th>Sync</th>
                                    <th>Associated Partner</th>
                                    <th>Product Type</th>
                                    <th>Enrolled</th>
                                    <th>In Progress</th>
                                    <th>Branches</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td>
                                        <a href="{{ url('/admin/product/applications') }}/{{ $product['id'] }}">{{ $product['name'] }}</a>
                                    </td>
                                    <td>{{ '-' }}</td>
                                    <td> 
                                        <a href="{{ route('backend.partner-profile-application',['id' => $product['partner']['id'] ]) }}">{{ $product['partner']['name'] }}</a> 
                                    </td>
                                    <td>
                                        {{ $product['product_type']['product_type'] }}
                                    </td>
                                    <td>{{ $product['enrolled'] }}</td>
                                    <td>{{ $product['in_progress'] }}</td>
                                    <td>
                                        @isset($product['partner_branch']['name'])
                                            {{ $product['partner_branch']['name'] }}
                                        @endisset
                                    </td>
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
        </div> <!-- end row -->
    </div>
</div>
@endsection

@section('script')
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