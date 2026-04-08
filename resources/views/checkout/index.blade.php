@extends('layouts.app')
@section('title', 'Checkout')
@section('content')

<div style="max-width: 1000px; margin: 40px auto; background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
    
    <!-- Header -->
    <div style="padding: 40px; background: white;">
        <h1 style="font-family: 'Great Vibes', cursive, serif; font-size: 2.5rem; margin: 0 0 10px 0; color: #111;">Check Out</h1>
        <p style="color: #666; margin: 0;">Please review your order details and delivery address.</p>
    </div>
    
    <!-- Shipping Address -->
    <div style="background: #BADFDB; padding: 20px 40px;">
        <div style="display:flex; justify-content:space-between; margin-bottom: 20px;">
            <strong style="color: #111; font-size:1.1rem; text-transform:uppercase;">Shipping Address</strong>
            <a href="{{ route('profile.edit') }}" style="color: #e91e63; text-decoration:none; font-size:0.8rem;">Change Address</a>
        </div>
        <div style="display:flex; gap: 20px;">
            <div style="width:40px; height:40px; border-radius:50%; background:#f472b6; color:white; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fa-solid fa-location-dot"></i>
            </div>
            <div style="flex:1;">
                <div style="font-weight:bold; margin-bottom:5px;">{{ $user->name }}</div>
                <div style="color:#555; font-size:0.9rem; margin-bottom:5px;">(+62) {{ $user->phone ?? '812-3456-7890' }}</div>
                <div style="color:#555; font-size:0.9rem;">
                    @if($user->address || $user->city || $user->province)
                        {{ $user->address }}
                        @if($user->city || $user->province)
                            <br>
                            {{ $user->city }}{{ ($user->city && $user->province) ? ', ' : '' }}{{ $user->province }}
                        @endif
                    @else
                        Jl. Merpati Blok S No. 107, SUKMAJAYA, KOTA DEPOK, JAWA BARAT, ID 12345
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Order Summary -->
    <div style="background: #e0f2f1; padding: 20px 40px 40px 40px;">
        <strong style="color: #111; font-size:1.1rem; text-transform:uppercase; margin-bottom: 20px; display:block;">Order Summary</strong>
        
        <div style="background: white; border-radius: 10px; padding: 20px; display:flex; flex-direction:column; gap:20px;">
            @foreach($cartItems as $item)
            <div style="display:flex; align-items:center; gap:20px;">
                <img src="{{ $item->product->image_url }}" style="width:80px; height:80px; object-fit:contain; background:#f9f9f9; padding:5px; border-radius:8px;">
                <div style="flex:1;">
                    <div style="font-weight:bold; font-size:1.1rem;">{{ $item->product->name }}</div>
                    <div style="color:#888; font-size:0.85rem;">Volume: {{ rand(50, 150) }}ml / Original Product</div>
                </div>
                <div style="text-align:center;">
                    <div style="color:#aaa; font-size:0.7rem; letter-spacing:1px; margin-bottom:5px;">QUANTITY</div>
                    <div style="font-weight:bold;">{{ $item->quantity }} Unit</div>
                </div>
                <div style="text-align:right; min-width: 150px;">
                    <div style="color:#aaa; font-size:0.7rem; letter-spacing:1px; margin-bottom:5px;">SUBTOTAL</div>
                    <div style="color:#F9A3A3; font-weight:bold; font-size:1.1rem;">IDR {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    
    <!-- Payment Method -->
    <div style="background: white; padding: 40px;">
        <div style="display:flex; align-items:center; gap:15px; margin-bottom: 30px;">
            <div style="width:30px; height:30px; background:#1a1a2e; color:white; display:flex; align-items:center; justify-content:center; border-radius:5px;"><i class="fa-solid fa-wallet"></i></div>
            <strong style="color: #111; font-size:1.1rem; text-transform:uppercase;">Payment Method</strong>
        </div>
        
        <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
            @csrf
            <div style="display:flex; gap:20px;">
                <!-- Option 1 -->
                <label id="opt-bank" style="flex:1; border: 2px solid #F9A3A3; padding:20px; border-radius:10px; cursor:pointer; display:flex; align-items:center; gap:20px;" onclick="selectPayment('Bank Transfer')">
                    <input type="radio" name="payment_method" value="Bank Transfer" checked style="display:none;">
                    <i class="fa-solid fa-building-columns" style="color:#a3c4f9; font-size:1.5rem;"></i>
                    <div style="flex:1;">
                        <div style="font-weight:bold; margin-bottom:5px;">Bank Transfer</div>
                        <div style="font-size:0.8rem; color:#888;">Instant confirmation via VA</div>
                    </div>
                    <div id="circle-bank" style="width:20px; height:20px; border-radius:50%; border:2px solid #F9A3A3; display:flex; align-items:center; justify-content:center;"><div style="width:10px; height:10px; background:#F9A3A3; border-radius:50%;"></div></div>
                </label>
                
                <!-- Option 2 -->
                <label id="opt-cod" style="flex:1; border: 1px solid #ddd; padding:20px; border-radius:10px; cursor:pointer; display:flex; align-items:center; gap:20px;" onclick="selectPayment('COD')">
                    <input type="radio" name="payment_method" value="COD" style="display:none;">
                    <i class="fa-solid fa-truck" style="color:#a3c4f9; font-size:1.5rem;"></i>
                    <div style="flex:1;">
                        <div style="font-weight:bold; margin-bottom:5px;">Cash On Delivery</div>
                        <div style="font-size:0.8rem; color:#888;">Pay when item arrives</div>
                    </div>
                    <div id="circle-cod" style="width:20px; height:20px; border-radius:50%; border:2px solid #ddd; display:flex; align-items:center; justify-content:center;"></div>
                </label>
            </div>
            
            <input type="hidden" name="shipping_address" value="{{ $user->address }}{{ $user->city ? ', ' . $user->city : '' }}{{ $user->province ? ', ' . $user->province : '' }}">
            <input type="hidden" name="items" value="{{ $itemIds }}">
            
            <script>
            function selectPayment(method) {
                document.getElementById('opt-bank').style.borderColor = '#ddd';
                document.getElementById('opt-cod').style.borderColor = '#ddd';
                document.getElementById('circle-bank').innerHTML = '';
                document.getElementById('circle-cod').innerHTML = '';
                document.getElementById('circle-bank').style.borderColor = '#ddd';
                document.getElementById('circle-cod').style.borderColor = '#ddd';
                
                document.querySelector('input[value="'+method+'"]').checked = true;
                
                if(method === 'Bank Transfer') {
                    document.getElementById('opt-bank').style.borderColor = '#F9A3A3';
                    document.getElementById('circle-bank').innerHTML = '<div style="width:10px; height:10px; background:#F9A3A3; border-radius:50%;"></div>';
                    document.getElementById('circle-bank').style.borderColor = '#F9A3A3';
                } else {
                    document.getElementById('opt-cod').style.borderColor = '#F9A3A3';
                    document.getElementById('circle-cod').innerHTML = '<div style="width:10px; height:10px; background:#F9A3A3; border-radius:50%;"></div>';
                    document.getElementById('circle-cod').style.borderColor = '#F9A3A3';
                }
            }
            </script>
        </form>
    </div>
    
    <!-- Footer / Submit Bar -->
    <div style="background: #1a1a2e; padding: 30px 40px; display:flex; justify-content:space-between; align-items:center; color:white;">
        <div style="display:flex; align-items:center; gap:30px;">
            <div>
                <div style="font-size:0.7rem; color:#888; letter-spacing:1px; margin-bottom:5px;">SHIPPING COST</div>
                <div style="font-weight:bold;">Free Shipping</div>
            </div>
            <div style="height: 40px; width:1px; background: rgba(255,255,255,0.2);"></div>
            <div>
                <div style="font-size:0.7rem; color:#888; letter-spacing:1px; margin-bottom:5px;">FINAL TOTAL</div>
                <div style="font-weight:bold; font-size:1.8rem; font-family:'Inter', serif;">IDR {{ number_format($total, 0, ',', '.') }}</div>
            </div>
        </div>
        
        <button type="submit" form="checkout-form" style="background: #F9A3A3; color:white; border:none; padding:15px 40px; border-radius:8px; font-weight:bold; font-size:1.1rem; cursor:pointer;">
            Complete Purchase <i class="fa-solid fa-arrow-right" style="margin-left:10px;"></i>
        </button>
    </div>
    
@endsection
