<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BillingHistory;
use App\Models\SubscriptionBilling;
use Srmklive\PayPal\Services\ExpressCheckout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PaypalPaymentController extends Controller
{
    public function paypal($id){
        $billing = SubscriptionBilling::find($id);
        return view('api/paypal/paypal', [
            'billing' => $billing
        ]);
    }
    public function payment()
    {
        $billing = SubscriptionBilling::where('user_id', Session::get('user_id'))->first();

        $data = [];
        $data['items'] = [
            [
                'name' => 'Therssoftware.com',
                'price' => $billing->total_amount,
                'desc'  => 'Description for Therssoftware.com',
                'qty' => 1
            ]
        ];
  
        $data['invoice_id'] = $billing->id;
        $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
        $data['return_url'] = route('backend.payment.success');
        $data['cancel_url'] = route('backend.payment.cancel');
        $data['total'] = $billing->total_amount;
        
  
        $provider = new ExpressCheckout;
  
        $response = $provider->setExpressCheckout($data);
        $response = $provider->setExpressCheckout($data, true);
        return redirect($response['paypal_link']);
    }
   
    public function cancel()
    {
        dd('Your payment is canceled. You can create cancel page here.');
    }
  
    public function success(Request $request)
    {
        $provider = new ExpressCheckout;
        $response = $provider->getExpressCheckoutDetails($request->token);
        // dd($response);
  
        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
            
            $payment = new BillingHistory();
            $payment->user_id =  Session::get('user_id');
            $payment->payment_method = 'Paypal';
            $payment->total_amount =  $response['AMT'];
            $payment->payment_date =  date('Y-m-d',strtotime($response['TIMESTAMP']));
            $payment->status =  $response['ACK'];
            $payment->save();

            return redirect('admin/setting/subscription/billing')->with("success", "Payment successfully!");
        }
        
        return redirect('admin/setting/subscription/billing')->with("danger", "Something is wrong.!");
    }

}
