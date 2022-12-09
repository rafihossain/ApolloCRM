@extends('backend.layouts.app')
@section('content')
<link href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
<style>
    .first_div {
        position: relative;
    }

    .first_div a {
        position: absolute;
        top: -7px;
        right: -12px;
    }

    #add_product_info td input,
    #add_product_info textarea.form-control {
        min-height: 120px;
        border: none;
    }

    .first_div p,
    .first_div h5 {
        margin: 0;
        font-size: 12px;
    }
</style>

<div class="card">
    <div class="card-body"> 
        <div class="float-start">
            <h4>Edit Quotation</h4>
        </div>
        <h4 class="m-0 header-title text-end float-end">
            <a href="{{ route('backend.quotations-active-list') }}" class="btn btn-primary">Back to list</a>
        </h4>
    </div>
</div>

@if(Session::has('success'))
<div class="alert alert-danger">
	{{ Session::get('success') }}
</div>
@endif

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('backend.quotations-template-submit') }}">
            @csrf
            <input type="hidden" name="id" value="{{ $quotation->id }}">
            <input type="hidden" name="client_id" value="{{ $client->id }}">
            
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <div class="card">
                            <div class="card-header">
                                <h5>Client Details</h5>
                            </div>
                            <div class="card-body">
                                <p>{{ $client->first_name .' '.$client->first_name }}</p>
                                <p>{{ $client->city }}</p>
                                <p>{{ $client->email }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row justify-content-end">
                            <div class="col-md-4">
                                <div class="mb-2">
                                    <label class="form-label">Due Date <span class="text-danger">*</span></label>
                                    <input type="text" id="datetime-datepicker" class="form-control" placeholder="Date and Time" name="due_date" value="{{ $quotation->due_date }}">
                                    @error('due_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-2 parentselect2">
                                    <label class="form-label">Quotation Currency <span class="text-danger">*</span></label>
                                    <select class="form-control select12" name="quote_currency" data-width="100%">
                                        <option value="">Select currency </option>
                                        <option value="1" {{ ($quotation->quote_currency == 1? 'selected':'') }}> Afghanistan - AFN [afghani] </option>
                                        <option value="2" {{ ($quotation->quote_currency == 2? 'selected':'') }}> Åland Islands - EUR [euro] </option>
                                        <option value="3" {{ ($quotation->quote_currency == 3? 'selected':'') }}> Albania - ALL [lek] </option>
                                        <option value="4" {{ ($quotation->quote_currency == 4? 'selected':'') }}> Algeria - DZD [Algerian dinar]</option>
                                        <option value="5" {{ ($quotation->quote_currency == 5? 'selected':'') }}> American Samoa - USD [US dollar]</option>
                                        <option value="6" {{ ($quotation->quote_currency == 6? 'selected':'') }}> Andorra - EUR [euro]</option>
                                        <option value="7" {{ ($quotation->quote_currency == 7? 'selected':'') }}> Angola - AOA [kwanza] </option>
                                        <option value="8" {{ ($quotation->quote_currency == 8? 'selected':'') }}> Anguilla - XCD [East Caribbean dollar] </option>
                                        <option value="9" {{ ($quotation->quote_currency == 9? 'selected':'') }}> Antigua and Barbuda - XCD [East Caribbean dollar]</option>
                                        <option value="10" {{ ($quotation->quote_currency == 10? 'selected':'') }}>Argentina - ARS [Argentine peso]</option>
                                        <option value="11" {{ ($quotation->quote_currency == 11? 'selected':'') }}>Armenia - AMD [dram (inv.)]</option>
                                        <option value="12" {{ ($quotation->quote_currency == 12? 'selected':'') }}>Aruba - AWG [Aruban guilder]</option>
                                        <option value="13" {{ ($quotation->quote_currency == 13? 'selected':'') }}>Australia - AUD [Australian dollar]</option>
                                        <option value="14" {{ ($quotation->quote_currency == 14? 'selected':'') }}>Austria - EUR [euro]</option>
                                        <option value="15" {{ ($quotation->quote_currency == 15? 'selected':'') }}>Azerbaijan - AZN [Azerbaijani manat]</option>
                                        <option value="16" {{ ($quotation->quote_currency == 16? 'selected':'') }}>Bahamas - BSD [Bahamian dollar]</option>
                                    </select>
                                    @error('quote_currency')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

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
                        @php($i = 1)
                        @foreach($quotation->quotation_product as $product)
                        <tr id="appendDiv{{ $product->id }}" class="appendDiv" attr="{{ $product->id }}">
                            <td>{{ $i++ }}</td>
                            <td>{!! $product->newhtml !!}</td>
                            <td>
                                <div class="input-group mb-2"> <textarea class="form-control" name="description[]" rows="3">{{ $product->description }}</textarea>
                            </td>
                            <td>
                                <div class="input-group mb-2"><input type="text" class="form-control service_fee" name="service_fee[]" value="{{ $product->service_fee }}">
                            </td>
                            <td>
                                <div class="input-group mb-2"><input type="text" class="form-control discount" name="discount[]" value="{{ $product->discount }}">
                            </td>
                            <td>
                                <div class="input-group mb-2"><input type="text" class="form-control net_fee" name="net_fee[]" value="{{ $product->net_fee }}">
                            </td>
                            <td>
                                <div class="input-group mb-2"><input type="text" class="form-control egx_rte" name="egx_rte[]" value="{{ $product->egx_rte }}">
                            </td>
                            <td>
                                <div class="input-group mb-2"><input type="text" class="form-control total_ammount" name="total_ammount[]" value="{{ $product->total_ammount }}">
                            </td>
                            <td>
                                <a attr="{{ $product->id }}" class="removeDiv" href="javascript:void(0)"><i class="mdi mdi-trash-can-outline"></i></a>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <div class="ovverflow-hidden">
                <a href="javascript:;" id="modaladdcontact">+ Add New Line</a>
                <small class="float-end">(Service Fee - Discount = NetFee) x Exg. Rate = Total Amount</small>
            </div>
            <div class="text-end text-dark mt-4">Grand Total Fees (in None)</div>
            <div class="text-end">
                <input type="hidden" id="grand_total" name="grand_total" value="{{ $quotation->total_fee }}">
                <span id="grand_total_span">{{ $quotation->total_fee }}</span>
            </div>
            <div class="text-end mt-4">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>

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
                    <label class="form-label">Workflow <span class="text-danger">*</span></label>
                    <select name="workflow_id" id="getWorkflow" class="form-control" data-toggle="select2" data-width="100%">
                        <option value="">Please select a workflow</option>
                        @foreach($workflowCategories as $workflow)
                        <option value="{{ $workflow->id }}">{{ $workflow->service_workflow }}</option>
                        @endforeach
                    </select>
                    <span class="text-danger" id="workflowError"></span>
                </div>
                <div class="mb-2">
                    <label class="form-label">Select Partner <span class="text-danger">*</span></label>
                    <select name="partner_id" id="getPatner" class="form-control" data-toggle="select2" data-width="100%">
                        <option value="">Please select a partner</option>
                    </select>
                    <span class="text-danger" id="partnerError"></span>
                </div>
                <div class="mb-2">
                    <label class="form-label">Select Product <span class="text-danger">*</span></label>
                    <select name="product_id" id="product_id" class="form-control" data-toggle="select2" data-width="100%">
                        <option value="">Please select a product</option>
                    </select>
                    <span class="text-danger" id="productError"></span>
                </div>
                <div class="mb-2">
                    <label class="form-label">Select Branch <span class="text-danger">*</span></label>
                    <select name="branch_id" class="form-control" id="branchInfo" data-toggle="select2" data-width="100%">
                        <option value="">Please select a branch</option>
                    </select>
                    <span class="text-danger" id="branchError"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="button" id="submit_btn" class="btn btn-primary">Add</button>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection

@section('script')
<!-- Datatables init -->
<script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#modaladdcontact').on('click', function() {
            $('#modalbodyinput').remove();
            $('#modalbodyinputparent').remove();
            $("#addcontact").modal('show');
        });
        $('#submit_btn').on('click', function() {
            if ($('#modalbodyinput').length == 0) {

                var appendDiv = $('.appendDiv').length;
                if (appendDiv > 0) {
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
                        "workflow_id": workflow_id,
                        "partner_id": partner_id,
                        "product_id": product_id,
                        "branch_id": branch_id,
                        "appendDiv": appendDiv
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#add_product_info').append(data);
                        $("#addcontact").modal('hide');
                    },
                    error: function(response) {
                        $('#workflowError').text(response.responseJSON.errors.workflow_id);
                        $('#partnerError').text(response.responseJSON.errors.partner_id);
                        $('#productError').text(response.responseJSON.errors.product_id);
                        $('#branchError').text(response.responseJSON.errors.branch_id);
                    }
                });
            } else {
                var workflow_id = $('#getWorkflow').val();
                var partner_id = $('#getPatner').val();
                var product_id = $('#product_id').val();
                var branch_id = $('#branchInfo').val();
                var parentId = $('#modalbodyinputparent').val();
                console.log(parentId);
                var appendDiv = parentId.replace("first_div", "");
                //console.log(getWorkflow,getProduct,getBranch,branchInfo);   
                $.ajax({
                    url: "{{ route('backend.client-profile-quotations-editoption') }}",
                    type: 'POST',
                    data: {
                        "workflow_id": workflow_id,
                        "partner_id": partner_id,
                        "product_id": product_id,
                        "branch_id": branch_id,
                        "appendDiv": appendDiv
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'html',
                    success: function(data) {
                        $('#parentId').append(data);
                        $("#addcontact").modal('hide');
                    },
                    error: function(response) {
                        $('#workflowError').text(response.responseJSON.errors.workflow_id);
                        $('#partnerError').text(response.responseJSON.errors.partner_id);
                        $('#productError').text(response.responseJSON.errors.product_id);
                        $('#branchError').text(response.responseJSON.errors.branch_id);
                    }
                });

            }
        });
        $("table").delegate(".editDiv", "click", function() {
            var parentId = $(this).parents('.first_div').attr('id');
            //console.log(parentId);
            var workflow_id = $(this).attr('workflow_id');
            var partner_id = $(this).attr('partner_id');
            var product_id = $(this).attr('product_id');
            var branch_id = $(this).attr('branch_id');
            $('#addcontact-modalLabel').html('Edit Product');
            console.log($('#modalbodyinput').length);
            if ($('#modalbodyinput').length == 0) {

                $('#modalbody').append('<input type="hidden" id="modalbodyinput" value="edit">')
                $('#modalbody').append('<input type="hidden" id="modalbodyinputparent" value="' + parentId + '">')
                console.log($('#modalbodyinput').length);
            }
            $.ajax({
                url: "{{ route('backend.client-profile-quotations-option') }}",
                type: 'POST',
                data: {
                    "workflow_id": workflow_id,
                    "partner_id": partner_id,
                    "product_id": product_id,
                    "branch_id": branch_id
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
        $("table").delegate(".removeDiv", "click", function() {
            // console.log('hi');
            var attr = $(this).attr('attr');
            $('#appendDiv' + attr).remove();
            countTotal();
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
        $("table").delegate(".service_fee,.discount,.net_fee,.egx_rte", "change", function() {
            var parentId = $(this).parents('.appendDiv').attr('id');
            console.log(parentId);
            callMyFunction(parentId)
        });
    });

    function countTotal() {
        var grandAmmount = 0;
        $('.total_ammount').each(function() {
            grandAmmount += parseInt($(this).val())
        })
        console.log(grandAmmount);
        $('#grand_total').val(grandAmmount);
        $('#grand_total_span').html(grandAmmount);
    }
    function callMyFunction(parentId) {
        var service_fee = parseFloat($('#' + parentId).find('.service_fee').val());
        var discount = parseFloat($('#' + parentId).find('.discount').val());
        var egx_rte = parseFloat($('#' + parentId).find('.egx_rte').val());
        egx_rte = (egx_rte == 0 ? 1 : egx_rte);

        var net_feeAmmount = (service_fee - discount);
        var totalAmmount = (net_feeAmmount * egx_rte);

        $('#' + parentId).find('.net_fee').val(net_feeAmmount)
        $('#' + parentId).find('.total_ammount').val(totalAmmount)

        var grandAmmount = 0;
        $('.total_ammount').each(function() {
            grandAmmount += parseInt($(this).val())
        })
        console.log(grandAmmount);
        $('#grand_total').val(grandAmmount);
        $('#grand_total_span').html(grandAmmount);
    }
    $("#datetime-datepicker").flatpickr({
        enableTime: !0,
        dateFormat: "Y-m-d H:i"
    });
</script>
@endsection