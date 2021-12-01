<?php

namespace App\Http\Livewire\Admin;

use App\Models\Size;
use Livewire\Component;

class SizeProduct extends Component
{
    public $product;
    public $name;
    public $open_modal = false;
    public $name_edit;
    public $size;

    protected $listeners = ['deleteSize'];

    protected $rules = [
        'name' => 'required'
    ];

    public function save()
    {
        $this->validate();
        $size = Size::where('product_id', $this->product->id)->where('name', $this->name)->first();
        if ($size) {
            $this->emit('error-size', 'Esta talla ya existe');
        } else {
            $this->product->sizes()->create([
                'name' => $this->name
            ]);
        }

        $this->reset('name');
        $this->product = $this->product->fresh();
    }

    public function editSize(Size $size)
    {
        $this->open_modal = true;
        $this->size = $size;
        $this->name_edit = $size->name;
    }

    public function updateSize()
    {
        $this->validate([
            'name_edit' => 'required'
        ]);
        $this->size->name = $this->name_edit;
        $this->size->save();
        $this->product = $this->product->fresh();
        $this->open_modal = false;
    }

    public function deleteSize(Size $size)
    {
        $size->delete();
        $this->product = $this->product->fresh();
    }

    public function render()
    {
        $product_sizes = $this->product->sizes;
        return view('livewire.admin.size-product', compact('product_sizes'));
    }
}
