<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class Search extends Component
{
    public $search, $open = false;

    public function updatedSearch()
    {
        if ($this->search) {
            $this->open = true;
        } else {
            $this->open = false;
        }
    }

    public function render()
    {
        $products = array();
        if ($this->search) {
            $products = Product::where('name', 'LIKE', "%" . $this->search . "%")
                ->where('status', Product::PUBLICADO)
                ->take(8)
                ->get();
        }

        return view('livewire.search', compact('products'));
    }
}
