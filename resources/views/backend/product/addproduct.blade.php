@extends('backend.layouts.app')
@section('css')

@section('content')
<h4 class="mt-0 header-title ">
	Add New Product
</h4>
<form class="pb-4" method="POST" action="{{ route('backend.submitproduct') }}">
	<div class="card">
		<div class="card-body"> 
			<h4 class="header-title">Product Details</h4>
			 @csrf
             <div class="mb-2">
                 <label class="form-label">Name</label>
                 <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <strong class="text-danger">{{ $message }}</strong>
                @enderror
             </div>	 
			 <div class="row">
                <div class="col-md-4">
                    <div class="mb-2">
             
                        <label class="form-label">Partner</label>
                        <select class="form-control"  name="partner" id="partner_id" data-toggle="select2" data-width="100%">
                            <option>Select a Partner</option> 
                            @foreach ($patners as $partner)
                                <option value="{{ $partner['id'] }}"> {{ $partner['name'] }}</option>
                            @endforeach
                            
                        </select>
                        @error('partner')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>  
                </div>
                <div class="col-md-4">
                    <div class="mb-2">
                        <label class="form-label">Branches</label>
                        <select class="form-control" data-toggle="select2" id="branche" name="branche" data-width="100%">
                            <option>Select  Branche</option>  
                        </select>
                    </div>  
                </div>
                <div class="col-md-4">
                    <div class="mb-2">
                        <label class="form-label">Product Type</label>
                        <select class="form-control" data-toggle="select2" name="product_type" data-width="100%">
                            <option>Select Product Type</option>  
                                 @foreach ($producttypes as $producttype)
                                <option value="{{ $producttype['id'] }}"> {{ $producttype['product_type'] }}</option>
                            @endforeach
                        </select>
                        @error('branche')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>  
                </div> 
                <div class="col-md-4">
                    <div class="mb-2">
                        <label class="form-label">Revenue Type</label>
                        <select class="form-control"  name="revenue_type" >
                        <option selected value="1"> Revenue from Client </option>  
                        <option value="2">Commission from Partner</option>
                        </select>
                        @error('product_type')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
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
                    <input type="text" name="duration" class="form-control">
                    <p><small>e.g: 1 year 2 months 6 weeks</small></p>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Intake Month</label>
                    <select class="form-control" name="intake_month" data-toggle="select2" data-width="100%">
                        <option>Select Intake Month</option>  
                        <option value="1">January</option>  
                        <option value="2">February</option>  
                        <option value="3">March</option>  
                        <option value="4">April</option>
                        <option value="5">May</option>  
                        <option value="6">June</option>  
                        <option value="7">July</option>  
                        <option value="8">August</option>
                        <option value="9">September</option>  
                        <option value="10">October</option>  
                        <option value="11">November</option>  
                        <option value="12">December</option>  
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Description</label>
                    <!--<div  id="summereditor"></div>-->
                      <textarea class="summernote" name="description"></textarea>
                      
                       <!--<textarea id="textfield4" name="description" ></textarea>-->
                      
                </div>
                <div class="col-md-6">
                    <label class="form-label">Note</label>
                    <textarea class="form-control" name="note"></textarea>
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
