<?php

namespace App\Http\Livewire\Admin;

use App\Models\Brand;
use Livewire\Component;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class CreateProduct extends Component
{
    public $categories;
    public $category_id = "";
    public $subCategories = array();
    public $subcategory_id = "";
    public $name;
    public $slug;
    public $description;
    public $brands = array();
    public $brand_id = "";
    public $price;
    public $quantity;

    protected $rules = [
        'category_id' => 'required',
        'subcategory_id' => 'required',
        'name' => 'required',
        'slug' => 'required|unique:products',
        'description' => 'required',
        'brand_id' => 'required',
        'price' => 'required',
    ];

    public function save()
    {
        $rules = $this->rules;
        if ($this->subcategory_id && !$this->subcategory->color && !$this->subcategory->size) {
            $rules['quantity'] = 'required';
        }
        $this->validate($rules);
        $product = new Product();
        $product->name = $this->name;
        $product->slug = $this->slug;
        $product->description = $this->description;
        $product->subcategory_id = $this->subcategory_id;
        $product->brand_id = $this->brand_id;
        $product->price = $this->price;
        if ($this->subcategory_id && !$this->subcategory->color && !$this->subcategory->size) {
            $product->quantity = $this->quantity;
        }
        $product->save();

        return redirect()->route('admin.products.edit', $product);
    }

    public function updatedName($value)
    {
        $this->slug = Str::slug($value);
    }

    public function updatedCategoryId()
    {
        $this->subCategories = Subcategory::where('category_id', $this->category_id)->get();
        $this->brands = Brand::whereHas('categories', function (Builder $query){
            $query->where('category_id', $this->category_id);
        })->get();
        $this->reset(['subcategory_id', 'brand_id']);
    }

    public function getSubcategoryProperty()
    {
        return Subcategory::find($this->subcategory_id);
    }

    public function mount()
    {
        $this->categories = Category::all();
    }

    public function render()
    {
        return view('livewire.admin.create-product')->layout('layouts.admin');
    }
}
