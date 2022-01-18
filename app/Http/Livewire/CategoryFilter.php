<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class CategoryFilter extends Component
{
    use WithPagination;
    public $category, $subcategory, $brand;
    public $view = 'grid';
    public $queryString = ['subcategory', 'brand'];

    public function clean()
    {
        $this->reset(['subcategory', 'brand', 'page']);
    }

    public function updatedSubcategory() {
        $this->resetPage();
    }

    public function updatedBrand() {
        $this->resetPage();
    }

    public function render()
    {
        $productsQuery = Product::query()->whereHas('subcategory.category', function (Builder $query) {
            $query->where('id', $this->category->id);
        })->where('status', Product::PUBLICADO);

        if ($this->subcategory) {
            $productsQuery = $productsQuery->whereHas('subcategory', function (Builder $query) {
                $query->where('slug', $this->subcategory);
            });
        }

        if ($this->brand) {
            $productsQuery = $productsQuery->whereHas('brand', function (Builder $query) {
                $query->where('name', $this->brand);
            });
        }
        if ($this->view == 'grid') {
            $products = $productsQuery->paginate(20);
        } elseif ($this->view == 'list') {
            $products = $productsQuery->paginate(8);
        }

        return view('livewire.category-filter', compact('products'));
    }
}
