<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;
use App\Models\Subcategory;
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

    public function updatedName($value)
    {
        $this->slug = Str::slug($value);
    }

    public function updatedCategoryId()
    {
        $this->subCategories = Subcategory::where('category_id', $this->categoryId)->get();
        $this->reset('subCategoryId');
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
