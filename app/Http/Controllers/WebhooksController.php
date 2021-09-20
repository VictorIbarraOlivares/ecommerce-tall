<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WebhooksController extends Controller
{
    public function __invoke(Request $request)
    {
        $paymentId = $request->get('payment_id');
        $response = Http::get("https://api.mercadopago.com/v1/payments/$paymentId" . "?access_token=".config('services.mercadopago.token'));
        $response = json_decode($response);
        $status = $response->status;
        // if ($status === 'approved') {
        //     $order->status = Order::RECIBIDO;
        //     $order->save();
        // }
        
        // return redirect()->route('orders.show', $order);
    }
}
