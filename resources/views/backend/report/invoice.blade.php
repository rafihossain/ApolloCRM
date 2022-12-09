@extends('backend.layouts.app')
@section('css')

@endsection
@section('content')
<div class="card">
  <div class="card-body">  
    <table id="datatable_new" class="table table-bordered dt-responsive table-responsive nowrap">
        <thead>
            <tr>       
                <th>Client Id</th>
                <th>Client</th>
                <!-- <th>Created By</th>
                <th>Assignee</th> -->
                <th>Partner</th>
                <th>Product</th>
                <th>Workflow</th>
                <th>Currency</th>
                <th>Invoice Type</th>
                <th>Invoice Due Date</th>
                <th>Invoice No</th>
                <th>Created At</th>
                <th>Status</th>
                <th>Total Fee</th>
                <th> Commission Amount</th>
                <th>Income Amount</th>
                <th>Discount Amount </th>
                <th>Income Sharing</th>
                <th> Other Payables</th>
                <th>Net Income</th>
                <th>Tax Received</th>
                <th>Tax Paid</th>
                <th>Paid Amount</th>
                <th>Due Amount</th>
                <th>Last Payment Date </th> 
            </tr>
        </thead>  
        <tbody>
           
        </tbody>
    </table>
  </div>
</div>

@endsection

@section('script')
<script>
      $( document ).ready(function() { 

    //    $('.dropify').dropify();
    //    $('.summereditor').summernote();

       var table=$('#datatable_new').DataTable( {
            processing: true,
            serverSide: true,
            // scrollX: true,
            ajax: {
                url: "{{route('backend.report_invoice')}}",
                type: "get",
                dataType: 'JSON',
            },
            columns: [
                { data: 'client_id', name: 'client_id' },
                { data: 'full_name', name: 'full_name'},
                { data: 'partner_name', name: 'partner_name.name' },
                { data: 'product_name', name: 'product_name'},
                { data: 'workflow.service_workflow', name: 'workflow.service_workflow'},
                { data: 'currency', name: 'currency' },
                { data: 'invoice_type', name: 'invoice_type'},
                { data: 'invoice_due_date', name: 'invoice_due_date'},
                { data: 'invoice_no', name: 'invoice_no' },
                { data: 'created_at', name: 'created_at'},
                { data: 'status', name: 'status'},
                { data: 'total_fee', name: 'total_fee'},
                { data: 'comission_amount', name: 'comission_amount' },
                { data: 'income_amount', name: 'income_amount'},
                { data: 'income_sharing', name: 'income_sharing'},
                { data: 'net_income', name: 'net_income'},
                { data: 'tax_received', name: 'tax_received'},
                { data: 'tax_paid', name: 'tax_paid' },
                { data: 'paid_amount', name: 'paid_amount'},
                { data: 'due_amount', name: 'due_amount'},
                { data: 'last_payment_date', name: 'last_payment_date'}
            ],
       });



    }); 
</script>
<!-- Datatables init --> 
<script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script> 
@endsection