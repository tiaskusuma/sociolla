<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($id)
    {
        $product = Product::findOrFail($id);
        
        $reviews = \App\Models\Order::with('user')
            ->whereHas('items', function($q) use ($id) {
                $q->where('product_id', $id);
            })->where('is_rated', true)->orderBy('updated_at', 'desc')->get();
            
        return view('product.detail', compact('product', 'reviews'));
    }
}
