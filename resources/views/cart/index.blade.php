@extends('layouts.app')
@section('title', 'My Cart')
@section('content')
<div style="max-width: 1000px; margin: 40px auto; background: white; padding: 0;">
    <!-- Head -->
    <div style="padding: 20px 40px; border-bottom:1px solid #eaeaea;">
        <h1 style="color: #F9A3A3; font-weight: normal; margin: 0;">My Cart</h1>
    </div>
    
    <!-- Items list -->
    <div style="padding: 40px; border-bottom: 1px solid #eaeaea; background:#e0f2f1;">
        @foreach($cartItems as $item)
        <div style="background:white; border:1px solid #eaeaea; padding:20px; display:flex; align-items:center; gap:20px; margin-bottom:20px;">
            <input type="checkbox" class="cart-checkbox" value="{{ $item->id }}" data-price="{{ $item->product->price }}" data-qty="{{ $item->quantity }}" checked onchange="calculateTotal()" style="width:20px; height:20px; accent-color:#00b894; cursor:pointer;">
            
            <a href="{{ route('product.show', $item->product->id) }}">
                <img src="{{ $item->product->image_url }}" style="width:80px; height:80px; object-fit:contain;">
            </a>
            
            <a href="{{ route('product.show', $item->product->id) }}" style="flex:1; font-weight:bold; text-decoration:none; color:inherit;">
                {{ $item->product->name }}
            </a>
            
            <div style="font-size:1.1rem; color:#111; font-weight:bold; min-width: 120px;">Rp{{ number_format($item->product->price, 0, ',', '.') }}</div>
            
            <!-- Update qty form -->
            <form action="{{ route('cart.update', $item->id) }}" method="POST" style="margin:0;">
                @csrf
                <div style="display:inline-flex; border:1px solid #ccc; background:white;">
                    <button type="submit" name="quantity" value="{{ $item->quantity - 1 }}" style="border:none; background:none; padding:8px 12px; cursor:pointer;">-</button>
                    <div style="padding:8px 15px; border-left:1px solid #ccc; border-right:1px solid #ccc;">{{ $item->quantity }}</div>
                    <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}" style="border:none; background:none; padding:8px 12px; cursor:pointer;">+</button>
                </div>
            </form>
            
            <form action="{{ route('cart.remove', $item->id) }}" method="POST" style="margin:0;">
                @csrf
                <button type="submit" style="background:none; border:none; color:red; cursor:pointer;"><i class="fa-solid fa-trash"></i></button>
            </form>
        </div>
        @endforeach
    </div>
    
    <!-- Footer -->
    <div style="padding: 30px 40px; display:flex; justify-content:flex-end; align-items:center; gap:30px;">
        <div style="font-size: 1.1rem; color:#333;">Total (<span id="total-qty-display">{{ $cartItems->sum('quantity') }}</span> Produk): <strong id="total-price-display" style="font-size:1.6rem; color:#111;">Rp{{ number_format($total, 0, ',', '.') }}</strong></div>
        <button onclick="proceedToCheckout()" style="background:#F9A3A3; color:white; border:none; font-weight:bold; padding: 15px 50px; border-radius:3px; cursor:pointer; font-size:1rem;">Checkout</button>
    </div>
</div>

<script>
function calculateTotal() {
    let total = 0;
    let qty = 0;
    document.querySelectorAll('.cart-checkbox:checked').forEach(cb => {
        let p = parseInt(cb.getAttribute('data-price'));
        let q = parseInt(cb.getAttribute('data-qty'));
        total += p * q;
        qty += q;
    });
    
    let formatted = new Intl.NumberFormat('id-ID').format(total);
    document.getElementById('total-price-display').innerText = 'Rp' + formatted;
    document.getElementById('total-qty-display').innerText = qty;
}

function proceedToCheckout() {
    const selected = [];
    document.querySelectorAll('.cart-checkbox:checked').forEach(cb => {
        selected.push(cb.value);
    });
    if(selected.length === 0) {
        alert('Pilih setidaknya satu produk untuk di-checkout!');
        return;
    }
    window.location.href = "{{ route('checkout.index') }}?items=" + selected.join(',');
}

// init
calculateTotal();
</script>
@endsection
