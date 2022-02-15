<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'comment' => ['required', 'min:5'],
            'rating' => ['required', 'integer', 'min:1', 'max:15']
        ], [
            'comment.required' => 'Escriba su reseña por favor.'
        ]);
        $product->reviews()->create([
            'comment' => $request->input('comment'),
            'rating' => $request->input('rating'),
            'user_id' => auth()->id()
        ]);

        session()->flash('flash.banner', 'Tu se reseña agrego con éxito');
        session()->flash('flash.bannerStyle', 'success');
        return redirect()->back();
    }
}
