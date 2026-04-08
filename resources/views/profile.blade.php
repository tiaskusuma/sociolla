@extends('layouts.app')
@section('title', 'Profile')
@section('content')
<div class="profile-container">
    <!-- Left panel (Profile details) -->
    <div style="background-color: var(--primary-pink); border-radius: 20px; padding: 40px; color: white;">
        <div style="text-align: center;">
            <div class="avatar"><i class="fa-regular fa-user"></i></div>
            <h2 style="margin: 0 0 5px 0;">{{ $user->name ?? 'User' }}</h2>
            <div class="diamond-tag">Diamond Member</div>
        </div>
        
        <div class="profile-details">
            <div class="detail-row">
                <span class="label">Name</span>
                <span>{{ $user->name ?? 'N/A' }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Email</span>
                <span>{{ $user->email ?? 'N/A' }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Phone</span>
                <span>{{ $user->phone ?? 'N/A' }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Birth</span>
                <span>{{ $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->format('F jS Y') : 'March 16th 2008' }}</span>
            </div>
        </div>
        
        <button class="profile-btn">Edit Profile Details</button>
        
        <div class="logout-btn-wrapper">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout Account</button>
            </form>
        </div>
    </div>
    
    <!-- Right panel -->
    <div class="right-panel">
        <div class="info-card">
            <h3>
                <span class="left"><i class="fa-solid fa-location-dot"></i> Delivery Address</span>
            </h3>
            <div class="address-info">
                <strong>{{ $user->name }}</strong>
                {{ $user->phone }}<br>
                {{ $user->address ?? 'Jl. Sakura Blok S No. 107, SUKMAJAYA, KOTA DEPOK, JAWA BARAT, ID 12345' }}
            </div>
            <a href="#" class="edit-link" style="display:block; margin-top:20px;">Edit Address ></a>
        </div>
        
        <div class="info-card" style="padding-bottom: 50px;">
            <h3>
                <span class="left"><i class="fa-solid fa-bag-shopping"></i> My Orders</span>
                <a href="#" class="edit-link" style="color: #666;">View History ></a>
            </h3>
            
            <div class="orders-tracking">
                <div class="track-step">
                    <div class="icon"><i class="fa-solid fa-file-invoice"></i></div>
                    Not Paid
                    <span class="desc">2 Orders</span>
                </div>
                <div class="track-step">
                    <div class="icon"><i class="fa-solid fa-box-open"></i></div>
                    Packed
                    <span class="desc">0 Orders</span>
                </div>
                <!-- Highlight 'In Delivery' as in the design -->
                <div class="track-step active">
                    <div class="icon"><i class="fa-solid fa-truck-fast"></i></div>
                    In Delivery
                    <span class="desc" style="color: var(--primary-pink);">1 Order</span>
                </div>
                <div class="track-step">
                    <div class="icon"><i class="fa-solid fa-circle-check"></i></div>
                    Completed
                    <span class="desc">15 Orders</span>
                </div>
                <div class="track-step">
                    <div class="icon"><i class="fa-regular fa-star"></i></div>
                    Rating
                    <span class="desc">Need Review</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
