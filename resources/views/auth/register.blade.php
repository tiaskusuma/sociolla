@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<form action="{{ route('register') }}" method="POST">
    @csrf
    <div class="auth-input-group">
        <i class="fa-regular fa-user auth-icon"></i>
        <input type="text" name="name" class="auth-input" placeholder="Name..." required autofocus>
    </div>

    <div class="auth-input-group">
        <i class="fa-regular fa-user auth-icon"></i>
        <input type="text" name="username" class="auth-input" placeholder="Username..." required>
    </div>
    
    <div class="auth-input-group">
        <i class="fa-regular fa-envelope auth-icon"></i>
        <input type="email" name="email" class="auth-input" placeholder="Email..." required>
    </div>
    
    <div class="auth-input-group">
        <i class="fa-regular fa-user auth-icon"></i>
        <input type="text" name="phone" class="auth-input" placeholder="Your Number...">
    </div>
    
    <div class="auth-input-group" id="address-group">
        <i class="fa-solid fa-location-dot auth-icon"></i>
        <input type="text" name="address" id="address_input" class="auth-input" placeholder="Address...">
    </div>
    
    <div class="auth-input-group address-detail-group">
        <i class="fa-solid fa-map auth-icon"></i>
        <input type="text" name="province" id="province_input" class="auth-input" placeholder="Province...">
    </div>

    <div class="auth-input-group address-detail-group">
        <i class="fa-solid fa-city auth-icon"></i>
        <input type="text" name="city" id="city_input" class="auth-input" placeholder="City...">
    </div>

    <div class="auth-input-group">
        <i class="fa-solid fa-lock auth-icon"></i>
        <input type="password" name="password" class="auth-input" placeholder="Enter Password..." required>
    </div>

    <!-- Role Selection -->
    <div class="auth-input-group" style="padding-right: 15px;">
        <i class="fa-solid fa-user-tag auth-icon"></i>
        <select name="role" id="role-select" class="auth-input" style="cursor: pointer; appearance: auto;" onchange="toggleSecurityToken()">
            <option value="user">Customer (User)</option>
            <option value="admin">Administrator</option>
            <option value="petugas">Petugas Gudang</option>
        </select>
    </div>

    <!-- Security Token (Hidden by default) -->
    <div class="auth-input-group" id="security-token-group" style="display: none;">
        <i class="fa-solid fa-key auth-icon" style="color: #F9A3A3;"></i>
        <input type="text" name="security_token" id="security_token" class="auth-input" placeholder="Secret Security Token...">
    </div>
    
    <button type="submit" class="auth-btn">Regist</button>

    <script>
        function toggleSecurityToken() {
            var role = document.getElementById('role-select').value;
            var tokenGroup = document.getElementById('security-token-group');
            var tokenInput = document.getElementById('security_token');
            var addressGroup = document.getElementById('address-group');
            var addressInput = document.getElementById('address_input');
            var detailGroups = document.querySelectorAll('.address-detail-group');
            var provinceInput = document.getElementById('province_input');
            var cityInput = document.getElementById('city_input');
            
            if(role === 'admin' || role === 'petugas') {
                tokenGroup.style.display = 'flex';
                tokenInput.required = true;
                addressGroup.style.display = 'none';
                addressInput.value = ''; // clear address if hidden
                detailGroups.forEach(el => el.style.display = 'none');
                provinceInput.value = '';
                cityInput.value = '';
            } else {
                tokenGroup.style.display = 'none';
                tokenInput.required = false;
                tokenInput.value = '';
                addressGroup.style.display = 'flex';
                detailGroups.forEach(el => el.style.display = 'flex');
            }
        }
    </script>
    
    <div class="auth-links">
        <span style="color:#111;">Have an account?</span> <a href="{{ route('login') }}">Sign In</a>
    </div>
</form>
@endsection
