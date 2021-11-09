<?php

namespace App\Http\Livewire;

use App\Models\City;
use App\Models\Department;
use App\Models\District;
use App\Models\Order;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class CreateOrder extends Component
{
    public $contact;
    public $phone;
    public $envioType = 1;
    public $departments;
    public $cities = array();
    public $districts = array();
    public $departmentId = '';
    public $cityId = '';
    public $disctrictId = '';
    public $address;
    public $reference;
    public $shippingCost = 0;

    public $rules = [
        'contact' => 'required',
        'phone' => 'required',
        'envioType' => 'required',
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

    public function updatedEnvioType()
    {
        if ($this->envioType == 1) {
            $this->resetValidation([
                'departmentId', 'cityId', 'disctrictId', 'address', 'reference'
            ]);
        }
    }

    public function updatedDepartmentId()
    {
        $this->reset(['cityId', 'shippingCost', 'disctrictId']);
        $this->cities = City::where('department_id', $this->departmentId)->get();
    }

    public function updatedCityId()
    {
        $city = City::findOrFail($this->cityId);
        $this->shippingCost = City::findOrFail($this->cityId)->cost;
        $this->reset('disctrictId');
        $this->districts = District::where('city_id', $this->cityId)->get();
    }    

    public function store()
    {
        $rules = $this->rules;
        if ($this->envioType == 2) {
            $rules['departmentId'] = 'required';
            $rules['cityId'] = 'required';
            $rules['disctrictId'] = 'required';
            $rules['address'] = 'required';
            $rules['reference'] = 'required';
        }
        $this->validate($rules, $this->validationMessages);

        $order = new Order();
        $order->user_id = auth()->user()->id;
        $order->contact = $this->contact;
        $order->phone = $this->phone;
        $order->envio_type = $this->envioType;
        $order->shipping_cost = 0;
        $order->total = $this->shippingCost + Cart::subtotal();
        $order->content = Cart::content();
        if ($this->envioType == 2) {
            $order->shipping_cost = $this->shippingCost;
            $order->department_id = $this->departmentId;
            $order->city_id = $this->cityId;
            $order->district_id = $this->disctrictId;
            $order->address = $this->address;
            $order->reference = $this->reference; 
        }
        $order->save();
        foreach (Cart::content() as $item) {
            discount($item);
        }
        Cart::destroy();
        return redirect()->route('orders.payment', $order);
    }

    public function render()
    {
        return view('livewire.create-order');
    }
}
