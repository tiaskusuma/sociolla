@extends('layouts.app')
@section('title', 'Rate Product')

@section('content')

<!-- Use similar standalone layout overrides like Image 4 -->
<div style="position:fixed; top:0; left:0; right:0; bottom:0; background:#BADFDB; z-index:-1;"></div>

<!-- Quick Custom Header -->
<div style="background-color: #F9A3A3; width: 100%; padding: 15px 40px; display:flex; justify-content:space-between; align-items:center; box-sizing:border-box; color:white;">
    <a href="{{ route('home') }}" style="display:flex; align-items:center; gap:5px; text-decoration:none; color:white;">
        <span style="font-size:1.5rem;"><i class="fa-solid fa-leaf"></i></span>
        <span style="font-family: 'Great Vibes', cursive; font-size: 2.2rem; margin-top:-5px;">Sociolla</span>
    </a>
    <div style="flex: 1; max-width: 500px; background: white; border-radius: 20px; overflow: hidden; display:flex;">
        <input type="text" placeholder="Search authentic beauty products..." style="flex:1; border:none; outline:none; padding: 10px 15px; font-size:0.9rem;">
        <button style="background-color: transparent; border:none; padding: 0 15px; cursor:pointer;"><i class="fa-solid fa-magnifying-glass" style="color:#888;"></i></button>
    </div>
    <div style="display: flex; gap: 20px; font-size: 0.85rem; font-weight: bold; align-items:center; text-transform:uppercase;">
        <a href="{{ route('home') }}" style="color:white; text-decoration:none;">Home</a>
        <a href="{{ route('orders.index') }}" style="color:white; text-decoration:underline;">Order</a>
        <a href="{{ route('cart.index') }}" style="color:white; text-decoration:none;"><i class="fa-solid fa-cart-shopping"></i></a>
        <a href="{{ route('profile') }}" style="color:white; text-decoration:none;"><i class="fa-regular fa-user"></i></a>
    </div>
</div>

@php $firstItem = $order->items->first(); @endphp

<div style="padding: 50px 0; display:flex; justify-content:center;">
    
    <form action="{{ route('orders.rate.submit', $order->id) }}" method="POST" enctype="multipart/form-data" style="background: white; border-radius: 20px; width: 450px; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); position:relative; z-index:10;">
        @csrf
        
        <div style="display:flex; gap: 15px; align-items:center; margin-bottom: 30px;">
            <div style="width: 60px; height: 60px; border-radius: 8px; background: #eaabaa; display:flex; align-items:center; justify-content:center; overflow:hidden;">
                <img src="{{ $firstItem->product->image_url }}" style="height: 80%; object-fit:contain;">
            </div>
            <div>
                <div style="font-weight:bold; color:#111; font-size:1.1rem; margin-bottom:3px;">{{ $firstItem->product->name }}</div>
                <div style="color:#888; font-size:0.8rem;">Submit your review</div>
            </div>
        </div>
        
        <input type="hidden" name="rating_stars" id="rating_stars" value="5">
        
        <div style="text-align:center; margin-bottom: 30px;">
            <div style="font-weight:bold; color:#111; margin-bottom:15px; font-size:0.9rem;">Rate this product</div>
            <div id="star-container" style="display:flex; justify-content:center; gap: 10px; color:#F9A3A3; font-size:2rem; cursor:pointer;">
                <i class="fa-solid fa-star star" data-val="1"></i>
                <i class="fa-solid fa-star star" data-val="2"></i>
                <i class="fa-solid fa-star star" data-val="3"></i>
                <i class="fa-solid fa-star star" data-val="4"></i>
                <i class="fa-solid fa-star star" data-val="5"></i>
            </div>
        </div>
        
        <div style="margin-bottom: 30px;">
            <div style="font-weight:bold; color:#111; margin-bottom:10px; font-size:0.9rem;">Write your review</div>
            <textarea name="rating_review" placeholder="Tell us what you think about this product..." style="width:100%; box-sizing:border-box; padding: 15px; border: 1px solid #eaeaea; border-radius: 8px; outline:none; height:100px; font-family:inherit; resize:none;"></textarea>
        </div>
        
        <div style="margin-bottom: 40px;">
            <div style="font-weight:bold; color:#111; margin-bottom:10px; font-size:0.9rem;">Add Photos</div>
            <div style="border: 2px dashed #eaeaea; border-radius: 8px; padding: 40px 20px; text-align:center; color:#888; position:relative; overflow:hidden;">
                <input type="file" name="rating_image" id="rating_image" accept="image/*" style="position:absolute; top:0; left:0; width:100%; height:100%; opacity:0; cursor:pointer;">
                <i class="fa-solid fa-camera" style="font-size:1.5rem; margin-bottom:10px;"></i>
                <div style="font-size:0.8rem;" id="file-name-display">Upload a photo</div>
            </div>
        </div>
        
        <button type="submit" style="width:100%; background:#F9A3A3; color:white; border:none; padding:15px; border-radius:30px; font-weight:bold; font-size:0.9rem; cursor:pointer; position:relative; z-index:10;">SUBMIT REVIEW</button>
        
    </form>
    
</div>

<div style="text-align:center; color:white; font-family:'Playfair Display', serif; font-size:1.2rem; margin-bottom:50px;">
    Your Daily Beauty Destination
</div>

<!-- Custom Pink footer to match Image 4 -->
<div style="background: #F9A3A3; border-top-left-radius: 30px; border-top-right-radius: 30px; padding: 50px 0; color:white; display:flex; justify-content:center; z-index:10; position:relative;">
    <div style="max-width: 1000px; width:100%; display:flex; justify-content:space-between;">
        
        <!-- Just structural mock to block out default footer -->
        <div>
            <div style="font-size:1.5rem; font-family:'Great Vibes', cursive;"><i class="fa-solid fa-leaf"></i> Sociolla</div>
            <div style="font-size:0.7rem; letter-spacing:1px; margin-top:5px; opacity:0.8;">CONTEMPORARY BEAUTY FOR MODERN LIFESTYLE</div>
            
            <div style="display:flex; margin-top:40px; justify-content:space-between; width:100%; gap: 100px;">
                <!-- Columns omitted to keep simple overlay -->
            </div>
        </div>
        
    </div>
</div>

<style>
    /* Hide the universal Header and Footer so our custom ones shine */
    body > div:first-of-type { display: none !important; }
    body > div:last-of-type { display: none !important; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('rating_image');
        const fileNameDisplay = document.getElementById('file-name-display');
        
        if (fileInput) {
            fileInput.addEventListener('change', function() {
                if (this.files && this.files.length > 0) {
                    fileNameDisplay.textContent = this.files[0].name;
                } else {
                    fileNameDisplay.textContent = 'Upload a photo';
                }
            });
        }

        const stars = document.querySelectorAll('.star');
        const ratingInput = document.getElementById('rating_stars');

        stars.forEach(star => {
            star.addEventListener('click', function() {
                const val = parseInt(this.getAttribute('data-val'));
                ratingInput.value = val;
                stars.forEach(s => {
                    if (parseInt(s.getAttribute('data-val')) <= val) {
                        s.classList.remove('fa-regular');
                        s.classList.add('fa-solid');
                    } else {
                        s.classList.remove('fa-solid');
                        s.classList.add('fa-regular');
                    }
                });
            });
        });
    });
</script>

@endsection
