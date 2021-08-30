<?php

namespace App\Http\Livewire;

use App\Models\Size;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Gloudemans\Shoppingcart\Facades\Cart;

class AddCartItemSize extends Component
{
    public $product, $sizes, $sizeId = "", $colors = [], $colorId = "", $quantity = 0;
    public $qty = 1;
    public $options = [];

    public function mount()
    {
        $this->sizes = $this->product->sizes;
        $this->options['image'] = Storage::url($this->product->images->first()->url);
    }

    public function updatedSizeId()
    {
        $size = Size::find($this->sizeId);
        $this->colors = $size->colors;
        $this->options['size'] = $size->name;
    }

    public function updatedColorId()
    {
        $size = Size::find($this->sizeId);
        $color = $size->colors->find($this->colorId);
        $this->quantity = qtyAvailable($this->product, $color->id, $size->id);
        $this->options['color'] = $color->name;
    }

    public function decrement()
    {
        $this->qty = $this->qty - 1;
    }

    public function increment()
    {
        $this->qty = $this->qty + 1;
    }

    public function addItem()
    {
        Cart::add([
            'id' => $this->product->id,
            'name' => $this->product->name,
            'qty' => $this->qty,
            'price' => $this->product->price,
            'weight' => 550,
            'options' => $this->options
        ]);
        $this->quantity = qtyAvailable($this->product, $this->colorId, $this->sizeId);
        $this->reset('qty');
        $this->emitTo('dropdown-cart', 'render');
    }

    public function render()
    {
        return view('livewire.add-cart-item-size');
    }
}
