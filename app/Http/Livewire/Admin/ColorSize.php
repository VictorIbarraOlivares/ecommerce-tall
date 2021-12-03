<?php

namespace App\Http\Livewire\Admin;

use App\Models\Color;
use App\Models\ColorSize as ModelsColorSize;
use Livewire\Component;

class ColorSize extends Component
{
    public $size;
    public $colors;
    public $color_id;
    public $quantity;
    public $pivot;
    public $open_modal = false;
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

        $pivot = ModelsColorSize::where('color_id', $this->color_id)->where('size_id', $this->size->id)->first();
        if ($pivot) {
            $pivot->quantity = $pivot->quantity + $this->quantity;
            $pivot->save();
        } else {
            $this->size->colors()->attach([
                $this->color_id => [
                    'quantity' => $this->quantity
                ]
            ]);
        }

        $this->reset(['color_id', 'quantity']);
        $this->emit('saved');

        $this->size = $this->size->fresh();
    }

    public function editColor(ModelsColorSize $pivot)
    {
        $this->pivot = $pivot;
        $this->open_modal = true;
        $this->pivot_color_id = $pivot->color_id;
        $this->pivot_quantity = $pivot->quantity;
    }
    
    public function updateColor()
    {
        $this->pivot->color_id = $this->pivot_color_id;
        $this->pivot->quantity = $this->pivot_quantity;
        $this->pivot->save();
        $this->size = $this->size->fresh();
        $this->open_modal = false;
    }

    public function deleteColor(ModelsColorSize $pivot)
    {
        $pivot->delete();
        $this->size = $this->size->fresh();
    }

    public function render()
    {
        $size_colors = $this->size->colors;
        return view('livewire.admin.color-size', compact('size_colors'));
    }
}
