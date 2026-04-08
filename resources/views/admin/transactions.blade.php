@extends('layouts.admin')
@section('title', 'Admin Transactions')
@section('page_title', 'TRANSACTION')

@section('content')
<style>
    .trans-frame {
        background: white; 
        border: 2px solid #333; 
        margin: 20px 50px 50px 50px; 
    }
    .trans-table { width:100%; border-collapse:collapse; text-align:center; }
    .trans-table th, .trans-table td { border: 1px solid #333; padding: 15px; }
    .trans-table th { font-weight:800; font-size:0.85rem; color:#111; }
    
    .btn-see { background:#BADFDB; color:white; border:none; padding:8px 12px; border-radius:5px; cursor:pointer; font-weight:bold; font-size:0.75rem; text-decoration:none; display:inline-block; }
    .btn-print { background:#BADFDB; color:white; border:none; padding:8px 12px; border-radius:5px; cursor:pointer; font-weight:bold; font-size:0.75rem; text-decoration:none; display:inline-block; }
    
    .status { padding:5px 15px; border-radius:20px; font-weight:700; font-size:0.75rem; color:white; border:none; outline:none; text-align:center; appearance:none; -webkit-appearance:none; }
    .bg-done { background:#4ade80; }
    .bg-process { background:#fde047; color:#854d0e; }
    .bg-delivery { background:#60a5fa; color:white; }
    .bg-cancel { background:#e53e3e; color:white; }
    .bg-pending { background:#f472b6; color:white; }
</style>

<div class="admin-frame" style="background-color: #F9A3A3; padding: 40px; border-radius: 15px; min-height: 70vh; margin: 0 40px 40px 40px;">
    <!-- Top toolbar inside pink area -->
    <div style="display:flex; gap:20px; align-items:center; margin-bottom:30px;">
        <input type="text" placeholder="Search Transaction" style="padding:15px 25px; border:none; border-radius:30px; width:250px; outline:none; font-weight:600; font-size:0.9rem;">
        <input type="text" placeholder="Search Date" style="padding:15px 25px; border:none; border-radius:30px; width:250px; outline:none; font-weight:600; font-size:0.9rem;">
    </div>

    <div class="trans-frame" style="background: white; border: 2px solid #333;">
        <table class="trans-table">
            <tr>
                <th style="width: 50px;">NO</th>
                <th>TRANSACTION CODE</th>
                <th>DATE</th>
                <th>CUSTOMER NAME</th>
                <th>TOTAL</th>
                <th>STATUS</th>
                <th>ACTION</th>
            </tr>
            @foreach($orders as $order)
            <tr>
                <td style="font-weight:700;">{{ $loop->iteration }}.</td>
                <td style="color:#555;">SCL00{{ $order->id }}</td>
                <td style="color:#555;">{{ $order->created_at ? $order->created_at->format('d-m-Y') : 'N/A' }}</td>
                <td style="color:#555;">{{ optional($order->user)->name ?? 'Guest' }}</td>
                <td style="color:#555;">IDR. {{ number_format((float)$order->total_amount, 0, ',', '.') }}</td>
                <td>
                    @if($order->status === 'Canceled')
                        <span class="status bg-cancel" style="cursor:not-allowed; display:inline-block;">Canceled</span>
                    @else
                        <form action="{{ route(auth()->user()->role . '.order.status', $order->id) }}" method="POST" style="margin:0;">
                            @csrf
                            <select name="status" onchange="this.form.submit()" class="status {{ $order->status == 'Completed' ? 'bg-done' : ($order->status == 'Packed' ? 'bg-process' : ($order->status == 'Delivered' ? 'bg-delivery' : ($order->status == 'Canceled' ? 'bg-cancel' : 'bg-pending'))) }}" style="cursor:pointer; outline:none; text-align:center;">
                                <option value="Not Paid" {{ $order->status == 'Not Paid' ? 'selected' : '' }}>Pending</option>
                                <option value="Packed" {{ $order->status == 'Packed' ? 'selected' : '' }}>Packing</option>
                                <option value="Delivered" {{ $order->status == 'Delivered' ? 'selected' : '' }}>Delivering</option>
                                <option value="Completed" {{ $order->status == 'Completed' ? 'selected' : '' }}>Arrived/Done</option>
                            </select>
                        </form>
                    @endif
                </td>
                <td>
                    <a href="{{ route(auth()->user()->role . '.transactions.show', $order->id) }}" class="btn-see">See</a>
                    <a href="{{ route(auth()->user()->role . '.transactions.print', $order->id) }}" class="btn-print">Print</a>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection
