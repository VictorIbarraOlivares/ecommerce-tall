<?php

namespace App\Http\Livewire\Admin;

use App\Models\Brand;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use App\Models\Image;
use App\Models\Subcategory;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class EditProduct extends Component
{
    public $product;
    public $categories;
    public $category_id;
    public $subCategories;
    public $brands;

    protected $listeners = ['refreshProduct', 'delete'];

    protected $rules = [
        'category_id' => 'required',
        'product.subcategory_id' => 'required',
        'product.name' => 'required',
        'product.slug' => 'required|unique:products,slug',
        'product.description' => 'required',
        'product.brand_id' => 'required',
        'product.price' => 'required',
        'product.quantity' => 'numeric',
    ];

    public function mount(Product $product)
    {
        $this->product = $product;
        $this->categories = Category::all();
        $this->category_id = $product->subcategory->category->id;
        $this->subCategories = Subcategory::where('category_id', $this->category_id)->get();
        $this->brands = Brand::whereHas('categories', function (Builder $query){
            $query->where('category_id', $this->category_id);
        })->get();
    }

    public function refreshProduct()
    {
        $this->product = $this->product->fresh();
    }

    public function updatedProductName($value)
    {
        $this->product->slug = Str::slug($value);
    }

    public function updatedCategoryId()
    {
        $this->subCategories = Subcategory::where('category_id', $this->category_id)->get();
        $this->brands = Brand::whereHas('categories', function (Builder $query){
            $query->where('category_id', $this->category_id);
        })->get();
        // $this->reset(['subcategory_id', 'brand_id']);
        $this->product->subcategory_id = '';
        $this->product->brand_id = '';
    }

    public function getSubcategoryProperty()
    {
        return Subcategory::find($this->product->subcategory_id);
    }

    public function save()
    {
        $rules = $this->rules;
        $rules['product.slug'] = 'required|unique:products,slug,'. $this->product->id;
        if ($this->product->subcategory_id && !$this->subcategory->color && !$this->subcategory->size) {
            $rules['product.quantity'] = 'required|numeric';
        }
        $this->validate($rules);
        $this->product->save();

        $this->emit('saved');
    }

    public function deleteImage(Image $image)
    {
        Storage::delete([$image->url]);
        $image->delete();
        $this->refreshProduct();
    }

    public function delete()
    {
        $images = $this->product->images;
        foreach ($images as $image) {
            Storage::delete([$image->url]);
            $image->delete();
        }

        $this->product->delete();
        return redirect()->route('admin.index');
    }

    public function render()
    {
        return view('livewire.admin.edit-product')->layout('layouts.admin');
    }
}
