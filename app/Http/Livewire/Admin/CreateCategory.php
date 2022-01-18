<?php

namespace App\Http\Livewire\Admin;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class CreateCategory extends Component
{
    use WithFileUploads;

    public $brands;
    public $categories;
    public $rand;
    public $category;
    public $createForm = [
        'name' => null,
        'slug' => null,
        'icon' => null,
        'image' => null,
        'brands' => []
    ];
    public $editForm = [
        'open' => false,
        'name' => null,
        'slug' => null,
        'icon' => null,
        'image' => null,
        'brands' => []
    ];
    public $editImage;
    protected $rules = [
        'createForm.name' => 'required',
        'createForm.slug' => 'required|unique:categories,slug',
        'createForm.icon' => 'required',
        'createForm.image' => 'required|image|max:1024',
        'createForm.brands' => 'required',
    ];
    protected $validationAttributes = [
        'createForm.name' => 'nombre',
        'createForm.slug' => 'slug',
        'createForm.icon' => 'icono',
        'createForm.image' => 'imagen',
        'createForm.brands' => 'marcas',
    ];

    protected $listeners = ['delete'];

    public function mount()
    {
        $this->getBrands();
        $this->getCategories();
        $this->rand = rand();
    }

    public function updatedCreateFormName($value)
    {
        $this->createForm['slug'] = Str::slug($value);
    }

    public function getBrands()
    {
        $this->brands = Brand::all();
    }

    public function getCategories()
    {
        $this->categories = Category::all();
    }

    public function save()
    {
        $this->validate();
        $image = $this->createForm['image']->store('categories');
        $category = Category::create([
            'name' => $this->createForm['name'],
            'slug' => $this->createForm['slug'],
            'icon' => $this->createForm['icon'],
            'image' => $image
        ]);
        $this->emit('saved');
        $category->brands()->attach($this->createForm['brands']);
        $this->rand = rand();
        $this->reset('createForm');
        $this->getCategories();
    }

    public function edit(Category $category)
    {
        $this->category = $category;
        $this->editForm = [
            'open' => true,
            'name' => $category->name,
            'slug' => $category->slug,
            'icon' => $category->icon,
            'image' => Storage::url($category->image),
            'brands' => $category->brands->pluck('id')->toArray()
        ];
    }

    public function delete(Category $category)
    {
        $category->delete();
        $this->getCategories();
    }

    public function render()
    {
        return view('livewire.admin.create-category');
    }
}
