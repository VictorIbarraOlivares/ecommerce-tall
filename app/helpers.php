<?php

use App\Models\Size;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;

function quantity(Product $product, $colorId = null, $sizeId = null)
{
    $quantity = 0;
    if (!is_null($sizeId)) {
        $size = Size::findOrFail($sizeId);
        $quantity = $size->colors->find($colorId)->pivot->quantity;
    } elseif (!is_null($colorId)) {
        $quantity = $product->colors->find($colorId)->pivot->quantity;
    } else {
        $quantity = $product->quantity;
    }
    return $quantity;
}

function qtyAdded(Product $product, $colorId = null, $sizeId = null)
{
    $cart = Cart::content();
    $item = $cart->where('id', $product->id)
                ->where('options.color_id', $colorId)
                ->where('options.size_id', $sizeId)
                ->first();

    if ($item) {
        return $item->qty;
    }
    return 0;
}

function qtyAvailable(Product $product, $colorId = null, $sizeId = null)
{
    return quantity($product, $colorId, $sizeId) - qtyAdded($product, $colorId, $sizeId);
}