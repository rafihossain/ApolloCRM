@extends('backend.layouts.app')
@section('css')
 <link rel="stylesheet" href="//unpkg.com/bootstrap-select-country@4.0.0/dist/css/bootstrap-select-country.min.css" type="text/css" />
@endsection
@section('content')
<h4 class="mt-0 header-title text-end">
    <a href="{{ url('/product') }}" class="btn btn-primary">  Product List </a>
</h4>
<?php
$installment = ['Per Year','Per Month','Per Term','Per Trimester','Per Semester','Per Week','Installment'];
?>
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
            
            @foreach($newprices as $prices)
            <?php
                $nationality = '';
                foreach($countrys as $coun){
                 if (in_array($coun['id'], $prices['nationality'])){
                $nationality .= $coun['countryname'].',';
                 }
                }
                if($nationality == ''){
                  $nationality = 'All Country';  
                }else{
                 $nationality = rtrim($nationality, ', ');  
                }
            ?>
          
                <div class="float-end">
                    <a href="{{ url('/') }}/admin/product/deletefees/{{ $prices['id'] }}" class="text-danger">
                        <i class="mdi mdi-delete-outline mdi-18px"></i>
                    </a>  
                    <a href="javascript:void(0)" priceid="{{ $prices['id'] }}" onClick="showModal('addcontact{{ $prices["id"] }}')">
                        <i class="mdi mdi-square-edit-outline mdi-18px"></i>
                    </a>    
                </div>
                <h5 class="media-heading mt-0 mb-0">{{ $prices['name'] }}</h5>
                <div class="row mt-3">
                    <div class="col-md-3">
                        <div class="text-mute">Valid For</div>
                        <p class="text-dark">{{ $nationality  }}</p>
                        <div class="text-mute">Installment Type</div>
                        <div class="text-dark">{{ $installment[$prices['fee_term_id']]  }}</div> 
                    </div>
                   <div class="col-md-7">
                         <div class="text-mute">Fee Breakdown</div>
                         <?php $allFees = $prices['allFees']; ?>
                         @foreach($allFees as $fees)
                       <div class="row">
                        <div class="col-md-4">
                          <p class="text-dark">{{ $fees->fleestype->name }}</p> 
                        </div>
                        <div class="col-md-6">
                        <div class="text-mute">1 Per Semester {{  $fees->amount_total }}</div> 
                        </div>
                        <div class="col-md-2"> 
                            <p class="text-dark">ALL {{  $fees->amount_total }}</p> 
                        </div>    
                       </div>
                    @endforeach  
                   </div>
                    <div class="col-md-2"> 
                        <div class="text-mute">Total Fees</div> 
                        <h3 class="text-primary">AUD {{ $prices['totals'] }}</h3> 
                    </div>
                </div>
            <hr>
            <div id="addcontact{{ $prices['id'] }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addcontact-modalLabel" aria-hidden="true">
              </div>
            @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Standard modal content -->
<div id="addcontact" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addcontact-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="POST" action="{{ url('/') }}/admin/product/productfees/{{ $product['id'] }}" >
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title" id="addcontact-modalLabel">Add New Fee Option</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                     <div class="row">
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Fee Option Name</label>
                            <input type="text" class="form-control" name="fees_name">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Country of Residency</label>
                            <select class="form-control" name="country_name[]" data-toggle="select2" multiple data-width="100%" >
                                
                                @foreach($countrys as $country)
                                 <option value="{{ $country['id'] }}" >{{ $country['countryname'] }}</option>
                              @endforeach
                                </select> 
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Installment Type</label>
                            <select class="form-control" name="installment"  data-toggle="select2" data-width="100%" placeholder="Choose Fee Type">
                                    <?php $i= 1; ?>
                                    @foreach($installment as $in)
                                    <option value="{{ $i }}">{{ $in }}</option>
                                     <?php $i++; ?>
                                    @endforeach
                            </select>

                        </div>
                        <div class="col-md-12 mb-2" >
                              
                            <div class="table-responsive">
                                <table class="table align-baseline">
                                   <tbody  id="wrapperfees">
                                        <tr class="w-100">
                                           <td>
                                               <button type="button" class="btn btn-sm btn-outline-primary addmorefees">+ Add  Fee</button>
                                           </td>
                                       </tr>
                                       <tr class="morefeecols" id="myItem01">
                                         <td>
                                            <div class="mb-2">
                                            <label class="form-label">Fee Type</label>
                                            <select class="form-control" name="fee_type_id[]"  placeholder="Choose Fee Type">
                                                @foreach ($feetypes as $feetype)
                                              <option value="{{ $feetype['id'] }}" >{{ $feetype['name'] }}</option>
                                                @endforeach
                                         </select>
                                        </div>
                                           </td>

                                           <td>
                                                <div class="mb-2">
                                                    <label class="form-label">Per Month Amount</label>
                                                    <input type="number" placeholder="0.00" class="form-control per_month_amount" name="amount[]">
                                                </div>
                                           </td>
                                           <td>
                                               <div class="mb-2">
                                                    <label class="form-label">Installments</label>
                                                    <input type="number"placeholder="0" class="form-control installments"  name="installments[]">
                                                </div>
                                           </td>
                                           <td>
                                                <div class="mb-2">
                                                    <label class="form-label">Total Fee</label>
                                                     <input type="number" class="form-control amount_total" placeholder="0.00" name="amount_total[]">
                                                </div>
                                           </td>
                                           <td>
                                                <div class="mb-2">
                                                <label class="form-label">IClaimable Terms</label>
                                                 <input type="number" class="form-control client_revenue_type" placeholder="0" name="client_revenue_type[]">
                                            </div>
                                           </td>
                                                <td>
                                                <div class="mb-2">
                                                <label class="form-label">Commission %</label>
                                                 <input type="float" class="form-control commission_percentage" placeholder="0.00" name="commission_percentage[]">
                                            </div>
                                           </td>
                                           <td>
                                               <div class="mb-2">
                                                   <label class="form-label">Add in quotation</label>
                                                <input type="hidden" class="form-control show_in_quotation_input" name="show_in_quotation[]" value="0">
                                                   <input type="checkbox" class="show_in_quotation_check"  >
                                               </div>
                                           </td>
                                           <td>
                                               <button class="btn btn-sm btn-outline-danger btnRemove">
                                                   <i class="mdi mdi-delete-outline  "></i>
                                               </button>
                                           </td>
                                       </tr> 
                                      
                                   </tbody>
                                   <tfoot>
                                       <tr>
                                           <td></td>
                                           <td></td>
                                           <td>Net Total</td>
                                           <td class="text-primary"><span class="grand_total">0</span></td>
                                           <td></td>
                                           <td></td>
                                       </tr>
                                   </tfoot>
                                </table>
                              
                            </div>

                        </div> 
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
 <script src="//unpkg.com/bootstrap-select-country@4.0.0/dist/js/bootstrap-select-country.min.js"></script> 
 <script src="{{ asset('assets/js/jquery.multifield.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
         $('[data-toggle="select2"]').select2({
            dropdownParent: $('#addcontact')
        });
        //$('[data-toggle="select2"]').select2();
        $('.countrypicker').countrypicker();  
        $('#wrapperfees').multifield({
            section: '.morefeecols',
            btnAdd:'.addmorefees',
            btnRemove:'.btnRemove'
        });
        
        $( "#wrapperfees" ).delegate( ".installments,.per_month_amount", "change", function() {
        var parenId =  $(this).parents('.morefeecols').attr('id');
        callaMemberFunction(parenId);
        });
        $( "#wrapperfees" ).delegate( ".show_in_quotation_check", "change", function() {
        var parenId =  $(this).parents('.morefeecols').attr('id');
            if($(this).prop("checked") == true){
                $('#'+parenId).find(".show_in_quotation_input").val(1);   alert("Checkbox is checked.");
            }
            else if($(this).prop("checked") == false){
                $('#'+parenId).find(".show_in_quotation_input").val(0);   alert("Checkbox is unchecked.");
            }
        });
        
        
        
        
    });
    
    function showModal(mid){
        var newids = mid.replace('addcontact', "");
        //console.log(newids);
    $.ajax({
        type: 'GET', //THIS NEEDS TO BE GET
        url: '{{ url("/")}}/admin/product/editfees/'+newids,
        dataType:'html',
        success: function (data) {
            $("#"+mid).html('');
            $("#"+mid).append(data); //// For Append
            $('#'+mid).modal('show'); //// For replace with previous one
        },
        error: function() { 
             console.log(data);
        }
    });
        
        
        
       // 
    }
    
    function callaMemberFunction(parenId){
        var installments =  $('#'+parenId).find(".installments").val();
        if(installments == undefined || installments == null || installments == 0){
        installments =  1;
        }
        
        var per_month_amount =  $('#'+parenId).find(".per_month_amount").val();
        if(per_month_amount == undefined || per_month_amount == null ){
        per_month_amount =  0;
        }
        var totalAmount = parseInt(installments * per_month_amount);
        
        $('#'+parenId).find(".amount_total").val(totalAmount);
        var grand_total = 0.00;
        $('.amount_total').each(function(){
            let val = $(this).val();
            grand_total += parseInt(val);
        })
        $('.grand_total').html(grand_total)
        
       
    }
    
</script>
@endsection