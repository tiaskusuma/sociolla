<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function show($order_id)
    {
        $order = Order::where('id', $order_id)->where('user_id', Auth::id())->with('items.product')->firstOrFail();
        return view('checkout.payment', compact('order'));
    }

    public function upload(Request $request, $order_id)
    {
        $order = Order::where('id', $order_id)->where('user_id', Auth::id())->firstOrFail();
        
        $request->validate(['proof' => 'required|image|mimes:jpeg,png,jpg|max:5120']);
        
        $path = null;
        if ($request->hasFile('proof')) {
            $file = $request->file('proof');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/payments'), $filename);
            $path = asset('images/payments/' . $filename);
        }

        $order->update([
            'payment_proof' => $path
        ]);

        return redirect()->route('checkout.success', ['order_id' => $order->id])->with('success', 'Pembayaran berhasil dikonfirmasi! Pesanan Anda sedang diproses.');
    }
}
