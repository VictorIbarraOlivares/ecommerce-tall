<?php

namespace App\Http\Livewire\Admin;

use App\Models\Color;
use App\Models\ColorProduct as ModelsColorProduct;
use Livewire\Component;

class ColorProduct extends Component
{
    public $product;
    public $colors;
    public $color_id;
    public $quantity;
    public $open_modal = false;
    public $pivot;
    public $pivot_color_id;
    public $pivot_quantity;

    protected $listeners = ['deleteColor'];

    protected $rules = [
        'color_id' => 'required',
        'quantity' => 'required|numeric',
    ];

    public function mount()
    {
        $this->colors = Color::all();
    }

    public function save()
    {
        $this->validate();

        $this->product->colors()->attach([
            $this->color_id => [
                'quantity' => $this->quantity
            ]
        ]);

        $this->reset(['color_id', 'quantity']);
        $this->emit('saved');

        $this->product = $this->product->fresh();
    }

    public function editColor(ModelsColorProduct $pivot)
    {
        $this->open_modal = true;
        $this->pivot = $pivot;
        $this->pivot_color_id = $pivot->color_id;
        $this->pivot_quantity = $pivot->quantity;
    }

    public function updateColor()
    {
        $this->pivot->color_id = $this->pivot_color_id;
        $this->pivot->quantity = $this->pivot_quantity;
        $this->pivot->save();
        $this->product = $this->product->fresh();
        $this->open_modal = false;
    }

    public function deleteColor(ModelsColorProduct $pivot)
    {
        $pivot->delete();
        $this->product = $this->product->fresh();
    }

    public function render()
    {
        $product_colors = $this->product->colors;
        return view('livewire.admin.color-product', compact('product_colors'));
    }
}
