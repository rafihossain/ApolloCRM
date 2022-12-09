<!DOCTYPE html>
<html>
<head>
    <title>Preview</title>
</head>
<style type="text/css">
    body{
        font-family: 'Roboto Condensed', sans-serif;
    }
    .m-0{
        margin: 0px;
    }
    .p-0{
        padding: 0px;
    }
    .pt-5{
        padding-top:5px;
    }
    .mt-10{
        margin-top:10px;
    }
    .text-center{
        text-align:center !important;
    }
    .w-100{
        width: 100%;
    }
    .w-50{
        width:50%;   
    }
    .w-85{
        width:85%;   
    }
    .w-65{
        width:65%;   
    }
    .w-45{
        width:45%;   
    }
    .w-15{
        width:15%;   
    }
    .logo img{
        width:45px;
        height:45px;
        padding-top:30px;
    }
    .logo span{
        margin-left:8px;
        top:19px;
        position: absolute;
        font-weight: bold;
        font-size:25px;
    }
    .gray-color{
        color:#5D5D5D;
    }
    .text-bold{
        font-weight: bold;
    }
    .text-small{
        font-weight: 100;
    }
    .border{
        border:1px solid black;
    }
    table tr,th,td{
        border: 1px solid #d2d2d2;
        border-collapse:collapse;
        padding:7px 8px;
    }
    table tr th{
        background: #F4F4F4;
        font-size:10px;
    }
    table tr td{
        font-size:10px;
    }
    table{
        border-collapse:collapse;
    }
    .box-text p{
        line-height:10px;
    }
    .float-left{
        float:left;
    }
    .total-part{
        font-size:10px;
        line-height:12px;
    }
    .total-right p{
        padding-right:20px;
    }
</style>
<body>
<div class="add-detail mt-10">
    <div class="w-65 float-left mt-10">
        <img src="{{ asset('images/quotation-image.png') }}" alt="Company logo" width="150" />   
    </div>
    <div class="w-45 float-left mt-10" style="font-size: 10px;">
        <p class="m-0 pt-5 text-bold w-100"><span class="gray-color">{{ $user->company_name }}</span></p>
        <p class="m-0 pt-5 text-bold w-100"><span class="gray-color">{{ $user->company_phone }}</span></p>
        <p class="m-0 pt-5 text-bold w-100"><span class="gray-color">{{ $user->company_email }}</span></p>
    </div>
    <div style="clear: both;"></div>
</div>
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
        <tr>
            <th class="w-50">Client Details:</th>
            <th class="w-50"></th>
        </tr>
        <tr>
            <td>
                <div class="box-text">
                    <p>{{ $client->first_name.' '.$client->first_name }}</p>
                    <p>{{ $client->city }}</p>
                    <p>{{ $client->email }}</p>
                </div>
            </td>
            <td>
                <div class="box-text" align="center">
                    <p>Date: {{ $quotation->created_at->format('d-m-Y') }}</p>
                </div>
            </td>
        </tr>
    </table>
</div>
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
        <tr>
            <th class="w-20 text-small">Product List</th>
            <th class="w-20 text-small">Description</th>
            <th class="w-80 text-small">Service Fee</th>
            <th class="w-80 text-small">Discount</th>
            <th class="w-80 text-small">Net Amt</th>
            <th class="w-80 text-small">Exchange Rate</th>
            <th class="w-80 text-small">Grand Total</th>
        </tr>

        @foreach($quotation->quotation_product as $result)
        <tr align="center">
            <td>
                <span class="text-small" style="font-size: 10px;">{{ $result->product->name }}</span>
                <br />
                <span style="font-size: 10px;">{{ $result->partner->name.'('.$result->workflow->service_workflow.')' }}</span>
            </td>
            <td>{{ $result->description }}</td>
            <td>{{ $result->service_fee }}</td>
            <td>{{ $result->discount }}</td>
            <td>{{ $result->net_fee }}</td>
            <td>{{ $result->egx_rte }}</td>
            <td>{{ $result->total_ammount }}</td>
        </tr>
        @endforeach

        <tr>
            <td colspan="7">
                <div class="total-part">
                    <div class="total-left w-85 float-left" align="right">
                        <p>Sub Total</p>
                        <p>Tax (0%)</p>
                        <p>Total Payable</p>
                    </div>
                    <div class="total-right w-15 float-left text-bold" align="right">
                        <p>$0.00</p>
                        <p>$0.00</p>
                        <p>{{ $quotation->total_fee }}</p>
                    </div>
                    <div style="clear: both;"></div>
                </div> 
            </td>
        </tr>
    </table>
</div>
</html>