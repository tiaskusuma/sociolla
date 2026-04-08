@extends('layouts.app')
@section('title', 'My Profile')
@section('content')

<div style="max-width: 1000px; margin: 40px auto; display:flex; gap: 30px;">
    
    <!-- LEFT: Profile Card -->
    <div style="width: 320px; background: linear-gradient(180deg, #f78c8c 0%, #faa0a0 100%); border-radius: 20px; padding: 40px 30px; color: white; text-align: center; box-shadow: 0 10px 20px rgba(249,163,163,0.3); align-self: flex-start;">
        
        <div style="width: 100px; height: 100px; border-radius: 20px; background: rgba(255,255,255,0.2); margin: 0 auto 20px auto; display:flex; align-items:center; justify-content:center; border: 2px solid rgba(255,255,255,0.4); overflow:hidden;">
            @if($user->avatar)
                <img src="{{ route('user.avatar') }}?t={{ time() }}" style="width:100px; height:100px; object-fit:cover;">
            @else
                <i class="fa-solid fa-circle-user" style="font-size: 3rem;"></i>
            @endif
        </div>
        
        <h2 style="font-family: 'Playfair Display', serif; font-size: 2.2rem; margin: 0 0 5px 0;">{{ $user->name }}</h2>
        
        <div style="text-align: left; font-size: 0.85rem; display:flex; flex-direction:column; gap:20px; margin-bottom: 40px;">
            <div style="display:flex; justify-content:space-between; border-bottom:1px solid rgba(255,255,255,0.2); padding-bottom:5px;">
                <span style="opacity:0.8;">NAME</span> <strong>{{ $user->name }}</strong>
            </div>
            <div style="display:flex; justify-content:space-between; border-bottom:1px solid rgba(255,255,255,0.2); padding-bottom:5px;">
                <span style="opacity:0.8;">EMAIL</span> <strong>{{ $user->email }}</strong>
            </div>
            <div style="display:flex; justify-content:space-between; border-bottom:1px solid rgba(255,255,255,0.2); padding-bottom:5px;">
                <span style="opacity:0.8;">PHONE</span> <strong>{{ $user->phone ?? '-' }}</strong>
            </div>
            <div style="display:flex; justify-content:space-between; border-bottom:1px solid rgba(255,255,255,0.2); padding-bottom:5px;">
                <span style="opacity:0.8;">BIRTH</span> <strong>{{ $user->birth_date ? date('M d Y', strtotime($user->birth_date)) : '-' }}</strong>
            </div>
        </div>
        
        <a href="{{ route('profile.edit') }}" style="display:block; width:100%; box-sizing:border-box; background: white; color: #F9A3A3; padding: 15px; border-radius: 30px; font-weight: bold; text-decoration: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">Edit Profile Details</a>
        
        <form action="{{ route('logout') }}" method="POST" style="margin-top:20px;">
            @csrf
            <button type="submit" style="width:100%; background: none; border: 2px solid white; color: white; padding: 15px; border-radius: 30px; font-weight: bold; cursor: pointer;"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout Account</button>
        </form>
        
    </div>
    
    <!-- RIGHT: Info Cards -->
    <div style="flex:1; display:flex; flex-direction:column; gap: 30px;">
        
        <!-- Address Card -->
        <div style="background: white; border-radius: 20px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
            <div style="display:flex; align-items:center; gap:10px; margin-bottom:20px;">
                <i class="fa-solid fa-location-dot" style="color:#F9A3A3; font-size:1.2rem;"></i>
                <h3 style="margin:0; font-family:'Playfair Display', serif; font-size:1.6rem; color:#111;">Delivery Address</h3>
            </div>
            
            <div style="font-weight:bold; font-size:1.1rem; margin-bottom:10px;">{{ $user->name }}</div>
            <div style="color:#888; font-size:0.85rem; margin-bottom:5px;">(+62) {{ $user->phone ?? '812-3456-7890' }}</div>
            <div style="color:#888; font-size:0.85rem; line-height:1.5; margin-bottom:20px; max-width: 300px;">
                {{ $user->address ?? 'Jl. Sakura Blok S No. 107, SUKMAJAYA, KOTA DEPOK, JAWA BARAT, ID 12345' }}
            </div>
            
        </div>
        
        <!-- Orders Card -->
        <div style="background: white; border-radius: 20px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 30px;">
                <div style="display:flex; align-items:center; gap:10px;">
                    <i class="fa-solid fa-bag-shopping" style="color:#F9A3A3; font-size:1.2rem;"></i>
                    <h3 style="margin:0; font-family:'Playfair Display', serif; font-size:1.6rem; color:#111;">My Orders</h3>
                </div>
                <a href="{{ route('orders.index') }}" style="color:#888; font-size:0.85rem; text-decoration:none;">View History <i class="fa-solid fa-chevron-right" style="font-size:0.7rem; margin-left:3px;"></i></a>
            </div>
            
            <div style="display:flex; justify-content:space-between; align-items:center; text-align:center;">
                <!-- Icon 1 -->
                <a href="{{ route('orders.index', ['tab' => 'not_paid']) }}" style="color:inherit; text-decoration:none;">
                     <div style="width:60px; height:60px; margin:0 auto 10px auto; background:#f9f9f9; border-radius:15px; display:flex; align-items:center; justify-content:center; color:#ccc; font-size:1.5rem; transition: 0.2s;">
                         <i class="fa-solid fa-file-invoice-dollar"></i>
                     </div>
                     <div style="font-size:0.75rem; font-weight:bold; color:#111;">Not Paid</div>
                     <div style="font-size:0.6rem; color:#aaa;">{{ $counts['not_paid'] }} Orders</div>
                </a>
                <!-- Icon 2 -->
                <a href="{{ route('orders.index', ['tab' => 'packed']) }}" style="color:inherit; text-decoration:none;">
                     <div style="width:60px; height:60px; margin:0 auto 10px auto; background:#f9f9f9; border-radius:15px; display:flex; align-items:center; justify-content:center; color:#ccc; font-size:1.5rem; transition: 0.2s;">
                         <i class="fa-solid fa-box"></i>
                     </div>
                     <div style="font-size:0.75rem; font-weight:bold; color:#111;">Packed</div>
                     <div style="font-size:0.6rem; color:#aaa;">{{ $counts['packed'] }} Orders</div>
                </a>
                <!-- Icon 3 (Active) -->
                <a href="{{ route('orders.index', ['tab' => 'delivery']) }}" style="color:inherit; text-decoration:none;">
                     <div style="width:60px; height:60px; margin:0 auto 10px auto; background:#fff5f5; border: 2px solid #F9A3A3; border-radius:15px; display:flex; align-items:center; justify-content:center; color:#F9A3A3; font-size:1.5rem; transition: 0.2s;">
                         <i class="fa-solid fa-truck-fast"></i>
                     </div>
                     <div style="font-size:0.75rem; font-weight:bold; color:#F9A3A3;">In Delivery</div>
                     <div style="font-size:0.6rem; color:#faa;">{{ $counts['in_delivery'] }} Order</div>
                </a>
                <!-- Icon 4 -->
                <a href="{{ route('orders.index', ['tab' => 'completed']) }}" style="color:inherit; text-decoration:none;">
                     <div style="width:60px; height:60px; margin:0 auto 10px auto; background:#f9f9f9; border-radius:15px; display:flex; align-items:center; justify-content:center; color:#ccc; font-size:1.5rem; transition: 0.2s;">
                         <i class="fa-regular fa-circle-check"></i>
                     </div>
                     <div style="font-size:0.75rem; font-weight:bold; color:#111;">Completed</div>
                     <div style="font-size:0.6rem; color:#aaa;">{{ $counts['completed'] }} Orders</div>
                </a>
                <!-- Icon 5 -->
                <a href="{{ route('orders.index', ['tab' => 'rating']) }}" style="color:inherit; text-decoration:none;">
                     <div style="width:60px; height:60px; margin:0 auto 10px auto; background:#f9f9f9; border-radius:15px; display:flex; align-items:center; justify-content:center; color:#ccc; font-size:1.5rem; transition: 0.2s;">
                         <i class="fa-regular fa-star"></i>
                     </div>
                     <div style="font-size:0.75rem; font-weight:bold; color:#111;">Rating</div>
                     <div style="font-size:0.6rem; color:#aaa;">Need Review</div>
                </a>
            </div>
            
        </div>
        
    </div>
</div>

@endsection
