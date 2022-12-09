@extends('backend.layouts.app')
@section('css')
 <link rel="stylesheet" href="//unpkg.com/bootstrap-select-country@4.0.0/dist/css/bootstrap-select-country.min.css" type="text/css" />
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
     

        <div class="card"> 
            <div class="card-body"> 
                <h5 class="media-heading mt-0 mb-0">Academic Requirements</h5>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <p class="text-dark">Subject Area</p>
                        <div class="text-mute">Business and Management</div> 
                    </div>
                    <div class="col-md-4">
                        <p class="text-dark">Subject</p>
                        <div class="text-mute">MBA</div> 
                    </div> 
                    <div class="col-md-4">
                        <p class="text-dark">Degree Level</p>
                        <div class="text-mute">Master</div> 
                    </div> 
                </div>
            </div>
        </div>  
    </div>
</div>

 

@endsection

@section('script')
<!-- Datatables init --> 
 <script src="//unpkg.com/bootstrap-select-country@4.0.0/dist/js/bootstrap-select-country.min.js"></script> 
 <script src="{{ asset('assets/js/jquery.multifield.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('[data-toggle="select2"]').select2();
        $('.countrypicker').countrypicker();  
        $('#wrapperfee').multifield({
            section: '.morefeecol',
            btnAdd:'.addmorefee',
            btnRemove:'.btnRemove'
        });
    });
</script>
@endsection