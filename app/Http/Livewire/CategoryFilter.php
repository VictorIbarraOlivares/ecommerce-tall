<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryFilter extends Component
{
    use WithPagination;
    public $category, $subcategory, $brand;
    public $view = 'grid';

    public function clean()
    {
        $this->reset(['subcategory', 'brand']);
    }

    public function render()
    {
        $productsQuery = Product::query()->whereHas('subcategory.category', function (Builder $query) {
            $query->where('id', $this->category->id);
        })->where('status', Product::PUBLICADO);

        if ($this->subcategory) {
            $productsQuery = $productsQuery->whereHas('subcategory', function (Builder $query) {
                $query->where('name', $this->subcategory);
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
