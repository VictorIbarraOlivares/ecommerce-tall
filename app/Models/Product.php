<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];
    const BORRADOR = 1;
    const PUBLICADO = 2;

    //  Relacion uno a muchos
    public function sizes()
    {
        return $this->hasMany(Size::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Relacion uno a muchos inversa
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    // Accesores
    public function getStockAttribute()
    {
        if ($this->subcategory->size) {
            return ColorSize::whereHas('size.product', function (Builder $q) {
                $q->where('id', $this->id);
            })->sum('quantity');
        } elseif ($this->subcategory->color) {
            return ColorProduct::whereHas('product', function (Builder $q) {
                $q->where('id', $this->id);
            })->sum('quantity');
        } else {
            return $this->quantity;
        }
    }

    // Relacion muchos a muchos
    public function colors()
    {
        return $this->belongsToMany(Color::class)->withPivot('quantity', 'id');
    }

    // relacion uno a muchos polimorfica
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    // URL AMIGABLES
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
