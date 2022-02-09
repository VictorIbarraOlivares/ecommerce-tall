<?php

namespace App\Http\Livewire\Admin;

use App\Models\City;
use App\Models\Department;
use Livewire\Component;

class ShowDepartment extends Component
{
    protected $listeners = ['delete'];
    public $department;
    public $city;
    public $createForm = ['name' => '', 'cost' => null];
    public $editForm = ['open' => false, 'name' => '', 'cost' => null];   
    protected $validationAttributes = [
        'createForm.name' => 'nombre',
        'createForm.cost' => 'costo',
        'editForm.name' => 'nombre',
        'editForm.cost' => 'costo'
    ];

    public function mount(Department $department)
    {
        $this->department = $department;
    }

    public function getCitiesProperty()
    {
        return City::where('department_id', $this->department->id)->get();
    }

    public function save()
    {
        $this->validate([
            'createForm.name' => 'required',
            'createForm.cost' => 'required|numeric|min:1|max:15000'
        ]);
        $this->department->cities()->create($this->createForm);
        $this->reset('createForm');
        $this->getCitiesProperty();
        $this->emit('save');
    }

    public function edit(City $city)
    {
        $this->city = $city;
        $this->editForm = [
            'open' => true,
            'name' => $this->city->name,
            'cost' => $this->city->cost
        ];
    }

    public function update()
    {
        $this->city->name = $this->editForm['name'];
        $this->city->cost = $this->editForm['cost'];
        $this->city->save();
        $this->reset('editForm');
        $this->getCitiesProperty();
    }

    public function delete(City $city)
    {
        $city->delete();
        $this->getCitiesProperty();
    }

    public function render()
    {
        return view('livewire.admin.show-department')->layout('layouts.admin');
    }
}
