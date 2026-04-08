@extends('layouts.app')
@section('title', 'Bukti Transfer')

@section('content')

<!-- Hide main layout pieces to match Image 1 standalone UI -->
<style>
    #main-header { display: none !important; }
    body > div:last-child { display:none;} /* hide footer */
</style>

<div style="position:fixed; top:0; left:0; right:0; bottom:0; background:#BADFDB; z-index:-1;"></div>

<div style="padding: 20px 40px;">
    <h1 style="color: #888; font-family:'Inter', sans-serif; font-size:1.5rem; font-weight:normal; margin: 0;">Bukti Transfer</h1>
</div>

<div style="display:flex; justify-content:center; padding: 20px 0 60px 0;">
    
    <div style="background: white; border-radius: 20px; width: 450px; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); text-align:center;">
        
        <div style="width: 60px; height: 60px; border-radius: 50%; background: #4ade80; display:flex; align-items:center; justify-content:center; color:white; font-size:1.8rem; margin: 0 auto 15px auto;">
            <i class="fa-solid fa-check"></i>
        </div>
        
        <div style="display:flex; align-items:baseline; justify-content:center; gap:5px; margin-bottom:5px;">
            <span style="font-size:0.8rem; color:#888; font-weight:bold;">IDR.</span>
            <span style="font-size:2.2rem; font-weight:bold; color:#111;">{{ number_format($order->total_amount, 0, ',', '.') }}</span>
        </div>
        
        <div style="font-size:0.8rem; color:#888; margin-bottom:5px;">{{ $order->updated_at->format('m/d/Y H.i') }}</div>
        <div style="color:#4ade80; font-weight:bold; font-size:0.85rem; letter-spacing:1px; margin-bottom:30px;">DONE</div>
        
        <div style="height:1px; background:#eaeaea; margin-bottom:20px;"></div>
        
        <!-- Table -->
        <div style="text-align:left; font-size:0.8rem; margin-bottom:20px;">
            <div style="display:flex; justify-content:space-between; margin-bottom:15px;">
                <span style="color:#888;">NO TRANSACTION</span>
                <strong style="color:#111;">01222026193513{{ $order->id }}</strong>
            </div>
            <div style="display:flex; justify-content:space-between; margin-bottom:15px;">
                <span style="color:#888;">RECIPIENT NAME</span>
                <strong style="color:#111;">Sociolla Official</strong>
            </div>
            <div style="display:flex; justify-content:space-between; margin-bottom:15px;">
                <span style="color:#888;">PRODUCT NAME</span>
                @php $firstObj = $order->items->first(); @endphp
                <strong style="color:#111; max-width: 200px; text-align:right;">{{ $firstObj ? $firstObj->product->name : 'Beauty Product' }}</strong>
            </div>
            <div style="display:flex; justify-content:space-between; margin-bottom:15px;">
                <span style="color:#888;">SENDER</span>
                <strong style="color:#111; text-transform:uppercase;">{{ $order->user->name }}</strong>
            </div>
        </div>
        
        <div style="height:1px; background:#eaeaea; margin-bottom:20px;"></div>
        
        <!-- Fee Table -->
        <div style="text-align:left; font-size:0.8rem; margin-bottom:20px;">
            <div style="display:flex; justify-content:space-between; margin-bottom:15px;">
                <span style="color:#888;">ADMIN FEE</span>
                <strong style="color:#111;">Rp.0</strong>
            </div>
            <div style="display:flex; justify-content:space-between; margin-bottom:15px;">
                <span style="color:#888;">PAYMENT AMOUNT</span>
                <strong style="color:#111;">Rp. {{ number_format($order->total_amount, 0, ',', '.') }}</strong>
            </div>
            <div style="display:flex; justify-content:space-between; margin-bottom:15px; margin-top:25px;">
                <strong style="color:#111;">TOTAL PAYMENT</strong>
                <strong style="color:#111; font-size:0.95rem;">Rp. {{ number_format($order->total_amount, 0, ',', '.') }}</strong>
            </div>
        </div>
        
        <div style="height:1px; background:#eaeaea; margin-bottom:20px;"></div>
        
        <div style="text-align:left; font-size:0.8rem; margin-bottom:35px;">
            <div style="display:flex; justify-content:space-between; margin-bottom:15px;">
                <span style="color:#888;">TRANSACTION TYPE</span>
                <strong style="color:#111;">{{ $order->payment_method }}</strong>
            </div>
            <div style="display:flex; justify-content:space-between;">
                <span style="color:#888;">DESCRIPTION</span>
                <strong style="color:#111;">Shopping Order</strong>
            </div>
        </div>
        
        <a href="{{ route('home') }}" style="display:block; width:100%; box-sizing:border-box; background:#F9A3A3; color:white; padding:15px; border-radius:10px; font-weight:bold; font-size:0.9rem; text-decoration:none; margin-bottom:15px;">SAVE RECEIPT</a>
        
        <a href="{{ route('home') }}" style="color:#888; text-decoration:none; font-size:0.8rem; font-weight:bold; letter-spacing:1px; display:block; margin-bottom:30px;">BACK TO HOME</a>
        
        <div style="font-size:0.7rem; color:#aaa; display:flex; align-items:center; justify-content:center; gap:5px; border-top: 1px solid #eaeaea; padding-top:20px;">
            <i class="fa-solid fa-shield-halved"></i> SECURE MALLARA TRANSACTION
        </div>
        
    </div>
    
</div>

@endsection
