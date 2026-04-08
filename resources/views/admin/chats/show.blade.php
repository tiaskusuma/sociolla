@extends('layouts.admin')
@section('title', 'Chat Detail')
@section('page_title', 'CHAT DETAIL')

@section('content')
<div class="admin-frame" style="background-color: #F9A3A3; padding: 40px; border-radius: 15px; min-height: 70vh; margin: 0 40px 40px 40px;">
    
    <div style="max-width: 800px; margin: 0 auto; background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        <div style="background: white; padding: 20px; border-bottom: 2px solid #F9A3A3; display:flex; align-items:center; gap: 15px;">
            @php $prefix = auth()->check() ? auth()->user()->role . '.' : 'admin.'; @endphp
            <a href="{{ route($prefix . 'chats.index') }}" style="color: #666; font-size: 1.2rem; margin-right: 10px;"><i class="fa-solid fa-arrow-left"></i></a>
            <div style="width: 40px; height: 40px; background: #BADFDB; border-radius: 50%; display:flex; align-items:center; justify-content:center; color:#235850;"><i class="fa-solid fa-user"></i></div>
            <div>
                <h2 style="margin: 0; font-size: 1.1rem; color: #111;">{{ $customer->name }}</h2>
                <div style="font-size: 0.8rem; color: #888;">{{ $customer->phone ?? 'Pelanggan Sociolla' }}</div>
            </div>
        </div>
        
        <div id="chat-box" style="padding: 20px; height: 400px; overflow-y: auto; background: #fdfbfb; display:flex; flex-direction:column; gap:15px;">
            @foreach($messages as $msg)
                @if($msg->sender_id !== $customer->id)
                    <!-- Pesan balasan dari Store / Admin / Petugas (Kanan) -->
                    <div style="align-self: flex-end; max-width: 70%; display:flex; flex-direction:column;">
                        <div style="font-size: 0.75rem; font-weight: bold; color: #555; margin-bottom: 3px; text-align:right;">{{ $msg->sender->name }} ({{ ucfirst($msg->sender->role) }})</div>
                        <div style="background: #F9A3A3; padding: 12px 18px; border-radius: 15px 15px 0 15px; color: white;">
                            {{ $msg->message }}
                        </div>
                        <div style="font-size: 0.7rem; color: #aaa; text-align: right; margin-top: 5px;">
                            {{ $msg->created_at->format('H:i') }}
                        </div>
                    </div>
                @else
                    <!-- Pesan asli dari Customer (Kiri) -->
                    <div style="align-self: flex-start; max-width: 70%; display:flex; gap:10px;">
                        <div>
                            <div style="background: #eaeaea; padding: 12px 18px; border-radius: 0 15px 15px 15px; color: #333;">
                                {{ $msg->message }}
                            </div>
                            <div style="font-size: 0.7rem; color: #aaa; margin-top: 5px;">
                                {{ $msg->created_at->format('H:i') }}
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <!-- Kotak Bawah untuk balas -->
        <div style="padding: 20px; border-top: 1px solid #eee; background: white;">
            <form action="{{ route($prefix . 'chats.store', $customer->id) }}" method="POST" style="display:flex; gap: 10px; margin: 0;">
                @csrf
                <input type="text" name="message" placeholder="Ketik balasan untuk {{ $customer->name }}..." required autocomplete="off" style="flex:1; padding: 15px; border: 1px solid #ccc; border-radius: 30px; outline: none; font-family: 'Inter', sans-serif;">
                <button type="submit" style="background: #BADFDB; color: #235850; border: none; width: 50px; height: 50px; border-radius: 50%; cursor: pointer; display:flex; align-items:center; justify-content:center; transition: 0.3s; font-size:1.2rem;" onmouseover="this.style.background='#8acac1'" onmouseout="this.style.background='#BADFDB'">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>

</div>

<script>
    // Auto scroll down
    var chatBox = document.getElementById("chat-box");
    chatBox.scrollTop = chatBox.scrollHeight;
</script>
@endsection
