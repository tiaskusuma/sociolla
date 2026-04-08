@extends('layouts.admin')
@section('title', 'Admin Products')
@section('page_title', 'ADD PRODUCT') <!-- Based on Image 3 title -->

@section('content')
<style>
    /* Table layout specifically mimicking Image 1 and 3 */
    .product-frame {
        background: white; 
        border: 2px solid #333; 
        margin: 20px 50px 50px 50px; 
    }
    .product-table { width:100%; border-collapse:collapse; text-align:center; }
    .product-table th, .product-table td { border: 1px solid #333; padding: 15px; }
    .product-table th { font-weight:800; font-size:0.85rem; color:#111; }
    
    .polaroid { 
        width:80px; height:100px; border:1px solid #ddd; border-radius:5px; padding:5px; margin:0 auto; 
        box-shadow: 0 4px 6px rgba(0,0,0,0.1); display:flex; flex-direction:column;
    }
    .polaroid img { width:100%; height:80px; object-fit:cover; }
    
    .btn-edit { background:#BADFDB; color:white; border:none; padding:8px 12px; border-radius:5px; cursor:pointer; }
    .btn-del { background:#F9A3A3; color:white; border:none; padding:8px 12px; border-radius:5px; cursor:pointer; }
</style>

<div class="admin-frame" style="background-color: #F9A3A3; padding: 40px; border-radius: 15px; min-height: 70vh; margin: 0 40px 40px 40px;">
    <!-- Top toolbar inside pink area -->
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:30px;">
        @php $prefix = auth()->check() ? auth()->user()->role . '.' : 'admin.'; @endphp
        <a href="{{ route($prefix . 'products.create') }}" style="background:#BADFDB; color:white; padding:12px 25px; border-radius:30px; font-weight:800; font-size:0.85rem; text-decoration:none; display:flex; align-items:center; gap:8px;">
            <i class="fa-solid fa-plus"></i> ADD PRODUCT
        </a>
        <input type="text" placeholder="Search" style="padding:15px 25px; border:none; border-radius:30px; width:300px; outline:none; font-weight:600; font-size:0.9rem;">
    </div>

    <div class="product-frame" style="background: white; border: 2px solid #333;">
        <table class="product-table">
            <tr>
                <th style="width: 50px;">NO</th>
                <th>PICTURE</th>
                <th>PRODUCT NAME</th>
                <th>CATEGORY</th>
                <th>PRIZE</th>
                <th>STOCK</th>
                <th>ACTION</th>
            </tr>
            @foreach(\App\Models\Product::with('category')->get() as $product)
            <tr>
                <td style="font-weight:700;">{{ $loop->iteration }}.</td>
                <td>
                    <div style="display:flex; justify-content:center;">
                        <div class="polaroid">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                        </div>
                    </div>
                </td>
                <td style="font-weight:800; color:#333;">{{ $product->name }}</td>
                <td style="color:#555;">{{ optional($product->category)->name ?? 'Uncategorized' }}</td>
                <td style="color:#555;">IDR. {{ number_format((float)$product->price, 0, ',', '.') }}</td>
                <td style="color:#555; font-weight:700;">{{ $product->stock }} Units</td>
                <td>
                    <div style="display:flex; gap:10px;">
                        <a href="{{ route($prefix . 'products.edit', $product->id) }}" class="btn-edit" style="text-decoration:none; display:flex; align-items:center; justify-content:center;">
                            <i class="fa-solid fa-pencil"></i>
                        </a>
                        <form action="{{ route($prefix . 'products.delete', $product->id) }}" method="POST" style="margin:0;" onsubmit="return confirm('Are you sure you want to delete this product?');">
                            @csrf
                            <button type="submit" class="btn-del"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection
