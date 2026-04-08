<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::where('user_id', Auth::id())->with('product')->get();
        $total = $cartItems->sum(function($item) {
            return $item->quantity * $item->product->price;
        });
        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request, $product_id)
    {
        $quantity = $request->input('quantity', 1);
        $product = Product::findOrFail($product_id);
        $cartItem = CartItem::where('user_id', Auth::id())->where('product_id', $product_id)->first();
        
        $currentQuantity = $cartItem ? $cartItem->quantity : 0;
        if ($currentQuantity + $quantity > $product->stock) {
            return back()->with('error', "Maaf, stok tidak mencukupi! Hanya tersisa {$product->stock} unit.");
        }
        
        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            $cartItem = CartItem::create([
                'user_id' => Auth::id(),
                'product_id' => $product_id,
                'quantity' => $quantity
            ]);
        }
        
        if ($request->query('checkout') == 1) {
            return redirect()->route('checkout.index', ['items' => $cartItem->id]);
        }
        
        return back()->with('success', 'Produk ditambahkan ke keranjang!');
    }

    public function update(Request $request, $id)
    {
        $cartItem = CartItem::with('product')->where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        if ($request->quantity > $cartItem->product->stock) {
            return back()->with('error', "Maaf, stok tidak mencukupi! Hanya tersisa {$cartItem->product->stock} unit.");
        }
        if ($request->quantity > 0) {
            $cartItem->update(['quantity' => $request->quantity]);
        }
        return back();
    }

    public function destroy($id)
    {
        CartItem::where('id', $id)->where('user_id', Auth::id())->delete();
        return back();
    }
}
