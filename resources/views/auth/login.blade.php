@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<form action="{{ route('login') }}" method="POST">
    @csrf
    <div class="auth-input-group">
        <i class="fa-regular fa-user auth-icon"></i>
        <input type="text" name="login" class="auth-input" placeholder="Username/Email" required autofocus>
    </div>
    
    <div class="auth-input-group">
        <i class="fa-solid fa-lock auth-icon"></i>
        <input type="password" name="password" class="auth-input" placeholder="Password" required>
    </div>
    
    <a href="{{ route('password.forgot') }}" class="forgot-password">Forgot Password?</a>
    
    <button type="submit" class="auth-btn">LOGIN</button>
    
    <div class="auth-links">
        <span style="color:#111;">Don't have an account?</span> <a href="{{ route('register') }}">Sign Up</a>
    </div>
</form>
@endsection
