@extends('layouts.app')
@section('title', 'My Order')

<!-- Overriding Header colors for this specific page to match the Pink Order tracking design -->
@section('header_bg', '#f5a1a1')
@section('header_color', 'white')
@section('header_icon_color', 'white')
@section('nav_order_underline', 'underline')
@section('cart_icon_color', 'white')
@section('cat_bg_1', '#BADFDB')
@section('cat_color_1', '#111')
@section('cat_bg_2', '#BADFDB')
@section('cat_color_2', '#111')

@section('content')

<!-- Huge Pink Banner holding the tab logic -->
<div style="background-color: #f5a1a1; width: 100%; padding: 40px 0 80px 0;">
    <div style="max-width: 1000px; margin: 0 auto;">
        
        <h1 style="font-family:'Playfair Display', serif; font-size: 2.8rem; color: white; text-align: center; margin: 0 0 50px 0;">My Order</h1>
        
        <!-- Tab Circles -->
        <div style="display:flex; justify-content:space-between; align-items:center; position: relative;">
            
            <!-- A subtle line connecting the nodes? (Optional, design shows spaced nodes) -->
            <div style="position:absolute; top: 15px; left:0; right:0; height:1px; background: rgba(255,255,255,0.3); z-index:1;"></div>
            
            <!-- 1. NOT PAID -->
            <a href="{{ route('orders.index', ['tab'=>'not_paid']) }}" style="display:flex; flex-direction:column; align-items:center; text-decoration:none; color:white; z-index:2; position:relative;">
                <div style="width: 30px; height: 30px; border-radius: 50%; border: 2px solid white; display:flex; align-items:center; justify-content:center; margin-bottom:10px; font-size:0.8rem; font-weight:bold; background: {{ $tab == 'not_paid' ? 'white' : '#f5a1a1' }}; color: {{ $tab == 'not_paid' ? '#f5a1a1' : 'white' }};">1</div>
                <div style="font-size: 0.7rem; font-weight:bold; letter-spacing:1px; text-transform:uppercase;">Not Paid</div>
            </a>
            
            <!-- 2. PACKED -->
            <a href="{{ route('orders.index', ['tab'=>'packed']) }}" style="display:flex; flex-direction:column; align-items:center; text-decoration:none; color:white; z-index:2; position:relative;">
                <div style="width: 30px; height: 30px; border-radius: 50%; border: 2px solid white; display:flex; align-items:center; justify-content:center; margin-bottom:10px; font-size:0.8rem; font-weight:bold; background: {{ $tab == 'packed' ? 'white' : '#f5a1a1' }}; color: {{ $tab == 'packed' ? '#f5a1a1' : 'white' }};">2</div>
                <div style="font-size: 0.7rem; font-weight:bold; letter-spacing:1px; text-transform:uppercase;">Packed</div>
            </a>
            
            <!-- 3. DELIVERY -->
            <a href="{{ route('orders.index', ['tab'=>'delivery']) }}" style="display:flex; flex-direction:column; align-items:center; text-decoration:none; color:white; z-index:2; position:relative;">
                <div style="width: 30px; height: 30px; border-radius: 50%; border: 2px solid white; display:flex; align-items:center; justify-content:center; margin-bottom:10px; font-size:0.8rem; font-weight:bold; background: {{ $tab == 'delivery' ? 'white' : '#f5a1a1' }}; color: {{ $tab == 'delivery' ? '#f5a1a1' : 'white' }};">3</div>
                <div style="font-size: 0.7rem; font-weight:bold; letter-spacing:1px; text-transform:uppercase;">Delivery</div>
            </a>
            
            <!-- 4. COMPLETED -->
            <a href="{{ route('orders.index', ['tab'=>'completed']) }}" style="display:flex; flex-direction:column; align-items:center; text-decoration:none; color:white; z-index:2; position:relative;">
                <div style="width: 30px; height: 30px; border-radius: 50%; border: 2px solid white; display:flex; align-items:center; justify-content:center; margin-bottom:10px; font-size:0.8rem; font-weight:bold; background: {{ $tab == 'completed' ? 'white' : '#f5a1a1' }}; color: {{ $tab == 'completed' ? '#f5a1a1' : 'white' }};">4</div>
                <div style="font-size: 0.7rem; font-weight:bold; letter-spacing:1px; text-transform:uppercase;">Completed</div>
            </a>
            
            <!-- 5. RATING -->
            <a href="{{ route('orders.index', ['tab'=>'rating']) }}" style="display:flex; flex-direction:column; align-items:center; text-decoration:none; color:white; z-index:2; position:relative;">
                <div style="width: 30px; height: 30px; border-radius: 50%; border: 2px solid white; display:flex; align-items:center; justify-content:center; margin-bottom:10px; font-size:0.8rem; font-weight:bold; background: {{ $tab == 'rating' ? 'white' : '#f5a1a1' }}; color: {{ $tab == 'rating' ? '#f5a1a1' : 'white' }};">5</div>
                <div style="font-size: 0.7rem; font-weight:bold; letter-spacing:1px; text-transform:uppercase;">Rating</div>
            </a>
        </div>
        
    </div>
</div>

<!-- Order Cards Wrapper (Overlapping the banner) -->
<div style="max-width: 1000px; margin: -50px auto 40px auto; display:flex; flex-direction:column; gap:20px;">
    
    @forelse($orders as $order)
    
        <div style="background: white; border-radius: 15px; padding: 25px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); position:relative; z-index:10;">
            
            @php 
                // Display the first item logically as the representative item of the order
                $firstItem = $order->items->first(); 
            @endphp
            
            @if($firstItem)
            <!-- Product Information -->
            <div style="display:flex; gap: 20px; align-items:center; border-bottom: 1px solid #eaeaea; padding-bottom: 20px; margin-bottom: 20px;">
                <div style="width: 100px; height: 100px; border-radius: 10px; background: #eaabaa; display:flex; align-items:center; justify-content:center; overflow:hidden;">
                    <img src="{{ $firstItem->product->image_url }}" style="height: 80%; object-fit:contain;">
                </div>
                <div style="flex: 1;">
                    <div style="font-weight:bold; font-size:1.1rem; color:#111; margin-bottom:5px;">{{ $firstItem->product->name }}</div>
                    <div style="font-size:0.8rem; color:#888; margin-bottom:2px;">Original Product</div>
                    <div style="font-size:0.8rem; color:#888; margin-bottom:10px;">Total Item: {{ $order->items->sum('quantity') }}</div>
                    <div style="font-size:1.2rem; font-weight:bold; color:#F9A3A3;">IDR. {{ number_format($order->total_amount, 0, ',', '.') }}</div>
                </div>
            </div>
            @endif
            
            <!-- Lower Section (Latest Update & Actions) -->
            @if($tab == 'delivery' || $tab == 'completed')
                <!-- Latest Update Grey Box -->
                <div style="background: #f9f9f9; border-radius: 8px; padding: 15px; margin-bottom: 20px; display:flex; gap:15px; align-items:center;">
                    <div style="width:30px; height:30px; border-radius:50%; border:2px solid #2b7a6f; color:#2b7a6f; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <i class="fa-solid fa-check" style="font-size:0.8rem;"></i>
                    </div>
                    <div>
                        <div style="font-weight:bold; font-size:0.8rem; color:#111; margin-bottom:3px;">Latest Update</div>
                        <div style="font-size:0.8rem; color:#666;">
                            @if($tab == 'delivery')
                                {{ $order->tracking_status ?? 'Courier is processing your order' }}
                            @else
                                Order arrived on {{ $order->updated_at->format('F d, Y') }}. Thank you for shopping at Sociolla!
                            @endif
                        </div>
                    </div>
                </div>
            @endif
            
            <div style="display:flex; justify-content:space-between; align-items:flex-end;">
                <div>
                    <div style="font-size:0.65rem; color:#aaa; font-weight:bold; letter-spacing:1px; margin-bottom:5px;">STATUS</div>
                    @if($tab == 'not_paid')
                        <div style="color: #ed5f5f; font-weight:bold; font-size:1rem;">Not Paid</div>
                    @elseif($tab == 'packed')
                        <div style="color: #6ed1cf; font-weight:bold; font-size:1rem;">Packed</div>
                    @elseif($tab == 'delivery')
                        <div style="color: #6ed1cf; font-weight:bold; font-size:1rem;">In Delivery</div>
                    @elseif($tab == 'completed')
                        <div style="color: #6ed1cf; font-weight:bold; font-size:1rem;">Completed</div>
                    @endif
                </div>
                
                <div style="display:flex; gap: 10px;">
                    @if($tab == 'not_paid')
                        @if($order->payment_method === 'COD' || $order->payment_method === 'Cash on Delivery')
                            <span style="background: #f9f9f9; color:#888; border:1px solid #ddd; padding:10px 30px; border-radius: 30px; font-weight:bold; font-size:0.85rem;"><i class="fa-solid fa-clock" style="margin-right:5px;"></i> Menunggu Konfirmasi (COD)</span>
                            <form action="{{ route('orders.cancel', $order->id) }}" method="POST" style="margin:0;">
                                @csrf
                                <button type="submit" onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')" style="background: #e53e3e; color:white; border:none; padding:10px 30px; border-radius: 30px; font-weight:bold; font-size:0.85rem; cursor:pointer;"><i class="fa-solid fa-xmark" style="margin-right:5px;"></i> Batalkan Pesanan</button>
                            </form>
                        @elseif($order->payment_proof)
                            <span style="background: #f9f9f9; color:#888; border:1px solid #ddd; padding:10px 30px; border-radius: 30px; font-weight:bold; font-size:0.85rem;"><i class="fa-solid fa-clock" style="margin-right:5px;"></i> Menunggu Konfirmasi Admin</span>
                        @else
                            <a href="{{ route('payment.show', $order->id) }}" style="background: #f5a1a1; color:white; border:none; padding:10px 30px; border-radius: 30px; font-weight:bold; font-size:0.85rem; text-decoration:none;"><i class="fa-solid fa-paper-plane" style="margin-right:5px;"></i> Konfirmasi Pembayaran</a>
                            <form action="{{ route('orders.cancel', $order->id) }}" method="POST" style="margin:0;">
                                @csrf
                                <button type="submit" onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')" style="background: #e53e3e; color:white; border:none; padding:10px 30px; border-radius: 30px; font-weight:bold; font-size:0.85rem; cursor:pointer;"><i class="fa-solid fa-xmark" style="margin-right:5px;"></i> Batalkan Pesanan</button>
                            </form>
                        @endif
                    @elseif($tab == 'packed')
                        <div style="display:flex; align-items:center; gap:10px;">
                            <span style="font-size:0.85rem; color:#aaa; font-style:italic;">Belum bisa dilacak</span>
                            <a href="{{ route('payment.receipt', $order->id) }}" style="background: white; border: 2px solid #f5a1a1; color:#f5a1a1; padding:10px 20px; border-radius: 30px; font-weight:bold; font-size:0.85rem; text-decoration:none;">Lihat Kuitansi</a>
                        </div>
                    @elseif($tab == 'delivery')
                        <a href="{{ route('payment.receipt', $order->id) }}" style="background: white; border: 2px solid #f5a1a1; color:#f5a1a1; padding:10px 20px; border-radius: 30px; font-weight:bold; font-size:0.85rem; text-decoration:none;">Lihat Kuitansi</a>
                        <button onclick="openTrackModal('{{ $order->id }}', '{{ addslashes($order->tracking_status ?? 'Waiting for store processing') }}')" style="background: #f5a1a1; color:white; border:none; padding:10px 20px; border-radius: 30px; font-weight:bold; font-size:0.85rem; text-decoration:none; cursor:pointer;"><i class="fa-solid fa-truck" style="margin-right:5px;"></i> Track Order</button>
                    @elseif($tab == 'completed')
                        <a href="{{ route('payment.receipt', $order->id) }}" style="background: white; border: 2px solid #f5a1a1; color:#f5a1a1; padding:10px 30px; border-radius: 30px; font-weight:bold; font-size:0.85rem; text-decoration:none;">Lihat Kuitansi</a>
                        <form action="{{ route('orders.receive', $order->id) }}" method="POST" style="margin:0;">
                            @csrf
                            <button type="submit" style="background: #f5a1a1; color:white; border:none; padding:10px 30px; border-radius: 30px; font-weight:bold; font-size:0.85rem; cursor:pointer;"><i class="fa-solid fa-check" style="margin-right:5px;"></i> Pesanan Diterima</button>
                        </form>
                    @elseif($tab == 'rating')
                        <!-- In the rating tab, actions are centered and full width below stars usually, but we stick to layout constraints -->
                    @endif
                </div>
            </div>
            
            @if($tab == 'rating')
            <div style="text-align:center; border-top: 1px solid #eaeaea; margin-top:20px; padding-top:20px;">
                <div style="font-size:0.65rem; color:#aaa; font-weight:bold; letter-spacing:1px; margin-bottom:5px;">STATUS</div>
                
                @if($order->is_rated)
                    <div style="color: #6ed1cf; font-weight:bold; font-size:1rem; margin-bottom:15px;">Review Completed</div>
                    <div style="display:flex; justify-content:center; gap: 10px; color:#F9A3A3; font-size:1.2rem; margin-bottom:10px;">
                        @for($i=1; $i<=5; $i++)
                            <i class="{{ $i <= $order->rating_stars ? 'fa-solid' : 'fa-regular' }} fa-star"></i>
                        @endfor
                    </div>
                    <div style="font-size:0.85rem; color:#666; margin-bottom:15px; font-style:italic;">"{{ $order->rating_review }}"</div>
                    <span style="display:block; width:100%; background: #eaeaea; color:#888; border:none; padding:12px; border-radius: 30px; font-weight:bold; font-size:0.85rem;"><i class="fa-solid fa-check" style="margin-right:5px;"></i> Rated</span>
                @else
                    <div style="color: #F9A3A3; font-weight:bold; font-size:1rem; margin-bottom:15px;">Waiting for Review</div>
                    
                    <div style="display:flex; justify-content:center; gap: 10px; color:#eaeaea; font-size:1.2rem; margin-bottom:20px;">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                    </div>
                    
                    <a href="{{ route('orders.rate', $order->id) }}" style="display:block; width:100%; background: #f5a1a1; color:white; border:none; padding:12px; border-radius: 30px; font-weight:bold; font-size:0.85rem; text-decoration:none; margin-bottom:15px;"><i class="fa-solid fa-image" style="margin-right:5px;"></i> Give Rating</a>
                @endif
                <a href="{{ route('payment.receipt', $order->id) }}" style="font-size:0.75rem; color:#888; font-weight:bold; text-transform:uppercase; text-decoration:none; margin-top:10px; display:inline-block;">Lihat Kuitansi</a>
            </div>
            @endif
            
        </div>
        
    @empty
        
        <div style="background: white; border-radius: 15px; padding: 50px; text-align:center; box-shadow: 0 10px 25px rgba(0,0,0,0.05); position:relative; z-index:10; color:#888;">
            <i class="fa-solid fa-box-open" style="font-size:3rem; margin-bottom:15px; color:#ddd;"></i>
            <div>Tidak ada pesanan di kategori ini.</div>
        </div>
        
    @endforelse
    
    <div style="background: #f5a1a1; border-radius: 10px; padding: 15px; text-align:center; color: white; font-family:'Playfair Display', serif; font-size: 1.2rem; margin-top:20px;">
        Your Daily Beauty Destination
    </div>
    
</div>

</div>

<!-- Track Order Modal -->
<div id="trackOrderModal" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5); align-items:center; justify-content:center;">
    <div style="background:white; border-radius:15px; width:400px; max-width:90%; padding:30px; position:relative; box-shadow:0 15px 30px rgba(0,0,0,0.1);">
        <button onclick="closeTrackModal()" style="position:absolute; top:20px; right:20px; background:none; border:none; font-size:1.2rem; color:#aaa; cursor:pointer;"><i class="fa-solid fa-xmark"></i></button>
        <div style="text-align:center; margin-bottom:20px;">
            <div style="width:60px; height:60px; border-radius:50%; background:#f5a1a1; color:white; display:flex; align-items:center; justify-content:center; margin: 0 auto 15px auto; font-size:1.5rem;">
                <i class="fa-solid fa-location-dot"></i>
            </div>
            <h3 style="margin:0 0 5px 0; color:#111; font-family:'Playfair Display', serif; font-size:1.5rem;">Tracking Info</h3>
            <div style="font-size:0.85rem; color:#888;">Order #<span id="modalOrderId"></span></div>
        </div>
        
        <div style="background:#f9f9f9; padding:20px; border-radius:10px; text-align:center;">
            <div style="font-size:0.75rem; color:#aaa; letter-spacing:1px; margin-bottom:5px; text-transform:uppercase; font-weight:bold;">Current Status</div>
            <div id="modalOrderStatus" style="font-size:1.1rem; color:#2b7a6f; font-weight:bold;"></div>
        </div>
        
        <button onclick="closeTrackModal()" style="width:100%; padding:15px; background:#f5a1a1; color:white; border:none; border-radius:30px; font-weight:bold; margin-top:20px; cursor:pointer;">Close</button>
    </div>
</div>

<script>
function openTrackModal(orderId, status) {
    document.getElementById('modalOrderId').innerText = orderId;
    document.getElementById('modalOrderStatus').innerText = status;
    document.getElementById('trackOrderModal').style.display = 'flex';
}

function closeTrackModal() {
    document.getElementById('trackOrderModal').style.display = 'none';
}
</script>

@endsection
