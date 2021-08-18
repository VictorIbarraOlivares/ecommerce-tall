<?php

namespace App\Http\Livewire;

use App\Models\Size;
use Livewire\Component;

class AddCartItemSize extends Component
{
    public $product, $sizes, $sizeId = "", $colors = [], $colorId = "", $quantity = 0;
    public $qty = 1;
    
    public function updatedSizeId()
    {
        $size = Size::find($this->sizeId);
        $this->colors = $size->colors;
    }

    public function mount()
    {
        $this->sizes = $this->product->sizes;
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
        return view('livewire.add-cart-item-size');
    }

    public function updatedColorId()
    {
        $this->quantity = Size::find($this->sizeId)->colors->find($this->colorId)->pivot->quantity;
    }
}
