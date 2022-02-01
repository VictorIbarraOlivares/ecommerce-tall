<?php

namespace App\Http\Livewire\Admin;

use App\Models\Department;
use Livewire\Component;

class DepartmentComponent extends Component
{
    public $department;
    public $createForm = ['nombre' => ''];
    public $editForm = ['open' => false, 'nombre' => ''];   
    protected $listeners = ['delete'];
    protected $validationAttributes = ['createForm.name' => 'nombre', 'editForm.name' => 'nombre'];

    public function mount()
    {

    }

    public function getDepartmentsProperty()
    {
        return Department::all();
    }

    public function save()
    {
        $this->validate(['createForm.name' => 'required']);
        Department::create($this->createForm);
        $this->reset('createForm');
        $this->getDepartmentsProperty();
        $this->emit('save');
    }

    public function edit(Department $department)
    {
        $this->department = $department;
        $this->editForm = [
            'open' => true,
            'name' => $this->department->name
        ];

    }

    public function update()
    {
        $this->department->name = $this->editForm['name'];
        $this->department->save();
        $this->reset('editForm');
        $this->getDepartmentsProperty();
    }

    public function delete(Department $department)
    {
        $department->delete();
        $this->getDepartmentsProperty();
    }

    public function render()
    {
        return view('livewire.admin.department-component')->layout('layouts.admin');
    }
}
