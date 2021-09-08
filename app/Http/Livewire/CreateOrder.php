<?php

namespace App\Http\Livewire;

use App\Models\Department;
use Livewire\Component;

class CreateOrder extends Component
{
    public $contact;
    public $phone;
    public $envio_type = 1;
    public $departments;
    public $cities = array();
    public $districts = array();
    public $departmentId = '';
    public $cityId = '';
    public $disctrictId = '';
    public $address;
    public $reference;

    public $rules = [
        'contact' => 'required',
        'phone' => 'required',
        'envio_type' => 'required',
    ];

    public $validationMessages = [
        'contact.required' => 'El campo contácto es obligatorio.',
        'phone.required' => 'El campo teléfono es obligatorio.',
        'departmentId.required' => 'El campo departamento es obligatorio.',
        'cityId.required' => 'El campo ciudad es obligatorio.',
        'disctrictId.required' => 'El campo distrito es obligatorio.',
        'address.required' => 'El campo direccion es obligatorio.',
        'reference.required' => 'El campo referencia es obligatorio.'
    ];

    public function mount()
    {
        $this->departments = Department::all();
    }

    public function updateEnvioType()
    {
        if ($this->envio_type == 1) {
            $this->resetValidation([
                'departmentId', 'cityId', 'disctrictId', 'address', 'reference'
            ]);
        }
    }

    public function store()
    {
        $rules = $this->rules;
        if ($this->envio_type == 2) {
            $rules['departmentId'] = 'required';
            $rules['cityId'] = 'required';
            $rules['disctrictId'] = 'required';
            $rules['address'] = 'required';
            $rules['reference'] = 'required';
        }
        $this->validate($rules, $this->validationMessages);
    }

    public function render()
    {
        return view('livewire.create-order');
    }
}
