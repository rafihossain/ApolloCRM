<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BillingHistory;
use App\Models\SubscriptionBilling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Stripe;

class StripePaymentController extends Controller
{
    public function stripe($id)
    {
        $billing = SubscriptionBilling::find($id);
        // dd($billing);

        return view('api/stripe/stripe', [
            'billing' => $billing
        ]);
    }
    public function stripePost(Request $request)
    {
        // dd($request->all());

        $billing = SubscriptionBilling::find($request->billing_id);


        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $checkout = Stripe\Charge::create ([
                "amount" => $billing->total_amount * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "" 
        ]);

        // dd($checkout);

        $payment = new BillingHistory();
        $payment->user_id =  Session::get('user_id');
        $payment->payment_method = $checkout->calculated_statement_descriptor;
        $payment->total_amount =  $checkout->amount / 100;
        $payment->payment_date =  date('Y-m-d',$checkout->created);
        $payment->status =  $checkout->status;
        $payment->save();
        
        return redirect('admin/setting/subscription/billing')->with("success", "Payment successfully!");
  
    }
}
