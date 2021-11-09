<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function __invoke()
    {
        if (auth()->user() && $pending = Order::OrderOfUser()->where('status', Order::PENDIENTE)->count()) {
            $message = "Usted tiene $pending ordenes pendientes. 
            <a class='font-bold' href='". route('orders.index') ."?status=".Order::PENDIENTE."'>Ir a pagar</a>";
            session()->flash('flash.banner', $message);
        }
        $categories = Category::all();
        return view('welcome', compact('categories'));
    }
}
