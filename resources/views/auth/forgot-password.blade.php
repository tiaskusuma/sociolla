@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('content')
<h2 style="font-family:'Inter', sans-serif; font-size:1.2rem; margin-bottom:20px; text-align:center; color:#333;">Reset Password</h2>
<p style="font-size:0.8rem; color:#555; text-align:center; margin-bottom:20px; font-family:'Inter', sans-serif;">
    Verifikasi identitas Anda dengan memasukkan Nama Lengkap, Username, Email, dan No Telp yang terdaftar.
</p>



<form action="{{ route('password.update') }}" method="POST">
    @csrf
    
    <div class="auth-input-group">
        <i class="fa-regular fa-user auth-icon"></i>
        <input type="text" name="name" class="auth-input" placeholder="Full Name (Exactly)" required value="{{ old('name') }}">
    </div>
    
    <div class="auth-input-group">
        <i class="fa-solid fa-at auth-icon"></i>
        <input type="text" name="username" class="auth-input" placeholder="Username" required value="{{ old('username') }}">
    </div>
    
    <div class="auth-input-group">
        <i class="fa-regular fa-envelope auth-icon"></i>
        <input type="email" name="email" class="auth-input" placeholder="Email" required value="{{ old('email') }}">
    </div>
    
    <div class="auth-input-group">
        <i class="fa-solid fa-phone auth-icon"></i>
        <input type="text" name="phone" class="auth-input" placeholder="Phone Number" required value="{{ old('phone') }}">
    </div>

    <div style="margin:20px 0; border-top:1px solid #eee;"></div>
    
    <div class="auth-input-group">
        <i class="fa-solid fa-lock auth-icon"></i>
        <input type="password" name="password" class="auth-input" placeholder="New Password" required minlength="4">
    </div>
    
    <div class="auth-input-group">
        <i class="fa-solid fa-lock auth-icon"></i>
        <input type="password" name="password_confirmation" class="auth-input" placeholder="Confirm New Password" required minlength="4">
    </div>
    
    <button type="submit" class="auth-btn" style="margin-top:10px;">RESET PASSWORD</button>
    
    <div class="auth-links">
        <a href="{{ route('login') }}"><i class="fa-solid fa-arrow-left"></i> Back to Login</a>
    </div>
</form>
@endsection
