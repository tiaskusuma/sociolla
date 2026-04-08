@extends('layouts.admin')
@section('title', 'Edit Product')
@section('page_title', 'EDIT PRODUCT')

@section('content')
<style>
    .form-wrapper { background: white; border: 2px solid #333; padding:40px; }
    .input-group { margin-bottom: 20px; }
    .input-group label { display:block; font-weight:700; color:#111; margin-bottom:8px; font-size:0.85rem; }
    .input-control { width:100%; box-sizing:border-box; padding:15px; border:1px solid #ccc; border-radius:5px; font-family:'Inter', sans-serif; font-size:0.9rem; outline:none; }
    .btn-submit { background:#BADFDB; color:white; border:none; padding:15px 30px; border-radius:30px; font-weight:800; cursor:pointer; font-size:0.9rem; margin-top:20px; }
</style>

<div class="admin-frame" style="background-color: #F9A3A3; padding: 40px; border-radius: 15px; min-height: 70vh; margin: 0 40px 40px 40px;">
    <div class="form-wrapper">
        <form action="{{ route(auth()->user()->role . '.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="input-group">
                <label>PRODUCT NAME</label>
                <input type="text" name="name" class="input-control" required value="{{ $product->name }}">
            </div>
            
            <div style="display:flex; gap:20px;">
                <div class="input-group" style="flex:1;">
                    <label>BRAND</label>
                    <input type="text" name="brand" class="input-control" required value="{{ $product->brand }}">
                </div>
                <div class="input-group" style="flex:1;">
                    <label>CATEGORY</label>
                    <select name="category_id" class="input-control" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div style="display:flex; gap:20px;">
                <div class="input-group" style="flex:1;">
                    <label>PRICE (IDR)</label>
                    <input type="number" name="price" class="input-control" required value="{{ $product->price }}">
                </div>
                <div class="input-group" style="flex:1;">
                    <label>STOCK</label>
                    <input type="number" name="stock" class="input-control" required value="{{ $product->stock }}">
                </div>
            </div>

            <div class="input-group">
                <label>DESCRIPTION</label>
                <textarea name="description" class="input-control" rows="4">{{ $product->description }}</textarea>
            </div>

            <div class="input-group">
                <label>PRODUCT IMAGE</label>
                <div style="margin-bottom:10px;">
                    @if($product->image_url)
                        <img src="{{ Str::startsWith($product->image_url, 'http') ? $product->image_url : asset($product->image_url) }}" alt="Current Image" style="height:100px; border-radius:8px;">
                    @endif
                </div>
                <input type="file" name="image_file" class="input-control" accept="image/*">
                <small style="color:#888;">Leave empty to keep the current image.</small>
            </div>
            
            <button type="submit" class="btn-submit">UPDATE PRODUCT</button>
        </form>
    </div>
</div>
@endsection
