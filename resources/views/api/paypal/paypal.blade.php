@extends('backend.layouts.app')
@section('css')

@endsection
@section('content')

<div class="container">
    <a href="{{ route('backend.subscription-change') }}" class="btn btn-primary"> <i class=" fas fa-caret-left"></i> Back to billing</a>

    <div class="row">
        <div class="col-md-6 m-auto mt-2">
            <div class="card">
                <div class="card-body">
                    <div class="card-header mb-2">
                        <!-- <p>Add your payment details</p> -->
                        <h4 class="card-title text-center text-primary">Add your payment details</h4>
                    </div>
                    <div class="m-auto mb-3">
                        <ul class="nav nav-tabs nav-bordered border-0"> 
                            <li class="nav-item">
                                <a href="{{ route('backend.stripe',['id'=>$billing->id]) }}" class="nav-link">
                                    Stripe
                                </a>
                            </li> 
                            <li class="nav-item">
                                <a href="{{ route('backend.paypal',['id'=>$billing->id]) }}" class="nav-link active">
                                    Paypal
                                </a>
                            </li>
                        </ul>
                    </div>
                    @if (Session::has('success'))
                    <div class="alert alert-success text-center">
                        <a href="#" class="btn-close" data-bs-dismiss="alert" aria-label="close">×</a>
                        <p>{{ Session::get('success') }}</p>
                    </div>
                    @endif
                    
                    <div class="text-center mb-4">
                        <table border="0" cellpadding="10" cellspacing="0" align="center">
                            <tr>
                                <td align="center"></td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <a href="https://www.sandbox.paypal.com/cgi-bin/webscr" 
                                    title="How PayPal Works" 
                                    onclick="javascript:window.open('https://www.sandbox.paypal.com/cgi-bin/webscr','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1060, height=700'); return false;">
                                    <img src="https://www.paypalobjects.com/webstatic/mktg/Logo/pp-logo-200px.png" border="0" alt="PayPal Logo">
                                    </a>
                                </td>
                            </tr>
                        </table>
                        <a href="{{ route('backend.payment') }}" class="btn btn-success">Pay ${{$billing->total_amount}} from Paypal</a>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

@endsection
@section('script')

@endsection