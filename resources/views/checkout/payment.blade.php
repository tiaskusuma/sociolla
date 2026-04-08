@extends('layouts.app')
@section('title', 'Payment Confirmation')
@section('content')

<!-- Temporary background overriding just for parsing visual match exactly like design image -->
<div style="position:fixed; top:0; left:0; right:0; bottom:0; background:#BADFDB; z-index:-1;"></div>

<div style="max-width: 500px; margin: 40px auto; background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
    
    <div style="padding: 40px 40px 20px 40px; text-align:center;">
        <h1 style="font-family: 'Great Vibes', cursive, serif; font-size: 2rem; margin: 0 0 10px 0; color: #111;">Confirm Your Payment</h1>
        <p style="color: #888; font-size: 0.85rem; margin: 0;">Please upload your proof of transfer to complete your order</p>
    </div>
    
    <!-- Order Summary inside card -->
    <div style="padding: 0 40px;">
        <div style="background: #f9f9f9; border-radius:10px; padding:20px;">
            <div style="font-size:0.7rem; color:#aaa; font-weight:bold; margin-bottom:15px; letter-spacing:1px;">ORDER SUMMARY</div>
            
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                <div style="display:flex; align-items:center; gap:15px;">
                    <div style="width:40px; height:40px; background:#e0a0a0; border-radius:5px; display:flex; align-items:center; justify-content:center; color:white;">
                        <i class="fa-solid fa-bag-shopping"></i>
                    </div>
                    <div>
                        <div style="font-weight:bold; font-size:0.9rem;">Order #{{ $order->id }}</div>
                        <div style="color:#888; font-size:0.8rem;">Qty: {{ $order->items->sum('quantity') }}</div>
                    </div>
                </div>
                <div style="color:#F9A3A3; font-weight:bold;">IDR {{ number_format($order->total_amount, 0, ',', '.') }}</div>
            </div>
            
            <div style="height:1px; background:#eaeaea; margin-bottom:15px;"></div>
            
            <div style="display:flex; justify-content:space-between; align-items:center; font-weight:bold; font-size:0.9rem;">
                <div>Total Amount</div>
                <div style="font-size:1.1rem; color:#111;">IDR {{ number_format($order->total_amount, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
    
    <!-- Scan QRIS Section -->
    <div style="padding: 0 40px; text-align: center; margin-top: 20px;">
        <div style="font-size:0.8rem; font-weight:bold; color:#555; margin-bottom:10px;">Scan QRIS To Pay</div>
        <img src="/sociolla/public/images/qris.jpg" alt="QRIS Payment" style="width: 200px; border-radius: 10px; border: 1px solid #eaeaea; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
        <div style="font-size:0.75rem; color:#888; margin-top: 10px;">Silakan *scan* barcode di atas menggunakan aplikasi *mobile banking* atau *e-wallet* Anda.</div>
    </div>
    
    <!-- Upload Form -->
    <form action="{{ route('payment.upload', $order->id) }}" method="POST" enctype="multipart/form-data" style="padding: 30px 40px;">
        @csrf
        
        <div style="font-size:0.8rem; font-weight:bold; color:#555; margin-bottom:10px;">Proof of Transfer</div>
        
        <label style="display:block; border: 2px dashed #F9A3A3; background: #fffcfc; border-radius: 10px; padding: 40px 20px; text-align:center; cursor:pointer; margin-bottom:20px;">
            <i class="fa-solid fa-cloud-arrow-up" style="color:#F9A3A3; font-size:2rem; margin-bottom:15px;" id="proof-icon"></i>
            <div style="font-size:0.85rem; color:#333; margin-bottom:5px;" id="proof-text">Click or drag to upload proof of transfer</div>
            <div style="font-size:0.7rem; color:#aaa;" id="proof-sub">JPG. PNG. PDF UP TO 5MB</div>
            <input type="file" name="proof" id="proof-input" style="display:none;" accept="image/png, image/jpeg, image/jpg" required onchange="document.getElementById('proof-text').innerText = this.files[0].name; document.getElementById('proof-text').style.color = '#F9A3A3'; document.getElementById('proof-text').style.fontWeight = 'bold'; document.getElementById('proof-icon').className = 'fa-solid fa-check-circle'; document.getElementById('proof-sub').innerText = 'File Selected';">
        </label>
        
        <div style="margin-bottom:20px;">
            <div style="font-size:0.8rem; font-weight:bold; color:#555; margin-bottom:10px;">Sender Name</div>
            <input type="text" placeholder="e.g. Jane Doe" required style="width:100%; box-sizing:border-box; padding:12px 15px; border:1px solid #ddd; border-radius:5px; outline:none;">
        </div>
        
        <div style="margin-bottom:30px;">
            <div style="font-size:0.8rem; font-weight:bold; color:#555; margin-bottom:10px;">Date of Transfer</div>
            <input type="date" required style="width:100%; box-sizing:border-box; padding:12px 15px; border:1px solid #ddd; border-radius:5px; outline:none; color:#555;">
        </div>
        
        <button type="submit" style="width:100%; background:#F9A3A3; color:white; border:none; padding:15px; border-radius:30px; font-weight:bold; font-size:0.9rem; cursor:pointer;">
            SUBMIT PROOF
        </button>
    </form>
    
    <div style="background:#fafafa; border-top:1px solid #eaeaea; text-align:center; padding:15px; font-size:0.7rem; color:#aaa; display:flex; align-items:center; justify-content:center; gap:5px;">
        <i class="fa-solid fa-shield-halved"></i> SECURE PAYMENT ENCRYPTED TRANSACTION
    </div>
</div>

<div style="text-align:center; padding: 20px; color:white; font-family:'Great Vibes', cursive, serif; font-size:1.5rem;">
    Your Daily Beauty Destination
</div>

@endsection
