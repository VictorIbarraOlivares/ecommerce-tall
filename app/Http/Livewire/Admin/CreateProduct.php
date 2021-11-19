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
    public $categoryId = "";
    public $subCategories = array();
    public $subCategoryId = "";
    public $name;
    public $slug;
    public $description;
    public $brands = array();
    public $brandId = "";
    public $price;
    public $quantity;

    protected $rules = [
        'categoryId' => 'required',
        'subCategoryId' => 'required',
        'name' => 'required',
        'slug' => 'required|unique:products',
        'description' => 'required',
        'brandId' => 'required',
        'price' => 'required',
    ];

    public function save()
    {
        $rules = $this->rules;
        if ($this->subCategoryId && !$this->subcategory->color && !$this->subcategory->size) {
            $rules['quantity'] = 'required';
        }
        $this->validate($rules);
        $product = new Product();
        $product->name = $this->name;
        $product->slug = $this->slug;
        $product->description = $this->description;
        $product->subcategory_id = $this->subCategoryId;
        $product->brand_id = $this->brandId;
        $product->price = $this->price;
        if ($this->subCategoryId && !$this->subcategory->color && !$this->subcategory->size) {
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
        $this->subCategories = Subcategory::where('category_id', $this->categoryId)->get();
        $this->brands = Brand::whereHas('categories', function (Builder $query){
            $query->where('category_id', $this->categoryId);
        })->get();
        $this->reset(['subCategoryId', 'brandId']);
    }

    public function getSubcategoryProperty()
    {
        return Subcategory::find($this->subCategoryId);
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
