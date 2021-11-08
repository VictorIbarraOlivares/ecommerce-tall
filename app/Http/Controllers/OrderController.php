<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->user()->id)->get();
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $this->authorize('author', $order);
        $items = json_decode($order->content);
        return view('orders.show', compact('order', 'items'));
    }

    public function pay(Order $order,  Request $request)
    {
        $this->authorize('author', $order);
        $paymentId = $request->get('payment_id');
        $response = Http::get("https://api.mercadopago.com/v1/payments/$paymentId" . "?access_token=".config('services.mercadopago.token'));
        $response = json_decode($response);
        $status = $response->status;
        if ($status === 'approved') {
            $order->status = Order::RECIBIDO;
            $order->save();
        }
        
        return redirect()->route('orders.show', $order);
    }
}
