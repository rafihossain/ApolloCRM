@extends('backend.layouts.app')
@section('content')
<style>
.first_div {
    position: relative;
}
.first_div a {
    position: absolute;
    top: -7px;
    right: -12px;
}
#add_product_info td input,#add_product_info textarea.form-control{
    min-height: 120px;
    border: none;
}
.first_div p ,.first_div h5{
    margin: 0;
    font-size:12px;
}
</style>
<div class="card">
    <div class="card-body"> 
        <form method="POST" action="{{ route('backend.client-profile-quotations-addsubmit', [$client->id]) }}">
            @csrf
        <div class="row mb-2">
            <div class="col-md-4 mb-2">
                <label class="form-label">Template Name</label>
                <input type="text" class="form-control" name="template_name">
            </div>
            <div class="col-md-4 mb-2">
                <label class="form-label">Office</label>
                <select class="form-control select11" name="office"  data-width="100%"> 
                    <option> Please select offices</option>
                    <option value="1"> Head Office </option>
                </select>
            </div>
            <div class="col-md-4 mb-2 parentselect2">
                <label class="form-label">Quote Currency</label>
                <select class="form-control select12" name="quote_currency" data-width="100%"> 
                    <option> Select currency </option>
                    <option value="1"> Afghanistan - AFN [afghani] </option>
                    <option value="2"> Åland Islands - EUR [euro] </option>
                    <option value="3">  Albania - ALL [lek] </option>
                    <option value="4"> Algeria - DZD [Algerian dinar]</option>
                    <option value="5"> American Samoa - USD [US dollar]</option>
                    <option value="6">  Andorra - EUR [euro]</option>
                    <option value="7">  Angola - AOA [kwanza] </option>
                    <option value="8"> Anguilla - XCD [East Caribbean dollar] </option>
                    <option value="9"> Antigua and Barbuda - XCD [East Caribbean dollar]</option>
                    <option value="10">Argentina - ARS [Argentine peso]</option>
                    <option value="11">Armenia - AMD [dram (inv.)]</option>
                    <option value="12">Aruba - AWG [Aruban guilder]</option>
                    <option value="13">Australia - AUD [Australian dollar]</option>
                    <option value="14">Austria - EUR [euro]</option>
                    <option value="15">Azerbaijan - AZN [Azerbaijani manat]</option>
                    <option value="16">Bahamas - BSD [Bahamian dollar]</option>
                </select>
            </div>
        </div>
        <p>Product List (0/10)</p>
        <div class="table-responsive">
            <table class="table table-bordered nowrap">
                <thead>
                    <tr>                 
                        <th>S.N.</th>
                        <th>Product Info</th>
                        <th>Description</th>
                        <th> Service Fee</th>
                        <th>Discount</th>
                        <th>Net Fee</th>
                        <th>Exg. Rate</th>
                        <th>Total Amt. <small>(in None)</small></th> 
                    </tr>
                </thead>
                 <tbody id="add_product_info">
                    
                     
                </tbody>
            </table>
        </div>
        <div class="ovverflow-hidden">
           <a href="javascript:;" id="modaladdcontact">+ Add New Line</a>
        <small class="float-end">(Service Fee - Discount = NetFee) x Exg. Rate = Total Amount</small> 
        </div>
        <div class="text-end text-dark mt-4">Grand Total Fees (in None)</div>
        <div class="text-end">
            <input type="hidden" id="grand_total" name="grand_total" value="0">
            <span id="grand_total_span">0.00</span>
            </div>
        <div class="text-end mt-4">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
        </form>
    </div>
</div>
 
<!-- Standard modal content -->
<!-- Standard modal content -->
<div id="addcontact" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addcontact-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addcontact-modalLabel">Add Product</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="modalbody" class="modal-body">
                   
                    <div class="mb-2">
                        <label class="form-label">Workflow </label>
                        <select name="workflow_id" id="getWorkflow" class="form-control" data-toggle="select2" data-width="100%">
                            <option value="">Please select a workflow</option>
                            @foreach($workflowCategories as $workflow)
                            <option value="{{ $workflow->id }}">{{ $workflow->service_workflow }}</option>
                            @endforeach
                        </select>
                         <span class="text-danger" id="workflowError"></span>
                    </div>
                    <div class="mb-2">
                         <label class="form-label">Select Partner</label>
                        <select name="partner_id" id="getPatner" class="form-control" data-toggle="select2" data-width="100%">
                            <option value="">Please select a partner</option>
                        </select>
                    </div>
                    <div class="mb-2">
                         <label class="form-label">Select Product</label>
                        <select name="product_id" id="product_id" class="form-control" data-toggle="select2" data-width="100%">
                            <option value="">Please select a product</option>
                        </select>
                    </div> 
                    <div class="mb-2">
                         <label class="form-label">Select Branch</label>
                        <select name="branch_id" class="form-control" id="branchInfo" data-toggle="select2" data-width="100%">
                            <option value="">Please select a branch</option>
                        </select>
                    </div> 
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="submit_btn" data-bs-dismiss="modal" class="btn btn-primary">Add</button>
                </div>
          
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
 
@endsection

@section('script')
<!-- Datatables init -->
 <script type="text/javascript">
    $(document).ready(function() {
        $('#modaladdcontact').on('click',function(){
            $('#modalbodyinput').remove();
            $('#modalbodyinputparent').remove();
            $("#addcontact").modal('show');
        });
        $('#submit_btn').on('click',function(){
        if($('#modalbodyinput').length == 0){
        
        var appendDiv =  $('.appendDiv').length;
        if(appendDiv > 0){
        $('.appendDiv').each(function() {
        appendDiv = $(this).attr('attr');
        });
        }
        appendDiv = parseInt(appendDiv) + 1;     
        
        var workflow_id = $('#getWorkflow').val();
        var partner_id = $('#getPatner').val();
        var product_id = $('#product_id').val();
        var branch_id = $('#branchInfo').val();
        //console.log(getWorkflow,getProduct,getBranch,branchInfo);   
         $.ajax({
                url: "{{ route('backend.client-profile-quotations-createhtml') }}",
                 type: 'POST',
                data: {
                    "workflow_id": workflow_id,"partner_id":partner_id,"product_id":product_id,"branch_id":branch_id,"appendDiv":appendDiv
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(data) {  
                    $('#add_product_info').append(data);
                    
                    //console.log(data);
                }
            });
        }else{
        var workflow_id = $('#getWorkflow').val();
        var partner_id = $('#getPatner').val();
        var product_id = $('#product_id').val();
        var branch_id = $('#branchInfo').val();
        var parentId = $('#modalbodyinputparent').val();
        console.log(parentId);
        var appendDiv = parentId.replace("first_div","");
        //console.log(getWorkflow,getProduct,getBranch,branchInfo);   
         $.ajax({
                url: "{{ route('backend.client-profile-quotations-editoption') }}",
                 type: 'POST',
                data: {
                    "workflow_id": workflow_id,"partner_id":partner_id,"product_id":product_id,"branch_id":branch_id,"appendDiv":appendDiv
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(data) {  
                    $('#parentId').append(data);
                }
            });    
        
        }
         })
        
       $("table").delegate( ".editDiv", "click", function() {
            var parentId =  $(this).parents('.first_div').attr('id');
            //console.log(parentId);
            var workflow_id = $(this).attr('workflow_id');
            var partner_id = $(this).attr('partner_id');
            var product_id = $(this).attr('product_id');
            var branch_id = $(this).attr('branch_id');
            $('#addcontact-modalLabel').html('Edit Product');
             console.log($('#modalbodyinput').length);
            if($('#modalbodyinput').length == 0){
            
            $('#modalbody').append('<input type="hidden" id="modalbodyinput" value="edit">')
            $('#modalbody').append('<input type="hidden" id="modalbodyinputparent" value="'+parentId+'">')
               console.log($('#modalbodyinput').length);
            }
            $.ajax({
                url: "{{ route('backend.client-profile-quotations-option') }}",
                 type: 'POST',
                data: {
                    "workflow_id": workflow_id,"partner_id":partner_id,"product_id":product_id,"branch_id":branch_id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(data) {
                    $('#getWorkflow').val(workflow_id);
                    $('#getPatner').append(data['partner']);
                    $('#product_id').append(data['product']);
                    $('#branchInfo').append(data['branch']);
                    $("#addcontact").modal('show');
                }
            });
       });
        
           $( "table" ).delegate( ".removeDiv", "click", function() {
            var attr =  $(this).attr('attr');
            $('#appendDiv'+attr).remove();
 
       });
        
        
        $('#getWorkflow').on("change", function() {
            var workflowId = $(this).val();
            $('#getPatner').html(' <option value="">Please select a patner</option>');
            $('#product_id').html('<option value="">Please select a product</option>');
            $('#branchInfo').html('<option value="">Please select a branch</option>');
            $.ajax({
                url: "{{ route('backend.service_workflow') }}",
                data: {
                    'workflow_id': workflowId
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(data) {
                    
                     if (data != undefined && data != null) {
                        var optionValue = '';
                        for (var i = 0; i < data.length; i++) {
                            optionValue += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                        }
                        $('#getPatner').append(optionValue);
                    }
                }
            });
        });
        
        $('#getPatner').on("change", function() {
            var partnerId = $(this).val();
            $.ajax({
                url: "{{ route('backend.product_info') }}",
                data: {
                    'partner_id': partnerId
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(data) { 
                   if (data != undefined && data != null) {
                        var optionValue = '';
                        for (var i = 0; i < data.length; i++) {
                            optionValue += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                        }
                        $('#product_id').append(optionValue);
                    }
                }
            });
        });
        
        $('#product_id').on("change", function() {
            var productId = $(this).val();
            $.ajax({
                url: "{{ route('backend.partner_branch') }}",
                data: {
                    'product_id': productId
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(data) {
                    if (data != undefined && data != null) {
                        var optionValue = '';
                        for (var i = 0; i < data.length; i++) {
                            optionValue += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                        }
                        $('#branchInfo').append(optionValue);
                    }
                }
            });
        });

        
        $('.select2').select2({
             dropdownParent: $('#addcontact')
        }); 
        $('.select11').select2(); 
        $('.select12').select2(); 
       $("table").delegate( ".service_fee,.discount,.net_fee,.egx_rte", "change", function() {
            var parentId =  $(this).parents('.appendDiv').attr('id');
            console.log(parentId);
            callMyFunction(parentId)  
       })
    });
    
    function callMyFunction(parentId){
        var service_fee = parseFloat($('#'+parentId).find('.service_fee').val());
        var discount = parseFloat($('#'+parentId).find('.discount').val());
        var egx_rte = parseFloat($('#'+parentId).find('.egx_rte').val());
        egx_rte = (egx_rte == 0 ? 1: egx_rte);
    
        var net_feeAmmount = (service_fee - discount);
        var totalAmmount = (net_feeAmmount * egx_rte);
        
        $('#'+parentId).find('.net_fee').val(net_feeAmmount)
        $('#'+parentId).find('.total_ammount').val(totalAmmount)
        
        var grandAmmount = 0;
        $('.total_ammount').each(function(){
            grandAmmount += parseInt($(this).val())
        })
        console.log(grandAmmount);
        $('#grand_total').val(grandAmmount);
        $('#grand_total_span').html(grandAmmount);
        //$('#'+parentId+' > .').val();
      //  var  = $('#'+parentId+' > .discount').val();,.total_ammount
       // var net_fee = $('#'+parentId+' > .net_fee').val();
       // var egx_rte = $('#'+parentId+' > .').val();
        //console.log(service_fee,discount,net_fee,egx_rte);
        
        
    }
    
</script>
@endsection