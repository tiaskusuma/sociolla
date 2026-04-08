<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        // Categorize order counts for the dashboard
        $counts = [
            'not_paid' => $orders->where('status', 'Not Paid')->count(),
            'packed' => $orders->where('status', 'Packed')->count(),
            'in_delivery' => $orders->where('status', 'Delivered')->count(),
            'completed' => $orders->where('status', 'Completed')->count(),
            'rating' => $orders->where('status', 'Rating')->count()
        ];

        return view('profile.index', compact('user', 'orders', 'counts'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = User::find(Auth::id());
        
        $request->validate([
            'username' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'phone' => 'nullable|string|max:20',
            'province' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'gender' => 'nullable|in:Laki-Laki,Perempuan',
            'birth_date' => 'nullable|date',
            'avatar' => 'nullable|image|max:2048'
        ]);

        $user->username = $request->username ?? $user->username;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->province = $request->province;
        $user->city = $request->city;
        $user->address = $request->address;
        $user->gender = $request->gender;
        $user->birth_date = $request->birth_date;

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui!');
    }
}
