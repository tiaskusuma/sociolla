@extends('layouts.app')
@section('title', 'Order Succeeded')

@section('content')

<div style="position:fixed; top:0; left:0; right:0; bottom:0; background:#BADFDB; z-index:-1;"></div>



<div style="padding: 40px 0; text-align:center;">
    <h1 style="font-family: 'Playfair Display', serif; font-size: 3.5rem; color: #111; margin: 0 0 30px 0;">Order Succeeded</h1>
    
    <div style="background: white; border-radius: 20px; max-width: 500px; margin: 0 auto; padding: 50px 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
        
        <div style="width: 80px; height: 80px; border-radius: 50%; background: #4ade80; display:flex; align-items:center; justify-content:center; color:white; font-size:2.5rem; margin: 0 auto 20px auto; border: 5px solid #dcfce7;">
            <i class="fa-solid fa-check"></i>
        </div>
        
        <h2 style="font-size: 2.2rem; color: #111; margin: 0 0 15px 0;">Done!</h2>
        
        <div style="font-size: 1.1rem; color: #333; margin-bottom: 5px;">{{ $order->created_at->format('F d, Y') }}</div>
        <div style="font-size: 0.9rem; color: #888; margin-bottom: 30px;">at {{ $order->created_at->format('h:i A') }}</div>
        
        <div style="background: #f9f9f9; padding: 15px; border-radius: 10px; font-weight: bold; font-size: 0.85rem; letter-spacing: 1px; color: #666; margin-bottom: 40px; display:inline-block;">
            TRANSACTION ID <span style="color:#111; margin-left:10px;">#SC-{{ 1000000 + $order->id }}</span>
        </div>
        
        <div style="display:flex; justify-content:center; gap: 20px;">
            <a href="{{ route('home') }}" style="display:inline-block; background: #F9A3A3; color: white; text-decoration:none; padding: 15px 30px; border-radius: 8px; font-weight: bold; font-size: 0.9rem;">ORDER AGAIN</a>
            <a href="{{ route('orders.index') }}" style="display:inline-block; background: white; border: 1px solid #F9A3A3; color: #F9A3A3; text-decoration:none; padding: 15px 30px; border-radius: 8px; font-weight: bold; font-size: 0.9rem;">SEE DETAILS</a>
        </div>
        
    </div>
</div>

<!-- Pink footer specific to UI 2 -->
<div style="background: #F9A3A3; color:white; padding: 30px 40px; display:flex; justify-content:space-between; align-items:center; font-size:0.8rem; margin-top:50px;">
    <div>© {{ date('Y') }} Sociolla. All beauty rights reserved.</div>
    <div style="display:flex; gap: 20px;">
        <a href="#" style="color:white; text-decoration:none;">Privacy Policy</a>
        <a href="#" style="color:white; text-decoration:none;">Terms of Service</a>
        <a href="#" style="color:white; text-decoration:none;">Contact Us</a>
    </div>
</div>



@endsection
