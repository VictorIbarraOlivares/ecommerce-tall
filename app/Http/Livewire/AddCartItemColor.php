<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Gloudemans\Shoppingcart\Facades\Cart;

class AddCartItemColor extends Component
{
    public $product, $colors, $colorId = "", $quantity = 0;
    public $qty = 1;
    public $options = [
        'size' => null,
        'size_id' => null
    ];

    public function mount()
    {
        $this->colors = $this->product->colors;
        $this->options['image'] = Storage::url($this->product->images->first()->url);
    }

    public function updatedColorId()
    {
        $color = $this->product->colors->find($this->colorId);
        $this->quantity = qtyAvailable($this->product, $color->id);
        $this->options['color'] = $color->name;
        $this->options['color_id'] = $color->id;
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
        $this->quantity = qtyAvailable($this->product, $this->colorId);
        $this->reset('qty');
        $this->emitTo('dropdown-cart', 'render');
    }

    public function render()
    {
        return view('livewire.add-cart-item-color');
    }
}
