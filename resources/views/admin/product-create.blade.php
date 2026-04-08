@extends('layouts.admin')
@section('title', 'Add Product')
@section('page_title', 'ADD PRODUCT')

@section('content')
<style>
    .form-wrapper { background: white; border: 2px solid #333; margin: 20px 50px 50px 50px; padding:40px; }
    .input-group { margin-bottom: 20px; }
    .input-group label { display:block; font-weight:700; color:#111; margin-bottom:8px; font-size:0.85rem; }
    .input-control { width:100%; box-sizing:border-box; padding:15px; border:1px solid #ccc; border-radius:5px; font-family:'Inter', sans-serif; font-size:0.9rem; outline:none; }
    .btn-submit { background:#BADFDB; color:white; border:none; padding:15px 30px; border-radius:30px; font-weight:800; cursor:pointer; font-size:0.9rem; margin-top:20px; }
</style>

<div class="admin-frame" style="background-color: #F9A3A3; padding: 40px; border-radius: 15px; min-height: 70vh; margin: 0 40px 40px 40px;">
    <div class="form-wrapper" style="background: white; border: 2px solid #333; padding:40px;">
        <form action="{{ route(auth()->user()->role . '.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="input-group">
                <label>PRODUCT NAME</label>
                <input type="text" name="name" class="input-control" required placeholder="e.g. Velvet Matte Lipstick">
            </div>
            
            <div style="display:flex; gap:20px;">
                <div class="input-group" style="flex:1;">
                    <label>BRAND</label>
                    <input type="text" name="brand" class="input-control" required placeholder="e.g. Sociolla Beauty">
                </div>
                <div class="input-group" style="flex:1;">
                    <label>CATEGORY</label>
                    <select name="category_id" class="input-control" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div style="display:flex; gap:20px;">
                <div class="input-group" style="flex:1;">
                    <label>PRICE (IDR)</label>
                    <input type="number" name="price" class="input-control" required value="0">
                </div>
                <div class="input-group" style="flex:1;">
                    <label>STOCK</label>
                    <input type="number" name="stock" class="input-control" required value="0">
                </div>
            </div>

            <div class="input-group">
                <label>DESCRIPTION</label>
                <textarea name="description" class="input-control" rows="4" placeholder="e.g. A gorgeous matte lipstick with long-lasting effect."></textarea>
            </div>

            <div class="input-group">
                <label>PRODUCT IMAGE</label>
                <input type="file" name="image_file" class="input-control" accept="image/*">
            </div>
            
            <button type="submit" class="btn-submit">SAVE PRODUCT</button>
        </form>
    </div>
</div>
@endsection
