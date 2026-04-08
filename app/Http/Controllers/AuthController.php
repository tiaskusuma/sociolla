<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $request->validate([
            'login' => 'required',
            'password' => 'required'
        ]);

        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $loginType => $request->login,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $role = Auth::user()->role;
            if ($role === 'admin') return redirect()->intended('/admin/dashboard');
            if ($role === 'petugas') return redirect()->intended('/petugas/dashboard');
            return redirect()->intended('/home');
        }

        return back()->withErrors([
            'login' => 'The provided credentials do not match our records.',
        ])->onlyInput('login');
    }

    public function showRegister() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:4',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'province' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'role' => 'required|in:user,admin,petugas'
        ]);

        $role = $request->role;
        if ($role === 'admin') {
            if ($request->security_token !== env('ADMIN_TOKEN', 'SOCIOLLA123')) {
                return back()->withErrors(['security_token' => 'Invalid Administrator System Token!'])->withInput();
            }
        } elseif ($role === 'petugas') {
            if ($request->security_token !== env('PETUGAS_TOKEN', 'SOCIOLLA123')) {
                return back()->withErrors(['security_token' => 'Invalid Petugas Internal Token!'])->withInput();
            }
        }

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role, 
            'phone' => $request->phone,
            'address' => $request->address,
            'province' => $request->province,
            'city' => $request->city
        ]);

        Auth::login($user);

        if ($role === 'admin') return redirect('/admin/dashboard');
        if ($role === 'petugas') return redirect('/petugas/dashboard');
        return redirect('/home');
    }

    public function showForgotPassword() {
        return view('auth.forgot-password');
    }

    public function processForgotPassword(Request $request) {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'password' => 'required|confirmed|min:4'
        ]);

        $user = User::where('username', $request->username)
                    ->where('email', $request->email)
                    ->where('phone', $request->phone)
                    ->where('name', $request->name)
                    ->first();

        if (!$user) {
            return back()->withErrors(['error' => 'Data tidak cocok dengan akun manapun. Pastikan Nama Lengkap, Username, Email, dan No Telp benar.'])->withInput($request->except('password', 'password_confirmation'));
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login')->with('success', 'Password berhasil diubah. Silakan login dengan password baru.');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
