<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // === METHOD UNTUK USER/CUSTOMER ===
    
    public function index()
    {
        $user = Auth::user();
        // Kalau admin/petugas coba masuk url ini, redirect ke halaman admin
        if(in_array($user->role, ['admin', 'petugas'])) {
            $prefix = $user->role === 'admin' ? 'admin' : 'petugas';
            return redirect()->route($prefix . '.chats.index');
        }

        $messages = Message::where('customer_id', $user->id)
                           ->orderBy('created_at', 'asc')->get();
                           
        return view('chat.index', compact('messages'));
    }

    public function store(Request $request)
    {
        $request->validate(['message' => 'required|string']);
        $user = Auth::user();

        Message::create([
            'customer_id' => $user->id,
            'sender_id' => $user->id,
            'message' => $request->message
        ]);

        return back();
    }

    // === METHOD UNTUK ADMIN/PETUGAS ===

    public function indexAdmin()
    {
        // Ambil semua customer yang punya riwayat chat
        $customerIds = Message::select('customer_id')->distinct()->pluck('customer_id');
        $customers = User::whereIn('id', $customerIds)->get();

        return view('admin.chats.index', compact('customers'));
    }

    public function showAdmin($customer_id)
    {
        $customer = User::findOrFail($customer_id);
        $messages = Message::where('customer_id', $customer_id)
                           ->orderBy('created_at', 'asc')->get();
                           
        return view('admin.chats.show', compact('customer', 'messages'));
    }

    public function storeAdmin(Request $request, $customer_id)
    {
        $request->validate(['message' => 'required|string']);
        
        // Sender adalah Auth::id() yang mengindikasikan bahwa ini dibalas oleh admin/petugas
        Message::create([
            'customer_id' => $customer_id,
            'sender_id' => Auth::id(),
            'message' => $request->message
        ]);

        return back();
    }
}
