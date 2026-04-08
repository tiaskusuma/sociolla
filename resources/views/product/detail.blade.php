@extends('layouts.app')
@section('title', $product->name)
@section('content')
<div style="max-width: 1100px; margin: 40px auto; background: white; padding: 40px; display:flex; gap: 50px;">
    <!-- LEFT: Image -->
    <div style="flex:1;">
        <img src="{{ $product->image_url }}" style="width:100%; object-fit:contain; background:#f9f9f9; padding:20px;" alt="{{ $product->name }}">
    </div>
    
    <!-- RIGHT: Info -->
    <div style="flex:1;">
        <h1 style="font-size:2rem; margin-top:0; color:#111;">{{ $product->name }}</h1>
        <div style="background:#f9f9f9; padding:20px; margin-bottom:20px;">
            <span style="color:#F9A3A3; font-size:2rem; font-weight:bold;">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
        </div>
        
        <table style="width:100%; border-collapse:collapse; margin-bottom: 20px;">
            <tr>
                <td style="color:#888; width:100px; vertical-align:top; padding-bottom:20px;">Sisa Stok</td>
                <td style="color:#333; line-height:1.6; padding-bottom:20px;">{{ $product->stock }} Unit</td>
            </tr>
            <tr>
                <td style="color:#888; width:100px; vertical-align:top; padding-bottom:20px;">Deskripsi</td>
                <td style="color:#333; line-height:1.6; padding-bottom:20px;">{{ $product->description ?: 'Bahan berkualitas tinggi dengan hasil akhir elegan. Nyaman digunakan sepanjang hari.' }}</td>
            </tr>
            <tr>
                <td style="color:#888;">Kuantitas</td>
                <td>
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" id="add-to-cart-form">
                        @csrf
                        <div style="display:inline-flex; border:1px solid #ccc; background:white;">
                            <button type="button" onclick="document.getElementById('qty').value = Math.max(1, parseInt(document.getElementById('qty').value) - 1)" style="border:none; background:none; padding:10px 15px; cursor:pointer;">-</button>
                            <input type="number" name="quantity" id="qty" value="1" min="1" style="width:40px; border:none; text-align:center; outline:none; border-left:1px solid #ccc; border-right:1px solid #ccc;">
                            <button type="button" onclick="document.getElementById('qty').value = parseInt(document.getElementById('qty').value) + 1" style="border:none; background:none; padding:10px 15px; cursor:pointer;">+</button>
                        </div>
                    </form>
                </td>
            </tr>
        </table>
        
        <div style="display:flex; gap:20px; margin-top:30px;">
            @if($product->stock > 0)
                <button type="button" onclick="document.getElementById('add-to-cart-form').action = '{{ route('cart.add', $product->id) }}'; document.getElementById('add-to-cart-form').submit();" style="flex:1; background:white; color:#2b7a6f; border:1px solid #2b7a6f; padding:15px; border-radius:3px; font-weight:bold; cursor:pointer;"><i class="fa-solid fa-cart-plus"></i> Masukan Keranjang</button>
                <button type="button" onclick="window.location.href = '{{ route('checkout.index') }}?product_id={{ $product->id }}&qty=' + document.getElementById('qty').value;" style="flex:1; background:#F9A3A3; color:white; border:none; padding:15px; border-radius:3px; font-weight:bold; cursor:pointer;">Beli Sekarang</button>
            @else
                <button type="button" disabled style="flex:1; background:#eee; color:#aaa; border:1px solid #ddd; padding:15px; border-radius:3px; font-weight:bold; cursor:not-allowed;"><i class="fa-solid fa-ban"></i> Stok Habis</button>
            @endif
        </div>
    </div>
</div>
</div>

<!-- Reviews Section -->
<div style="max-width: 1100px; margin: 0 auto 40px auto; background: white; padding: 40px;">
    <h2 style="font-size:1.5rem; margin-top:0; border-bottom:1px solid #eaeaea; padding-bottom:15px; margin-bottom:20px;">Review Produk</h2>
    
    <div style="display:flex; gap: 40px; margin-bottom: 40px;">
        <div style="text-align:center;">
            <div style="font-size:3.5rem; font-weight:bold; color:#111; line-height:1;">{{ $product->average_rating > 0 ? $product->average_rating : '0' }}<span style="font-size:1.5rem; color:#aaa;">/5</span></div>
            <div style="color:#d81b60; font-size:1.2rem; margin:10px 0;">
                @for($i=1; $i<=5; $i++)
                    <i class="{{ $i <= round($product->average_rating) ? 'fa-solid' : 'fa-regular' }} fa-star"></i>
                @endfor
            </div>
            <div style="color:#888; font-size:0.9rem;">{{ $product->rating_count }} Penilaian</div>
        </div>
    </div>
    
    <div>
        @forelse($reviews as $review)
        <div style="border-bottom: 1px solid #eaeaea; padding: 20px 0;">
            <div style="display:flex; gap: 15px;">
                <div style="width: 40px; height: 40px; border-radius: 50%; background: #eaeaea; display:flex; align-items:center; justify-content:center; color:#888; font-weight:bold;">
                    {{ substr(optional($review->user)->name ?? 'G', 0, 1) }}
                </div>
                <div style="flex:1;">
                    <div style="font-weight:bold; font-size:0.95rem;">{{ optional($review->user)->name ?? 'Guest User' }}</div>
                    <div style="color:#d81b60; font-size:0.8rem; margin: 3px 0;">
                        @for($i=1; $i<=5; $i++)
                            <i class="{{ $i <= $review->rating_stars ? 'fa-solid' : 'fa-regular' }} fa-star"></i>
                        @endfor
                    </div>
                    <div style="font-size:0.75rem; color:#aaa; margin-bottom: 10px;">{{ $review->updated_at->format('d M Y, H:i') }} | Variasi: Original Product</div>
                    
                    <p style="margin:0 0 10px 0; color:#333; line-height:1.5; font-size:0.95rem;">{{ $review->rating_review ?: 'Tidak ada ulasan teks.' }}</p>
                    
                    @if($review->rating_image)
                    <img src="/sociolla/public/{{ $review->rating_image }}" style="width: 100px; height: 100px; object-fit: cover; border-radius:5px; border:1px solid #ddd;" alt="Review Image">
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div style="text-align:center; padding: 40px; color:#aaa; font-style:italic;">
            Belum ada penilaian untuk produk ini.
        </div>
        @endforelse
    </div>
</div>
@endsection
