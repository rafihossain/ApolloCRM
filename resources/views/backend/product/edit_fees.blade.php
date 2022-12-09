<?php
$installment = ['Per Year','Per Month','Per Term','Per Trimester','Per Semester','Per Week','Installment'];
?>
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="POST" action="{{ url('/') }}/admin/product/productfeesupdate/{{ $newprices['id'] }}" >
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title" id="addcontact-modalLabel">Add New Fee Option</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                     <div class="row">
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Fee Option Name</label>
                            <input type="text" class="form-control" name="fees_name" value="{{ $newprices['name'] }}">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Country of Residency</label>
                            <select class="form-control" name="country_name[]" data-toggle="select2" multiple data-width="100%" >
                                 @foreach($countrys as $country)
                                 <?php $notsec = ''; if (in_array($country['id'], $newprices['nationality'])){ $notsec = 'selected';} ?>
                                   <option value="{{ $country['id'] }}" {{ $notsec }}>{{ $country['countryname'] }}</option>
                                @endforeach
                                </select> 
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Installment Type</label>
                            <select class="form-control" name="installment" data-width="100%" placeholder="Choose Fee Type">
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
                                   <tbody  id="wrapperfee">
                                        <tr class="w-100">
                                           <td>
                                               <button type="button" class="btn btn-sm btn-outline-primary addmorefee">+ Add  Fee</button>
                                           </td>
                                       </tr>
                                        <?php $n= 1; ?>
                                       @foreach($newprices['allFees'] as $allFee)
                                       <tr class="morefeecol" id="editItem{{$n}}">
                                         <td>
                                            <div class="mb-2">
                                            <label class="form-label">Fee Type</label>
                                            <input type="hidden" name="id[]" value="{{ $allFee['id'] }}" >
                                            <select class="form-control" name="fee_type_id[]"  placeholder="Choose Fee Type">
                                                @foreach ($feetypes as $feetype)
                                                <?php $feetsec = ''; if ($feetype['id'] == $allFee['fee_type_id'] ){ $feetsec = 'selected';} ?>

                                                
                                              <option value="{{ $feetype['id'] }}" {{ $feetsec }}>{{ $feetype['name'] }}</option>
                                                @endforeach
                                         </select>
                                        </div>
                                           </td>

                                           <td>
                                                <div class="mb-2">
                                                    <label class="form-label">Per Month Amount</label>
                                                    <input type="number" placeholder="0.00" value="{{ $allFee['amount'] }}" class="form-control per_month_amount" name="amount[]">
                                                </div>
                                           </td>
                                           <td>
                                               <div class="mb-2">
                                                    <label class="form-label">Installments</label>
                                                    <input type="number"placeholder="0"  value="{{ $allFee['installments'] }}" class="form-control installments"  name="installments[]">
                                                </div>
                                           </td>
                                           <td>
                                                <div class="mb-2">
                                                    <label class="form-label">Total Fee</label>
                                                     <input type="number" class="form-control amount_total" value="{{ $allFee['amount_total'] }}" placeholder="0.00" name="amount_total[]">
                                                </div>
                                           </td>
                                           <td>
                                                <div class="mb-2">
                                                <label class="form-label">IClaimable Terms</label>
                                                 <input type="number" class="form-control client_revenue_type" value="{{ $allFee['client_revenue_type'] }}" placeholder="0" name="client_revenue_type[]">
                                            </div>
                                           </td>
                                                <td>
                                                <div class="mb-2">
                                                <label class="form-label">Commission %</label>
                                                 <input type="float" class="form-control commission_percentage" value="{{ $allFee['commission_percentage'] }}" placeholder="0.00" name="commission_percentage[]">
                                            </div>
                                           </td>
                                           <td>
                                               <div class="mb-2">
                                                   <label class="form-label">Add in quotation</label>
                                                   
                                            <input type="hidden" class="form-control show_in_quotation_input" name="show_in_quotation[]" value="{{ $allFee['show_in_quotation']}}">
                                              <input type="checkbox" class="show_in_quotation_check" <?php if($allFee['show_in_quotation'] == 1){ echo 'checked';}   ?> >
                                               </div>
                                           </td>
                                           <td>
                                               <button class="btn btn-sm btn-outline-danger btnRemove">
                                                   <i class="mdi mdi-delete-outline  "></i>
                                               </button>
                                           </td>
                                       </tr> 
                                        <?php $n++; ?>
                                       @endforeach
                                       
                                       
                                      
                                   </tbody>
                                   <tfoot>
                                       <tr>
                                           <td></td>
                                           <td></td>
                                           <td>Net Total</td>
                                           <td class="text-primary"><span id="grand_total">{{ $newprices['totals'] }}</span></td>
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



<script type="text/javascript">
    $(document).ready(function() {
        // $('[data-toggle="select2"]').select2({
        //     dropdownParent: $('#addcontact')
        // });
        $('[data-toggle="select2"]').select2();
        $('#wrapperfee').multifield({
            section: '.morefeecol',
            btnAdd:'.addmorefee',
            btnRemove:'.btnRemove'
        });
        
        $( "#wrapperfee" ).delegate( ".installments,.per_month_amount", "change", function() {
        var parenId =  $(this).parents('.morefeecol').attr('id');
        callaMemberFunction(parenId);
        });
        $( "#wrapperfee" ).delegate( ".show_in_quotation_check", "change", function() {
        var parenId =  $(this).parents('.morefeecol').attr('id');;
            if($(this).prop("checked") == true){
                $('#'+parenId).find(".show_in_quotation_input").val(1);   //alert("Checkbox is checked.");
            }
            else if($(this).prop("checked") == false){
                $('#'+parenId).find(".show_in_quotation_input").val(0);   //alert("Checkbox is unchecked.");
            }
        });
    });
    
    
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
        $('#wrapperfee').find('.amount_total').each(function(){
            let val = $(this).val();
            grand_total += parseInt(val);
        })
        $('#grand_total').html(grand_total)
    }
    
</script>
