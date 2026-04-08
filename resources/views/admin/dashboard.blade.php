@extends('layouts.admin')
@section('title', 'Admin Dashboard')
@section('page_title', 'DASHBOARD')

@section('content')
<style>
    .welcome-banner { background: #fca8a8; border-radius: 20px; padding: 40px; color: white; display:flex; justify-content:space-between; align-items:center; margin-bottom:30px; }
    .welcome-banner h2 { margin:0 0 10px 0; font-size:2.2rem; font-weight:700; letter-spacing:1px; }
    .welcome-banner p { margin:0; font-size:1.1rem; opacity:0.9; font-weight:500; }
    
    .stats-container { display:grid; grid-template-columns: repeat(4, 1fr); gap:20px; margin-bottom:30px; }
    .stat-card { background:white; border-radius:15px; padding:25px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); }
    .stat-title { color:#aaa; font-size:0.8rem; font-weight:700; text-transform:uppercase; margin-bottom:15px; letter-spacing:1px; }
    .stat-value { color:#F9A3A3; font-size:2.5rem; font-weight:700; }
    .stat-value small { font-size:1.2rem; }
    
    .grid-container { display:grid; grid-template-columns: 1fr 1fr 1fr; gap:20px; margin-bottom:30px; }
    .card { background:white; border-radius:15px; padding:25px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); }
    .card-title { display:flex; align-items:center; gap:10px; font-weight:700; font-size:1.1rem; margin-bottom:20px; color:#333; }
    .card-title i { color:#F9A3A3; }
    
    .list-item { display:flex; gap:15px; align-items:center; margin-bottom:15px; }
    .item-number { width:25px; height:25px; background:#fff0f0; color:#F9A3A3; border-radius:5px; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:0.85rem; }
    .item-name { color:#555; font-size:0.95rem; font-weight:500; }
    
    .stock-alert { display:flex; justify-content:space-between; align-items:center; background:#fff5f5; border:1px solid #ffebeb; padding:15px; border-radius:10px; margin-bottom:15px; }
    .stock-alert .left span { display:block; color:#F9A3A3; font-weight:700; font-size:0.75rem; letter-spacing:1px; margin-bottom:5px; }
    .stock-alert .left div { color:#333; font-size:0.95rem; font-weight:500; }
    .stock-alert .right { color:#e55c5c; font-weight:700; font-size:0.85rem; }

    .trans-table { width:100%; border-collapse:collapse; text-align:left; }
    .trans-table th { color:#aaa; font-size:0.75rem; font-weight:700; text-transform:uppercase; border-bottom:1px solid #f0f0f0; padding-bottom:15px; }
    .trans-table td { padding:15px 0; border-bottom:1px solid #f9f9f9; color:#555; font-size:0.9rem; }
    .badge { padding:5px 15px; border-radius:20px; font-weight:700; font-size:0.75rem; color:white; }
    .bg-done { background:#BADFDB; color:#2b7a6f; }
    .bg-pending { background:#f472b6; color:white; }

</style>

<div style="padding: 40px 50px;">
    
    <!-- Welcome Banner & Overall styling matches Image 2 dashboard -->
    <div class="welcome-banner">
        <div>
            <h2>Welcome To Sociolla</h2>
            <p>Manage your beauty business dashboard with ease and precision.</p>
        </div>
        <i class="fa-solid fa-leaf" style="font-size:10rem; opacity:0.2;"></i>
    </div>

    <!-- Stats -->
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-title">TOTAL PRODUCT</div>
            <div class="stat-value">{{ $totalProduct }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-title">MAKEUP PRODUCT</div>
            <div class="stat-value">{{ $makeupCount }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-title">SKINCARE PRODUCT</div>
            <div class="stat-value">{{ $skincareCount }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-title">TRANSACTION TODAY</div>
            <div class="stat-value"><small>IDR</small> {{ number_format((float)$todaySales, 0, ',', '.') }}</div>
        </div>
    </div>

    <!-- Mid Grid -->
    <div class="grid-container">
        <div class="card">
            <div class="card-title"><i class="fa-solid fa-wand-magic-sparkles"></i> Best Sellers Makeup</div>
            @forelse($makeupBestSellers as $item)
                <div class="list-item">
                    <div class="item-number">{{ $loop->iteration }}</div>
                    <div class="item-name">{{ $item->name }}</div>
                </div>
            @empty
                <div class="list-item"><div class="item-name">No makeup products found.</div></div>
            @endforelse
        </div>
        <div class="card">
            <div class="card-title"><i class="fa-solid fa-spa"></i> Best Sellers Skincare</div>
            @forelse($skincareBestSellers as $item)
                <div class="list-item">
                    <div class="item-number">{{ $loop->iteration }}</div>
                    <div class="item-name">{{ $item->name }}</div>
                </div>
            @empty
                <div class="list-item"><div class="item-name">No skincare products found.</div></div>
            @endforelse
        </div>
        <div class="card">
            <div class="card-title"><i class="fa-solid fa-triangle-exclamation" style="color:#e55c5c;"></i> Stock Alert</div>
            @forelse($lowStockProducts as $prod)
            <div class="stock-alert">
                <div class="left">
                    <span>LOW STOCK</span>
                    <div>{{ $prod->name }}</div>
                </div>
                <div class="right">{{ $prod->stock }} Left</div>
            </div>
            @empty
            <div style="color:#aaa; font-weight:600; text-align:center; padding-top:20px;">All stocks are healthy!</div>
            @endforelse
        </div>
    </div>

    <!-- Transactions -->
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <div class="card-title" style="margin:0;">New Transaction</div>
            <a href="{{ route(auth()->user()->role . '.transactions.index') }}" style="color:#F9A3A3; font-weight:700; font-size:0.85rem; text-decoration:none;">View All</a>
        </div>
        
        <table class="trans-table">
            <tr>
                <th>NO</th>
                <th>TRANSACTION CODE</th>
                <th>PRODUCT</th>
                <th>DATE</th>
                <th>TOTAL</th>
                <th>STATUS</th>
            </tr>
            @foreach($recentOrders as $order)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td style="font-weight:700;">SC-LP-0{{ $order->id }}</td>
                <td>{{ optional(optional($order->items->first())->product)->name ?? 'Beauty Product' }}</td>
                <td>{{ $order->created_at ? $order->created_at->format('d-m-Y') : 'N/A' }}</td>
                <td style="color:#F9A3A3; font-weight:700;">IDR {{ number_format((float)$order->total_amount, 0, ',', '.') }}</td>
                <td>
                    @if($order->status === 'Canceled')
                        <span class="badge" style="background:#e53e3e; color:white; display:inline-block; cursor:not-allowed;">CANCELED</span>
                    @else
                        <form action="{{ route(auth()->user()->role . '.order.status', $order->id) }}" method="POST" style="margin:0;">
                            @csrf
                            <select name="status" onchange="this.form.submit()" class="badge {{ $order->status == 'Completed' || $order->status == 'Packed' ? 'bg-done' : 'bg-pending' }}" style="border:none; outline:none; cursor:pointer;">
                                <option value="Not Paid" {{ $order->status == 'Not Paid' ? 'selected' : '' }}>PENDING</option>
                                <option value="Packed" {{ $order->status == 'Packed' ? 'selected' : '' }}>SUCCESS (Packed)</option>
                                <option value="Completed" {{ $order->status == 'Completed' ? 'selected' : '' }}>COMPLETED</option>
                            </select>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </table>
    </div>

</div>
@endsection
