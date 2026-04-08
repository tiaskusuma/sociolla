<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        if ($request->has('product_id') && $request->has('qty')) {
            // Direct Buy Mode
            $product_id = $request->product_id;
            $qty = collect(is_array($request->qty) ? $request->qty : [$request->qty])->first();
            $product = \App\Models\Product::findOrFail($product_id);
            
            if ($qty > $product->stock) {
                return back()->with('error', "Stok untuk {$product->name} tidak mencukupi. (Tersisa: {$product->stock})");
            }
            
            $item = new CartItem([
                'id' => 0,
                'user_id' => $user->id,
                'product_id' => $product->id,
                'quantity' => $qty
            ]);
            $item->setRelation('product', $product);
            $cartItems = collect([$item]);
            $itemIds = 'direct:' . $product->id . ':' . $qty;
            
            $total = $qty * $product->price;
            return view('checkout.index', compact('cartItems', 'total', 'user', 'itemIds'));
        }
        
        // Cart Checkout Mode
        $itemIds = $request->input('items', '');
        if (!$itemIds) return redirect()->route('cart.index')->with('error', 'Pilih item terlebih dahulu.');
        $idsForQuery = explode(',', $itemIds);
        
        $cartItems = CartItem::where('user_id', $user->id)->whereIn('id', $idsForQuery)->with('product')->get();
        if ($cartItems->count() == 0) return redirect()->route('home');
        
        foreach ($cartItems as $item) {
            if ($item->quantity > $item->product->stock) {
                return redirect()->route('cart.index')->with('error', "Stok untuk {$item->product->name} telah habis/kurang. (Tersisa: {$item->product->stock})");
            }
        }

        $total = $cartItems->sum(function($item) {
            return $item->quantity * $item->product->price;
        });
        
        return view('checkout.index', compact('cartItems', 'total', 'user', 'itemIds'));
    }

    public function process(Request $request)
    {
        $user = Auth::user();
        
        $itemIds = $request->input('items', '');
        if (!$itemIds) return back();
        
        // Use the requested design values: shipping address
        $address = $request->input('shipping_address') ?: ($user->address ?: 'Jl. Merpati Blok S No. 107, SUKMAJAYA KOTA DEPOK, JAWA BARAT, ID 12345');
        $method = $request->input('payment_method', 'Bank Transfer');
        
        if (str_starts_with($itemIds, 'direct:')) {
            $parts = explode(':', $itemIds);
            $product = \App\Models\Product::findOrFail($parts[1]);
            $qty = $parts[2];
            
            if ($qty > $product->stock) {
                 return redirect()->route('home')->with('error', "Gagal checkout. Stok untuk {$product->name} tidak mencukupi.");
            }
            
            $total = $product->price * $qty;
            
            $order = Order::create([
                'user_id' => $user->id,
                'status' => 'Not Paid',
                'total_amount' => $total,
                'shipping_address' => $address,
                'payment_method' => $method
            ]);
            
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $qty,
                'price' => $product->price
            ]);
            
            $product->decrement('stock', $qty);
            
            if ($method === 'Cash on Delivery' || $method === 'COD') {
                return redirect()->route('checkout.success', ['order_id' => $order->id])->with('success', 'Pesanan Pending (COD) berhasil dicatat.');
            }
    
            return redirect()->route('payment.show', ['order_id' => $order->id]);
        }
        
        // Cart Mode
        $idsForQuery = explode(',', $itemIds);
        $cartItems = CartItem::where('user_id', $user->id)->whereIn('id', $idsForQuery)->with('product')->get();
        if ($cartItems->count() == 0) return back();
        
        foreach ($cartItems as $item) {
            if ($item->quantity > $item->product->stock) {
                return redirect()->route('cart.index')->with('error', "Gagal checkout. Stok untuk {$item->product->name} tidak mencukupi. (Tersisa: {$item->product->stock})");
            }
        }

        $total = $cartItems->sum(function($item) {
            return $item->quantity * $item->product->price;
        });
        
        $order = Order::create([
            'user_id' => $user->id,
            'status' => 'Not Paid',
            'total_amount' => $total,
            'shipping_address' => $address,
            'payment_method' => $method
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price
            ]);
            
            // Decuct the actual product stock natively!
            $item->product->decrement('stock', $item->quantity);
        }

        // Delete only checked out items
        CartItem::where('user_id', $user->id)->whereIn('id', $idsForQuery)->delete();

        if ($method === 'Cash on Delivery' || $method === 'COD') {
            return redirect()->route('checkout.success', ['order_id' => $order->id])->with('success', 'Pesanan Pending (COD) berhasil dicatat.');
        }

        return redirect()->route('payment.show', ['order_id' => $order->id]);
    }
    
    public function success($order_id)
    {
        $order = Order::findOrFail($order_id);
        if($order->user_id != Auth::id()) abort(403);
        
        return view('checkout.success', compact('order'));
    }
}
