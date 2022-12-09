@extends('backend.layouts.app')
@section('css')
 
@endsection
@section('content')
<h4 class="mt-0 header-title text-end">
    <a href="{{ url('/product') }}" class="btn btn-primary">  Product List </a>
</h4>

<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body"> 
               @include('backend.product.product_side_nav')
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-body"> 
                @include('backend.product.product_nav')
            </div>
        </div>
        <div class="text-end mb-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addcontact">+ Add</button>
        </div>  

        <div class="card">
            <div class="card-body">
                <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                    <thead>
                        <tr>  
                            <th> File Name </th>
                            <th> Added By </th> 
                            <th> File Size</th>
                            <th> Added Date </th> 
                            <th> Action </th>
                        </tr>
                    </thead>  
                    <tbody> 
                    @foreach ($docs as $doc)
                    <tr>
                            <td>
                                <a href="{{ url('/') }}/assets/upload/product_doc/{{ $doc['file_name'] }}" class="text-wrap">{{ $doc['file_name'] }}</a>
                            </td>
                            <td>
                                <a href="#">{{ $doc['alluser']['first_name'] }} {{ $doc['alluser']['last_name'] }}</a>
                            </td>
                            <td>{{ $doc['file_size'] / 1000 }} KB</td>
                            <td> {{ date('d-m-Y', strtotime($doc['created_at'])) }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-success">
                                    <i class="mdi mdi-eye-outline"></i>
                                </a>
                                <a href="{{ url('/') }}/admin/product/productdocdelete/{{ $doc['id'] }}" class="btn btn-sm btn-danger">
                                    <i class="mdi mdi-delete-outline"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                        
                        
                        
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Standard modal content -->
<div id="addcontact" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addcontact-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ url('/') }}/admin/product/productdoc/{{ $product['id'] }}" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title" id="addcontact-modalLabel">Selected Documents</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                     
                    <div class="mb-2">
                        @csrf
                        <label class="form-label">Description</label>
                        <input type="file" class="dropify" name="product_doc">
                    </div> 
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection

@section('script')
<!-- Datatables init --> 
<script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.dropify').dropify();
    });
</script>
@endsection