<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    public function review(User $user, Product $product)
    {
        $reviews = $product->reviews()->where('user_id', $user->id)->first();
        if (is_null($reviews)) {
            $orders = Order::where('user_id', $user->id)
                ->select('content')->get()
                ->map( function($order) {
                    return json_decode($order->content, true);
                });
            $products = $orders->collapse();

            return $products->contains('id', $product->id);
        } else {
            return false;
        }
        
    }
}
