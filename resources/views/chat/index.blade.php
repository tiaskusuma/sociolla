@extends('layouts.app')
@section('title', 'Chat dengan CS')

@section('content')
<div style="max-width: 800px; margin: 40px auto; background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
    <div style="background: #F9A3A3; padding: 20px; color: white; display:flex; align-items:center; gap: 10px;">
        <i class="fa-regular fa-comments" style="font-size: 1.5rem;"></i>
        <div>
            <h2 style="margin: 0; font-size: 1.2rem;">Sociolla Customer Service</h2>
            <div style="font-size: 0.8rem; opacity: 0.9;">Sociolla Team siap membantu Anda</div>
        </div>
    </div>
    
    <!-- Auto scroll to bottom script down below -->
    <div id="chat-box" style="padding: 20px; height: 400px; overflow-y: auto; background: #fdfbfb; display:flex; flex-direction:column; gap:15px;">
        @if($messages->isEmpty())
            <div style="text-align:center; color:#999; margin-top:50px;">
                <i class="fa-regular fa-comments" style="font-size: 3rem; margin-bottom: 10px;"></i>
                <p>Belum ada pesan. Mulai ngobrol dengan CS kami jika Anda butuh bantuan.</p>
            </div>
        @else
            @foreach($messages as $msg)
                @if($msg->sender_id === auth()->id())
                    <!-- Pesan dari Customer (Kanan) -->
                    <div style="align-self: flex-end; max-width: 70%;">
                        <div style="background: #BADFDB; padding: 12px 18px; border-radius: 15px 15px 0 15px; color: #111;">
                            {{ $msg->message }}
                        </div>
                        <div style="font-size: 0.7rem; color: #aaa; text-align: right; margin-top: 5px;">
                            {{ $msg->created_at->format('H:i') }}
                        </div>
                    </div>
                @else
                    <!-- Pesan dari Store / Admin / Petugas (Kiri) -->
                    <div style="align-self: flex-start; max-width: 70%; display:flex; gap:10px;">
                        <div style="width: 35px; height: 35px; background: #F9A3A3; border-radius: 50%; display:flex; align-items:center; justify-content:center; color:white; font-size: 1.2rem;">
                            <i class="fa-solid fa-store"></i>
                        </div>
                        <div>
                            <div style="font-size: 0.75rem; font-weight: bold; color: #555; margin-bottom: 3px;">Sociolla Team</div>
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
        @endif
    </div>

    <!-- Kotak Tulis Pesan -->
    <div style="padding: 20px; border-top: 1px solid #eee; background: white;">
        <form action="{{ route('chat.store') }}" method="POST" style="display:flex; gap: 10px; margin: 0;">
            @csrf
            <input type="text" name="message" placeholder="Ketik pertanyaan Anda..." required autocomplete="off" style="flex:1; padding: 15px; border: 1px solid #ccc; border-radius: 30px; outline: none; font-family: 'Inter', sans-serif;">
            <button type="submit" style="background: #F9A3A3; color: white; border: none; width: 50px; height: 50px; border-radius: 50%; cursor: pointer; display:flex; align-items:center; justify-content:center; transition: 0.3s;" onmouseover="this.style.background='#d32f2f'" onmouseout="this.style.background='#F9A3A3'">
                <i class="fa-solid fa-paper-plane"></i>
            </button>
        </form>
    </div>
</div>

<script>
    // Selalu scroll ke paling bawah chat saat halaman dimuat
    var chatBox = document.getElementById("chat-box");
    chatBox.scrollTop = chatBox.scrollHeight;
</script>
@endsection
