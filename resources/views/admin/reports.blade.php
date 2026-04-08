@extends('layouts.admin')
@section('title', 'Reports')
@section('page_title', 'REPORTS')

@section('content')
<style>
    .trans-frame {
        background: white; 
        border-radius: 10px;
        overflow: hidden;
    }
    .trans-table { width:100%; border-collapse:collapse; text-align:left; }
    .trans-table th, .trans-table td { border-bottom: 1px solid #333; border-right: 1px solid #333; padding: 20px 15px; }
    .trans-table th:last-child, .trans-table td:last-child { border-right: none; }
    .trans-table th { font-weight:800; font-size:0.8rem; color:#111; text-transform:uppercase; background:white; }
    
    .status { padding:6px 15px; border-radius:15px; font-weight:700; font-size:0.75rem; color:white; border:none; display:inline-block; margin-bottom:5px; appearance:none; -webkit-appearance:none; text-align:center;}
    .bg-done { background:#4ade80; }
    .bg-process { background:#fde047; color:#854d0e; }
    .bg-delivery { background:#60a5fa; color:white; }
    .bg-cancel { background:#e53e3e; color:white; }
    .bg-pending { background:#f472b6; color:white; }
    
    .summary-row td { background: white; font-weight: 800; border-bottom: none; border-right: none; padding: 25px 20px; font-size: 0.9rem;}
</style>

<div class="admin-frame" style="background-color: #F9A3A3; padding: 40px; border-radius: 15px; min-height: 70vh; margin: 0 40px 40px 40px;">
    <!-- Top toolbar inside pink area -->
    <div style="display:flex; gap:20px; align-items:center; margin-bottom:30px;">
        <div style="position:relative;">
            <input type="text" placeholder="Search Reports" style="padding:15px 25px; border:none; border-radius:30px; width:300px; outline:none; font-weight:600; font-size:0.9rem;">
            <i class="fa-solid fa-magnifying-glass" style="position:absolute; right:20px; top:17px; color:#aaa;"></i>
        </div>
        <div style="position:relative;">
            <input type="text" placeholder="Search Date" style="padding:15px 25px; border:none; border-radius:30px; width:300px; outline:none; font-weight:600; font-size:0.9rem;">
            <i class="fa-regular fa-calendar" style="position:absolute; right:20px; top:17px; color:#aaa;"></i>
        </div>
    </div>

    <div class="trans-frame">
        <table class="trans-table">
            <tr>
                <th style="width: 50px;">NO</th>
                <th>TRANSACTION CODE</th>
                <th>DATE</th>
                <th>CUSTOMER NAME</th>
                <th>TOTAL</th>
                <th>STATUS</th>
            </tr>
            @foreach($orders as $order)
            <tr>
                <td style="font-weight:700; vertical-align:top;">{{ $loop->iteration }}.</td>
                <td style="color:#555; vertical-align:top;">MLR00{{ $order->id }}</td>
                <td style="color:#555; vertical-align:top;">{{ $order->created_at ? $order->created_at->format('d-m-Y') : 'N/A' }}</td>
                <td style="color:#555; vertical-align:top;">{{ optional($order->user)->name ?? 'Guest' }}</td>
                <td style="color:#555; vertical-align:top;">IDR. {{ number_format((float)$order->total_amount, 0, ',', '.') }}</td>
                <td style="vertical-align:top;">
                    @if($order->status === 'Canceled')
                        <span class="status bg-cancel" style="cursor:not-allowed; display:inline-block;">Canceled</span>
                    @elseif($order->status === 'Completed')
                        <span class="status bg-done" style="cursor:not-allowed; display:inline-block;">Completed</span>
                    @elseif($order->status === 'Packed')
                        <span class="status bg-process" style="cursor:not-allowed; display:inline-block;">Still Packed</span>
                    @elseif($order->status === 'Delivered')
                        <form action="{{ route(auth()->user()->role . '.order.status', $order->id) }}" method="POST" style="margin:0;">
                            @csrf
                            <select name="tracking_status" onchange="this.form.submit()" class="status {{ $order->tracking_status ? 'bg-delivery' : 'bg-process' }}" style="cursor:pointer; outline:none; text-align:center;">
                                <option value="" {{ !$order->tracking_status ? 'selected' : '' }}>Choose Update</option>
                                <option value="Just picked up from the store" {{ $order->tracking_status == 'Just picked up from the store' ? 'selected' : '' }}>Just picked up from the store</option>
                                <option value="On the way to the customer's home" {{ $order->tracking_status == "On the way to the customer's home" ? 'selected' : '' }}>On the way to the customer's home</option>
                                <option value="Arrived at the customer's home" {{ $order->tracking_status == "Arrived at the customer's home" ? 'selected' : '' }}>Arrived at the customer's home</option>
                            </select>
                        </form>
                    @else
                        <span class="status bg-pending" style="cursor:not-allowed; display:inline-block;">Pending</span>
                    @endif
                </td>
            </tr>
            @endforeach
            <tr class="summary-row">
                <td colspan="3" style="text-align:left;">TOTAL TRANSACTION : {{ $orders->count() }}</td>
                <td colspan="3" style="text-align:right;">TOTAL SALES : IDR. {{ number_format((float)$totalSales, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>
</div>
@endsection
