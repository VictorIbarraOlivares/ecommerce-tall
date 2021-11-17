<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use App\Models\Subcategory;
use Livewire\Component;

class CreateProduct extends Component
{
    public $categories;
    public $categoryId = "";
    public $subCategories = array();
    public $subCategoryId = "";

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
