<?php

namespace App\Http\Livewire\Admin;

use App\Models\Brand;
use Livewire\Component;

class Brands extends Component
{
    public $brands;
    public $brand;
    public $createForm = [
        'nombre' => null
    ];
    public $editForm = [
        'open' => false,
        'nombre' => null
    ];
    public $rules = [
        'createForm.name' => 'required'
    ];
    protected $validationAttributes = [
        'createForm.name' => 'nombre',
        'editForm.name' => 'nombre',
    ];
    protected $listeners = ['delete'];

    public function mount()
    {
        $this->getBrands();
    }

    public function getBrands()
    {
        $this->brands = Brand::all();
    }

    public function save()
    {
        $this->validate();
        Brand::create($this->createForm);
        $this->reset('createForm');
        $this->getBrands();
    }

    public function edit(Brand $brand)
    {
        $this->resetValidation();
        $this->brand = $brand;
        $this->editForm = [
            'open' => true,
            'name' => $brand->name
        ];
    }

    public function update()
    {
        $this->validate([
            'editForm.name' => 'required'
        ]);
        $this->brand->update($this->editForm);
        $this->reset('editForm');
        $this->getBrands();
    }

    public function delete(Brand $brand)
    {
        $brand->delete();
        $this->getBrands();
    }

    public function render()
    {
        return view('livewire.admin.brands')->layout('layouts.admin');
    }
}
