<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::query()->where('status', '!=', Order::PENDIENTE);
        if (request('status')) {
            $orders->where('status', request('status'));
        }
        $orders = $orders->get();

        $amountOfOrders = array(
            // Order::PENDIENTE => Order::where('status', Order::PENDIENTE)->count(),
            Order::RECIBIDO => Order::where('status', Order::RECIBIDO)->count(),
            Order::ENVIADO => Order::where('status', Order::ENVIADO)->count(), 
            Order::ENTREGADO => Order::where('status', Order::ENTREGADO)->count(),
            Order::ANULADO => Order::where('status', Order::ANULADO)->count(),
        );
        
        return view('admin.orders.index', compact('orders', 'amountOfOrders'));
    }

    public function show(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }
}
