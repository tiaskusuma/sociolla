<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $tab = $request->query('tab', 'not_paid');
        
        $query = Order::where('user_id', $user->id)->with('items.product')->orderBy('created_at', 'desc');
        
        if ($tab == 'not_paid') {
            $query->where('status', 'Not Paid');
        } elseif ($tab == 'packed') {
            $query->where('status', 'Packed');
        } elseif ($tab == 'delivery') {
            $query->where('status', 'Delivered');
        } elseif ($tab == 'completed') {
            $query->where('status', 'Completed'); 
        } elseif ($tab == 'rating') {
            $query->where('status', 'Rating');
        }
        
        $orders = $query->get();
        return view('order.index', compact('orders', 'tab'));
    }

    public function receive($order_id)
    {
        $order = Order::where('id', $order_id)->where('user_id', Auth::id())->firstOrFail();
        // Since we consider 'Completed' or 'In Delivery' can be marked as received and move to 'Rating'
        $order->update(['status' => 'Rating']);

        return redirect()->route('orders.index', ['tab' => 'rating'])->with('success', 'Pesanan diterima! Silakan berikan penilaian Anda.');
    }

    public function submitRating(Request $request, $order_id)
    {
        $order = Order::where('id', $order_id)->where('user_id', Auth::id())->firstOrFail();
        
        $imagePath = null;
        if ($request->hasFile('rating_image')) {
            $file = $request->file('rating_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/reviews'), $filename);
            $imagePath = 'images/reviews/' . $filename;
        }

        // We update the order to contain the rating details using the new custom columns
        $order->update([
            'is_rated' => true,
            'rating_stars' => $request->rating_stars,
            'rating_review' => $request->rating_review,
            'rating_image' => $imagePath,
            'status' => 'Rating' // Keep it in Rating tab but flag it as rated
        ]);
        
        return redirect()->route('orders.index', ['tab' => 'rating'])->with('success', 'Terima kasih! Ulasan Anda telah berhasil disimpan dan disematkan pada produk.');
    }

    public function cancel($order_id)
    {
        $order = Order::with('items.product')->where('id', $order_id)->where('user_id', Auth::id())->firstOrFail();
        
        if ($order->status == 'Not Paid' && empty($order->payment_proof)) {
            // Restore stock
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                }
            }
            
            $order->update(['status' => 'Canceled']);
            return back()->with('success', 'Pesanan telah berhasil dibatalkan.');
        }

        return back()->with('error', 'Pesanan tidak dapat dibatalkan.');
    }
}
