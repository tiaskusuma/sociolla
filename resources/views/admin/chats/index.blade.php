@extends('layouts.admin')
@section('title', 'Customer Chats')
@section('page_title', 'CUSTOMER CHATS')

@section('content')
<div class="admin-frame" style="background-color: #F9A3A3; padding: 40px; border-radius: 15px; min-height: 70vh; margin: 0 40px 40px 40px;">
    
    <div style="background: white; border-radius: 10px; overflow: hidden; padding: 20px;">
        <h3 style="margin-top: 0; color: #333; margin-bottom: 20px;">Daftar Pesan Masuk</h3>
        
        @if($customers->isEmpty())
            <div style="text-align:center; padding: 50px; color: #999;">
                <i class="fa-regular fa-comments" style="font-size: 3rem; margin-bottom: 10px;"></i>
                <p>Belum ada pelanggan yang mengirimkan pesan ke toko.</p>
            </div>
        @else
            <div style="display:flex; flex-direction:column; gap: 10px;">
                @php $prefix = auth()->check() ? auth()->user()->role . '.' : 'admin.'; @endphp
                @foreach($customers as $c)
                    <a href="{{ route($prefix . 'chats.show', $c->id) }}" style="display:flex; align-items:center; gap: 15px; padding: 15px; border: 1px solid #eee; border-radius: 8px; text-decoration:none; color:inherit; transition: background 0.2s;" onmouseover="this.style.background='#fdfbfb'" onmouseout="this.style.background='transparent'">
                        <div style="width: 45px; height: 45px; background: #BADFDB; color: #235850; border-radius: 50%; display:flex; align-items:center; justify-content:center; font-size: 1.2rem; font-weight: bold;">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <div style="flex: 1;">
                            <div style="font-weight: bold; font-size: 1.1rem; color: #111;">{{ $c->name }}</div>
                            <div style="font-size: 0.8rem; color: #666;">@ {{ $c->username }} - {{ $c->email }}</div>
                        </div>
                        <div style="color: #F9A3A3; font-weight: bold;">
                            Buka Chat <i class="fa-solid fa-chevron-right" style="margin-left: 5px;"></i>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>

</div>
@endsection
