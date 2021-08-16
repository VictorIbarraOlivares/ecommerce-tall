<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AddCartItemColor extends Component
{
    public $product, $colors, $colorId = "", $quantity = 0;
    public $qty = 1;

    public function mount()
    {
        $this->colors = $this->product->colors;
    }

    public function decrement()
    {
        $this->qty = $this->qty - 1;
    }

    public function increment()
    {
        $this->qty = $this->qty + 1;
    }

    public function render()
    {
        return view('livewire.add-cart-item-color');
    }

    public function updatedColorId()
    {
        $this->quantity = $this->product->colors->find($this->colorId)->pivot->quantity;
    }
}
