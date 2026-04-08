@extends('layouts.app')
@section('title', 'Home')
@section('content')

<!-- Banners -->
<div style="max-width: 1100px; margin: 20px auto; position:relative;">
    <img src="/sociolla/public/images/banner.png" style="width: 100%; height: 320px; object-fit: cover; border-radius: 8px; display: block;" alt="Banner">
</div>

@if(request('search') || request('filter'))
<div style="max-width: 1100px; margin: 0 auto 50px auto;">
    <div style="background: white; padding: 15px 20px; display:flex; justify-content:space-between; align-items:center; border: 1px solid #e0e0e0; border-bottom:none;">
        <h2 style="margin:0; font-size: 1.3rem; font-weight: 500; color: #333;">
            @if(request('search'))
                Search Results for "{{ request('search') }}"
            @else
                {{ request('filter') == 'new' ? 'New Products' : (request('filter') == 'popular' ? 'Popular Products' : (request('filter') == 'best' ? 'Best Seller' : (request('filter') == 'deals' ? 'Daily Deals' : 'Trending'))) }}
            @endif
        </h2>
    </div>
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1px; background: #e0e0e0; border: 1px solid #e0e0e0;">
        @forelse($allProducts as $p)
        <div class="product-card" style="position:relative; cursor:pointer;" onclick="window.location.href='{{ route('product.show', $p->id) }}'">
            <img src="{{ $p->image_url }}" alt="{{ $p->name }}">
            <div class="brand">{{ $p->brand }}</div>
            <div class="name">{{ $p->name }}</div>
            <div>
                <span class="price">Rp{{ number_format($p->price, 0, ',', '.') }}</span>
                <span class="original-price">Rp{{ number_format($p->original_price, 0, ',', '.') }}</span>
            </div>
            <div class="rating">
                <i class="fa-solid fa-star" style="color: #d81b60;"></i>
                <strong>{{ $p->average_rating > 0 ? $p->average_rating : '0' }}</strong> <span style="color:#aaa;">({{ $p->rating_count }})</span>
            </div>
        </div>
        @empty
        <div style="padding:40px; text-align:center; grid-column: span 4; background:white;">No products found!</div>
        @endforelse
    </div>
</div>
@else
<!-- Daily Deals -->
<div style="max-width: 1100px; margin: 0 auto 30px auto;">
    <div style="background: white; padding: 15px 20px; display:flex; justify-content:space-between; align-items:center; border: 1px solid #e0e0e0; border-bottom:none;">
        <h2 style="margin:0; font-size: 1.3rem; font-weight: 500; color: #333;">Daily Deals</h2>
        <a href="{{ route('home', ['filter' => 'deals']) }}" style="color: #3b82f6; font-size:0.8rem; font-weight:bold;">See More</a>
    </div>
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1px; background: #e0e0e0; border: 1px solid #e0e0e0;">
        @foreach($allProducts->count() > 0 ? $allProducts->shuffle()->take(4) : [] as $p)
        <div class="product-card" style="position:relative; cursor:pointer;" onclick="window.location.href='{{ route('product.show', $p->id) }}'">
            <img src="{{ $p->image_url }}" alt="{{ $p->name }}">
            <div class="brand">{{ $p->brand }}</div>
            <div class="name">{{ $p->name }}</div>
            <div>
                <span class="price">Rp{{ number_format($p->price, 0, ',', '.') }}</span>
                <span class="original-price">Rp{{ number_format($p->original_price, 0, ',', '.') }}</span>
            </div>
            <div class="rating">
                <i class="fa-solid fa-star" style="color: #d81b60;"></i>
                <strong>{{ $p->average_rating > 0 ? $p->average_rating : '0' }}</strong> <span style="color:#aaa;">({{ $p->rating_count }})</span>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Popular Products -->
<div style="max-width: 1100px; margin: 0 auto 30px auto;">
    <div style="background: white; padding: 15px 20px; display:flex; justify-content:space-between; align-items:center; border: 1px solid #e0e0e0; border-bottom:none;">
        <h2 style="margin:0; font-size: 1.3rem; font-weight: 500; color: #333;">Popular Products</h2>
        <a href="{{ route('home', ['filter' => 'popular']) }}" style="color: #3b82f6; font-size:0.8rem; font-weight:bold;">See More</a>
    </div>
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1px; background: #e0e0e0; border: 1px solid #e0e0e0;">
        @foreach($allProducts->count() > 0 ? $allProducts->shuffle()->take(4) : [] as $p)
        <div class="product-card" style="position:relative; cursor:pointer;" onclick="window.location.href='{{ route('product.show', $p->id) }}'">
            <img src="{{ $p->image_url }}" alt="{{ $p->name }}">
            <div class="brand">{{ $p->brand }}</div>
            <div class="name">{{ $p->name }}</div>
            <div>
                <span class="price">Rp{{ number_format($p->price, 0, ',', '.') }}</span>
                <span class="original-price">Rp{{ number_format($p->original_price, 0, ',', '.') }}</span>
            </div>
            <div class="rating">
                <i class="fa-solid fa-star" style="color: #d81b60;"></i>
                <strong>{{ $p->average_rating > 0 ? $p->average_rating : '0' }}</strong> <span style="color:#aaa;">({{ $p->rating_count }})</span>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Best Seller -->
<div style="max-width: 1100px; margin: 0 auto 50px auto;">
    <div style="background: white; padding: 15px 20px; display:flex; justify-content:space-between; align-items:center; border: 1px solid #e0e0e0; border-bottom:none;">
        <h2 style="margin:0; font-size: 1.3rem; font-weight: 500; color: #333;">Best Seller</h2>
        <a href="{{ route('home', ['filter' => 'best']) }}" style="color: #3b82f6; font-size:0.8rem; font-weight:bold;">See More</a>
    </div>
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1px; background: #e0e0e0; border: 1px solid #e0e0e0;">
        @foreach($allProducts->count() > 0 ? $allProducts->sortBy('stock')->take(4) : [] as $p)
        <div class="product-card" style="position:relative; cursor:pointer;" onclick="window.location.href='{{ route('product.show', $p->id) }}'">
            <img src="{{ $p->image_url }}" alt="{{ $p->name }}">
            <div class="brand">{{ $p->brand }}</div>
            <div class="name">{{ $p->name }}</div>
            <div>
                <span class="price">Rp{{ number_format($p->price, 0, ',', '.') }}</span>
                <span class="original-price">Rp{{ number_format($p->original_price, 0, ',', '.') }}</span>
            </div>
            <div class="rating">
                <i class="fa-solid fa-star" style="color: #d81b60;"></i>
                <strong>{{ $p->average_rating > 0 ? $p->average_rating : '0' }}</strong> <span style="color:#aaa;">({{ $p->rating_count }})</span>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

@endsection
