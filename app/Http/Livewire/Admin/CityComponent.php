<?php

namespace App\Http\Livewire\Admin;

use App\Models\City;
use App\Models\District;
use Livewire\Component;

class CityComponent extends Component
{
    protected $listeners = ['delete'];
    public $city;
    public $district;
    public $createForm = ['name' => ''];
    public $editForm = ['open' => false, 'name' => ''];   
    protected $validationAttributes = [
        'createForm.name' => 'nombre',
        'editForm.name' => 'nombre'
    ];

    public function mount(City $city)
    {
        $this->city = $city;
    }

    public function getDistrictsProperty()
    {
        return District::where('city_id', $this->city->id)->get();
    }

    public function save()
    {
        $this->validate([
            'createForm.name' => 'required'
        ]);
        $this->city->districts()->create($this->createForm);
        $this->reset('createForm');
        $this->getDistrictsProperty();
        $this->emit('save');
    }

    public function edit(District $district)
    {
        $this->district = $district;
        $this->editForm = [
            'open' => true,
            'name' => $this->district->name,
        ];
    }

    public function update()
    {
        $this->district->name = $this->editForm['name'];
        $this->district->save();
        $this->reset('editForm');
        $this->getDistrictsProperty();
    }

    public function delete(District $district)
    {
        $city->delete();
        $this->getDistrictsProperty();
    }

    public function render()
    {
        return view('livewire.admin.city-component')->layout('layouts.admin');
    }
}
