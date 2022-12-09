@extends('backend.layouts.app')
@section('css')

@section('content')
<h4 class="mt-0 header-title ">
	Add New Product
</h4>
@if(Session::has('success'))
<div class="alert alert-success" style="text-align: center;">
{{ Session::get('success') }}
</div>
@endif
<form class="pb-4" method="POST" action="{{ url('/') }}/admin/editproduct/{{ $product['id'] }}">
	<div class="card">
		<div class="card-body"> 
			<h4 class="header-title">Product Details</h4>
			 @csrf
             <div class="mb-2">
                 <label class="form-label">Name</label>
                 <input type="text" class="form-control" name="name" value="{{ $product['name'] }}">
             </div>	 
			 <div class="row">
                <div class="col-md-4">
                    <div class="mb-2">
             
                        <label class="form-label">Partner</label>
                        <select class="form-control"  name="partner" id="partner_id" data-toggle="select2" data-width="100%">
                            <option>Select a Partner</option> 
                            @foreach ($patners as $patner)
                                <option value="{{ $patner['id'] }}" <?php if($product['partner']['id'] == $patner['id']){echo 'selected';}  ?> > {{ $patner['name'] }}</option>
                            @endforeach
                            
                        </select>
                    </div>  
                </div>
                <div class="col-md-4">
                    <div class="mb-2">
                        <label class="form-label">Branches</label>
                        <select class="form-control" data-toggle="select2" id="branche" name="branche" data-width="100%">
                            <option value="{{ $product['partner_branch']['id'] }}">{{ $product['partner_branch']['name'] }}</option>  
                            
                        </select>
                    </div>  
                </div>
                <div class="col-md-4">
                    <div class="mb-2">
                        <label class="form-label">Product Type</label>
                        <select class="form-control" data-toggle="select2" name="product_type" data-width="100%">
                            <option>Select Product Type</option>  
                                 @foreach ($producttypes as $producttype)
                                <option value="{{ $producttype['id'] }}" <?php if($producttype['id'] == $product['product_type']['id'] ){echo 'selected';} ?> > {{ $producttype['product_type'] }}</option>
                            @endforeach
                        </select>
                    </div>  
                </div> 
                <div class="col-md-4">
                    <div class="mb-2">
                        <label class="form-label">Revenue Type</label>
                        <select class="form-control"  name="revenue_type" >
                        <option <?php if($product['enrolled'] == 1){echo 'selected';} ?>  value="1"> Revenue from Client </option>  
                        <option <?php if($product['enrolled'] == 2){echo 'selected';} ?> value="2">Commission from Partner</option>
                        </select>
                    </div>  
                </div>  
             </div>
			 
		</div>
	</div>
    
    <div class="card">
        <div class="card-body">
            <h4 class="header-title">Product Information</h4>
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label">Duration</label>
                    <input type="text" name="duration" class="form-control" value="{{ $product['duration'] }}">
                    <p><small>e.g: 1 year 2 months 6 weeks</small></p>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Intake Month</label>
                    <select class="form-control" name="intake_month" data-toggle="select2" data-width="100%">
                        <option>Select Intake Month</option>  
                        <option <?php if($product['enrolled'] == 1){echo 'selected';} ?> value="1">January</option>  
                        <option <?php if($product['enrolled'] == 2){echo 'selected';} ?> value="2">February</option>  
                        <option <?php if($product['enrolled'] == 3){echo 'selected';} ?> value="3">March</option>  
                        <option <?php if($product['enrolled'] == 4){echo 'selected';} ?> value="4">April</option>
                        <option <?php if($product['enrolled'] == 5){echo 'selected';} ?> value="5">May</option>  
                        <option <?php if($product['enrolled'] == 6){echo 'selected';} ?> value="6">June</option>  
                        <option <?php if($product['enrolled'] == 7){echo 'selected';} ?> value="7">July</option>  
                        <option <?php if($product['enrolled'] == 8){echo 'selected';} ?> value="8">August</option>
                        <option <?php if($product['enrolled'] == 9){echo 'selected';} ?> value="9">September</option>  
                        <option <?php if($product['enrolled'] == 10){echo 'selected';} ?> value="10">October</option>  
                        <option <?php if($product['enrolled'] == 11){echo 'selected';} ?> value="11">November</option>  
                        <option <?php if($product['enrolled'] == 12){echo 'selected';} ?> value="12">December</option>  
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Description</label>
                    <textarea class="summernote" name="description">{{ $product['description'] }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Note</label>
                    <textarea class="form-control" name="note">{{ $product['note'] }}</textarea>
                </div>
            </div>
        </div>
    </div>
 
 
    <button type="submit" class="btn btn-primary"> Save  </button>
</form>

 
@endsection
@section('script')
<!-- Datatables init -->

<script src="//unpkg.com/bootstrap-select-country@4.0.0/dist/js/bootstrap-select-country.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.18/js/intlTelInput.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#partner_id').on('change',function(){
        var val =  $(this).val();
        $.ajax(
        {
            type:'GET',
            url:'{{ url('/') }}/admin/getbranch/'+val,
            success: function(data){
                $('#branche').html(data)
                //alert('successful');
            }   
        });
        })

        
        $('[data-toggle="select2"]').select2(); 
        $('.summernote').summernote({
    callbacks: {
    onChange: function(contents, $editable) {
      console.log('onChange:', contents, $editable);
     // $("#textfield4").val(contents); //populate text area
    }
    } 
    });
    }); 
</script>
@endsection
