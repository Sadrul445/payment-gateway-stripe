<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session as FacadesSession;
use Stripe;

class StripePaymentController extends Controller
{
    public function stripe()
    {
        return view('stripe');
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $customer = Stripe\Customer::create(array(
            "address" => [
                "line1" => "Sadrul",
                "postal_code" => "4221",
                "city" => "Chittagong",
                "state" => "Ctg",
                "country" => "BAN",
            ],
            "email" => "demo@gmail.com",
            "name" => "Sadrul Tanim",
            "source" => $request->stripeToken
        ));
        Stripe\Charge::create([
            "amount" => 100 * 100,
            "currency" => "usd",
            "customer" => $customer->id,
            "description" => "Test payment from sadrultanimchowdhury",
            "shipping" => [
                "name" => "Jenny Rosen",
                "address" => [
                    "line1" => "510 Townsend St",
                    "postal_code" => "98140",
                    "city" => "San Francisco",
                    "state" => "CA",
                    "country" => "US",
                ],
            ]
        ]);

        FacadesSession::flash('success', 'Payment successful!');

        return back();
    }
}
