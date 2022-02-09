<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::query()->orderOfUser();
        if (request('status')) {
            $orders->where('status', request('status'));
        }
        $orders = $orders->get();

        $amountOfOrders = array(
            Order::PENDIENTE => Order::orderOfUser()->where('status', Order::PENDIENTE)->count(),
            Order::RECIBIDO => Order::orderOfUser()->where('status', Order::RECIBIDO)->count(),
            Order::ENVIADO => Order::orderOfUser()->where('status', Order::ENVIADO)->count(), 
            Order::ENTREGADO => Order::orderOfUser()->where('status', Order::ENTREGADO)->count(),
            Order::ANULADO => Order::orderOfUser()->where('status', Order::ANULADO)->count(),
        );
        
        return view('orders.index', compact('orders', 'amountOfOrders'));
    }

    public function show(Order $order)
    {
        $this->authorize('author', $order);
        $items = json_decode($order->content);
        $envio = json_decode($order->envio);
        return view('orders.show', compact('order', 'items', 'envio'));
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
