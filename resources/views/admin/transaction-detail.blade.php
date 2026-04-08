@extends('layouts.admin')
@section('title', 'See Detail')
@section('page_title', 'SEE DETAIL')

@section('content')
<style>
    .module-card { background: white; border-radius: 15px; padding: 25px; margin-bottom: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); }
    .module-title { color: #F9A3A3; font-weight: 800; font-size: 1.1rem; text-transform: uppercase; margin-bottom: 20px; letter-spacing: 1px; }
    
    .info-row { display: flex; margin-bottom: 15px; font-size: 0.95rem; }
    .info-label { width: 150px; color: #555; }
    .info-value { font-weight: 600; color: #111; }
    
    .status-badge { background: #BADFDB; color: white; padding: 5px 15px; border-radius: 20px; font-weight: 700; font-size: 0.75rem; display: inline-block; }
    
    .receipt-container { border: 2px dashed #BADFDB; border-radius: 15px; padding: 20px; max-width: 300px; margin: 0 auto; text-align: center; }
    .receipt-ticket { background: white; border-radius: 10px; padding: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
    .btn-save { background: #F9A3A3; color: white; border: none; padding: 8px 30px; border-radius: 20px; font-weight: 700; cursor: pointer; margin-top: 15px; }
    
    .detail-table { width: 100%; border-collapse: collapse; text-align: left; }
    .detail-table th { color: #555; font-size: 0.8rem; border-bottom: 1px solid #f0f0f0; padding-bottom: 15px; }
    .detail-table td { padding: 15px 0; border-bottom: 1px solid #f9f9f9; font-weight: 600; color: #111; }

    @media print {
        body * { visibility: hidden; }
        .receipt-ticket, .receipt-ticket * { visibility: visible; }
        .receipt-ticket { position: absolute; left: 50%; top: 50px; transform: translateX(-50%); width: 100%; max-width: 400px; box-shadow: none; }
        .btn-save, form { display: none !important; }
    }
</style>

<div class="admin-frame" style="background-color: #F9A3A3; padding: 40px; border-radius: 15px; min-height: 70vh; margin: 0 40px 40px 40px;">
    <div style="display:flex; gap:20px;">
        
        <!-- Left Column -->
        <div style="flex:1;">
            <div class="module-card">
                <div class="module-title">INFO TRANSACTION</div>
                <div class="info-row">
                    <div class="info-label">Transaction Code</div>
                    <div class="info-value">SCL00{{ $order->id }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Date</div>
                    <div class="info-value">{{ $order->created_at ? $order->created_at->format('d-m-Y') : 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Status</div>
                    <div class="info-value">
                        @php
                            $bg = '#F9A3A3';
                            $txt = 'Pending';
                            if ($order->status === 'Completed') {
                                $bg = '#BADFDB; color: #111';
                                $txt = 'Done';
                            } elseif ($order->status === 'Delivered') {
                                $bg = '#60a5fa; color: white';
                                $txt = 'Delivering';
                            } elseif ($order->status === 'Packed') {
                                $bg = '#fde047; color: #854d0e';
                                $txt = 'Process';
                            } elseif ($order->status === 'Canceled') {
                                $bg = '#e53e3e; color: white';
                                $txt = 'Canceled';
                            }
                        @endphp
                        <span class="status-badge" style="background: {{ $bg }}">
                            {{ $txt }}
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="module-card">
                <div class="module-title">INFO CUSTOMER</div>
                <div class="info-row">
                    <div class="info-label">Name</div>
                    <div class="info-value">{{ optional($order->user)->name ?? 'Guest' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ optional($order->user)->email ?? 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Telephone</div>
                    <div class="info-value">{{ optional($order->user)->phone ?? 'N/A' }}</div>
                </div>
            </div>
        </div>
        
        <!-- Right Column (Proof) -->
        <div style="flex:1;">
            <div class="module-card" style="height: 100%; box-sizing: border-box;">
                <div class="module-title" style="text-align: center;">PROOF OF PAYMENT</div>
                
                <div class="receipt-container">
                    @if($order->payment_method === 'COD' || $order->payment_method === 'Cash on Delivery')
                        <div style="margin-bottom: 15px; color:#111; font-size:1rem; font-weight:bold;">
                            <i class="fa-solid fa-money-bill-wave" style="color:#BADFDB; font-size:2.5rem; display:block; margin-bottom:10px;"></i>
                            CASH ON DELIVERY
                        </div>
                    @elseif($order->payment_proof)
                        @php
                            // Fix the URL path if it was saved pointing directly to localhost without 'public/'
                            $proofUrl = $order->payment_proof;
                            if (strpos($proofUrl, '/images/payments') !== false) {
                                // Extract the end part and forcefully redirect to valid public path
                                $parts = explode('/images/payments/', $proofUrl);
                                $cleanPath = '/sociolla/public/images/payments/' . end($parts);
                                $proofUrl = $cleanPath;
                            }
                        @endphp
                        <img src="{{ $proofUrl }}" style="max-width: 100%; border-radius:10px; margin-bottom:15px; box-shadow:0 4px 10px rgba(0,0,0,0.1);" alt="Payment Proof">
                    @else
                        <div style="margin-bottom: 15px; color:#F9A3A3; font-size:1rem; font-weight:bold;">
                            <i class="fa-solid fa-clock-rotate-left" style="font-size:2.5rem; display:block; margin-bottom:10px;"></i>
                            WAITING FOR UPLOAD
                        </div>
                    @endif
                    
                    <div class="receipt-ticket">
                        <div style="font-weight: 800; font-size: 0.85rem; margin-bottom: 20px;">SOCIOLLA RECEIPT</div>
                        
                        <div style="display:flex; justify-content:space-between; font-size:0.75rem; margin-bottom:15px;">
                            <div style="color:#555;">No Transaction</div>
                            <div style="font-weight:700;">SCL00{{ $order->id }}</div>
                        </div>
                        <div style="display:flex; justify-content:space-between; font-size:0.75rem; margin-bottom:15px;">
                            <div style="color:#555;">Date</div>
                            <div style="font-weight:700;">{{ $order->created_at ? $order->created_at->format('d/m/Y') : '' }}</div>
                        </div>
                        <div style="display:flex; justify-content:space-between; font-size:0.75rem; margin-bottom:20px;">
                            <div style="color:#555;">Total Payment</div>
                            <div style="font-weight:800;">IDR. {{ number_format((float)$order->total_amount, 0, ',', '.') }}</div>
                        </div>
                        <div style="display:flex; justify-content:space-between; font-size:0.75rem; margin-bottom:20px;">
                            <div style="color:#555;">Method</div>
                            <div style="font-weight:800;">{{ $order->payment_method ?? 'Transfer Bank' }}</div>
                        </div>
                        
                        @if($order->status == 'Not Paid' && $order->payment_proof)
                            <form action="{{ route(auth()->user()->role . '.order.status', $order->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="Packed">
                                <button type="submit" class="btn-save" style="background:#BADFDB;">APPROVE PAYMENT</button>
                            </form>
                        @elseif($order->status == 'Not Paid' && ($order->payment_method === 'COD' || $order->payment_method === 'Cash on Delivery'))
                            <form action="{{ route(auth()->user()->role . '.order.status', $order->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="Packed">
                                <button type="submit" class="btn-save" style="background:#BADFDB;">APPROVE COD ORDER</button>
                            </form>
                        @elseif($order->status == 'Packed')
                            <form action="{{ route(auth()->user()->role . '.order.status', $order->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="Delivered">
                                <button type="submit" class="btn-save" style="background:#60a5fa; margin-bottom: 10px;">MARK DELIVERED</button>
                            </form>
                            <button onclick="window.print()" class="btn-save">PRINT</button>
                        @elseif($order->status == 'Delivered')
                            <form action="{{ route(auth()->user()->role . '.order.status', $order->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="Completed">
                                <button type="submit" class="btn-save" style="background:#4ade80; margin-bottom: 10px;">MARK COMPLETED</button>
                            </form>
                            <button onclick="window.print()" class="btn-save">PRINT</button>
                        @else
                            <button onclick="window.print()" class="btn-save">PRINT</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    
    <!-- Bottom Module (Details) -->
    <div class="module-card">
        <div class="module-title">PURCHASE DETAILS</div>
        <table class="detail-table">
            <tr>
                <th>PRODUCT</th>
                <th>PRICE</th>
                <th>TOTAL ITEM</th>
                <th>SUBTOTAL</th>
            </tr>
            @foreach($order->items as $item)
            <tr>
                <td>{{ optional($item->product)->name ?? 'Beauty Product' }}</td>
                <td>IDR. {{ number_format((float)$item->price, 0, ',', '.') }}</td>
                <td>{{ $item->quantity }}</td>
                <td>IDR. {{ number_format((float)$item->price * $item->quantity, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </table>
        
        <div style="display:flex; justify-content:space-between; margin-top:20px; padding-top:20px; border-top:2px solid #f0f0f0;">
            <div class="module-title" style="margin:0;">TOTAL TRANSACTION</div>
            <div style="font-size:1.2rem; font-weight:800;">IDR. {{ number_format((float)$order->total_amount, 0, ',', '.') }}</div>
        </div>
    </div>
</div>
@endsection
