<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function checkout()
    {
        return view('frontend.checkout');
    }

    public function checkout_now(Request $request)
    {
        
    }

    public function cancelled($order_id)
    {
    

    }

    public function completed($order_id)
    {
    }

    public function webhook($order, $env)
    {
        //
    }

}
