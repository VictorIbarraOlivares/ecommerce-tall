<?php

namespace App\Http\Livewire;

use App\Models\Size;
use Livewire\Component;

class AddCartItemSize extends Component
{
    public $product, $sizes, $sizeId = "", $colors = [];
    
    public function updatedSizeId()
    {
        $size = Size::find($this->sizeId);
        $this->colors = $size->colors;
    }

    public function mount()
    {
        $this->sizes = $this->product->sizes;
    }

    public function render()
    {
        return view('livewire.add-cart-item-size');
    }
}
