@extends('layouts.app')
@section('title', 'Edit Profile')
@section('content')

<div style="max-width: 900px; margin: 40px auto; background: white; padding: 40px; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
    
    <div style="border-bottom: 1px solid #eaeaea; padding-bottom: 20px; margin-bottom: 40px;">
        <h1 style="margin: 0 0 10px 0; font-size: 1.5rem; color:#111;">Profil Saya</h1>
        <p style="margin: 0; color: #666; font-size: 0.95rem;">Kelola informasi profil Anda untuk mengontrol, melindungi dan mengamankan akun</p>
    </div>
    
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" style="display:flex; gap: 60px;">
        @csrf
        
        <!-- Left: Form Fields -->
        <div style="flex:1;">
            
            <div style="display:flex; align-items:center; margin-bottom: 25px;">
                <label style="width: 150px; text-align:right; margin-right: 20px; color:#888; font-size:0.95rem;">Username</label>
                <input type="text" name="username" value="{{ $user->username ?? '' }}" style="flex:1; padding:12px 15px; border:1px solid #ddd; outline:none; font-size:1rem; color:#333; box-shadow:inset 0 1px 3px rgba(0,0,0,0.05);">
            </div>
            
            <div style="display:flex; align-items:center; margin-bottom: 25px;">
                <label style="width: 150px; text-align:right; margin-right: 20px; color:#888; font-size:0.95rem;">Nama</label>
                <input type="text" name="name" value="{{ $user->name }}" style="flex:1; padding:12px 15px; border:1px solid #ddd; outline:none; font-size:1rem; color:#333; box-shadow:inset 0 1px 3px rgba(0,0,0,0.05);">
            </div>
            
            <div style="display:flex; align-items:center; margin-bottom: 25px;">
                <label style="width: 150px; text-align:right; margin-right: 20px; color:#888; font-size:0.95rem;">Email</label>
                <input type="email" name="email" value="{{ $user->email }}" style="flex:1; padding:12px 15px; border:1px solid #ddd; outline:none; font-size:1rem; color:#333; box-shadow:inset 0 1px 3px rgba(0,0,0,0.05);">
            </div>
            
            <div style="display:flex; align-items:center; margin-bottom: 25px;">
                <label style="width: 150px; text-align:right; margin-right: 20px; color:#888; font-size:0.95rem;">Nomer Telepon</label>
                <input type="text" name="phone" value="{{ $user->phone }}" placeholder="********65" style="flex:1; padding:12px 15px; border:1px solid #ddd; outline:none; font-size:1rem; color:#333; box-shadow:inset 0 1px 3px rgba(0,0,0,0.05);">
            </div>
            
            <div style="display:flex; align-items:flex-start; margin-bottom: 25px;">
                <label style="width: 150px; text-align:right; margin-right: 20px; color:#888; font-size:0.95rem; margin-top:10px;">Alamat</label>
                <textarea name="address" rows="3" style="flex:1; padding:12px 15px; border:1px solid #ddd; outline:none; font-size:1rem; color:#333; box-shadow:inset 0 1px 3px rgba(0,0,0,0.05); resize:vertical;">{{ $user->address }}</textarea>
            </div>
            
            <div style="display:flex; align-items:center; margin-bottom: 25px;">
                <label style="width: 150px; text-align:right; margin-right: 20px; color:#888; font-size:0.95rem;">Provinsi</label>
                <input type="text" name="province" value="{{ $user->province }}" style="flex:1; padding:12px 15px; border:1px solid #ddd; outline:none; font-size:1rem; color:#333; box-shadow:inset 0 1px 3px rgba(0,0,0,0.05);">
            </div>
            
            <div style="display:flex; align-items:center; margin-bottom: 25px;">
                <label style="width: 150px; text-align:right; margin-right: 20px; color:#888; font-size:0.95rem;">Kota/Kabupaten</label>
                <input type="text" name="city" value="{{ $user->city }}" style="flex:1; padding:12px 15px; border:1px solid #ddd; outline:none; font-size:1rem; color:#333; box-shadow:inset 0 1px 3px rgba(0,0,0,0.05);">
            </div>
            
            <div style="display:flex; align-items:center; margin-bottom: 25px;">
                <label style="width: 150px; text-align:right; margin-right: 20px; color:#888; font-size:0.95rem;">Jenis Kelamin</label>
                <div style="flex:1; display:flex; gap:20px; align-items:center; color:#333; font-size:0.95rem;">
                    <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                        <input type="radio" name="gender" value="Laki-Laki" {{ $user->gender == 'Laki-Laki' ? 'checked' : '' }} style="accent-color:#2b7a6f;"> Laki - Laki
                    </label>
                    <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                        <input type="radio" name="gender" value="Perempuan" {{ $user->gender == 'Perempuan' ? 'checked' : '' }} style="accent-color:#2b7a6f;"> Perempuan
                    </label>
                </div>
            </div>
            
            <div style="display:flex; align-items:center; margin-bottom: 40px;">
                <label style="width: 150px; text-align:right; margin-right: 20px; color:#888; font-size:0.95rem;">Tanggal Lahir</label>
                <input type="date" name="birth_date" value="{{ $user->birth_date ? date('Y-m-d', strtotime($user->birth_date)) : '' }}" style="flex:1; padding:12px 15px; border:1px solid #ddd; outline:none; font-size:1rem; color:#333; box-shadow:inset 0 1px 3px rgba(0,0,0,0.05);">
            </div>
            
            <div style="display:flex;">
                <div style="width: 150px; margin-right: 20px;"></div>
                <button type="submit" style="background: #a8d5ce; color: #2b7a6f; border:none; padding: 12px 40px; font-size:1rem; cursor:pointer; font-weight:bold; border-radius:3px; box-shadow:0 2px 5px rgba(0,0,0,0.1);">Simpan</button>
            </div>
            
        </div>
        
        <!-- Right: Avatar -->
        <div style="width: 250px; border-left: 1px solid #eaeaea; display:flex; flex-direction:column; align-items:center; padding-top:20px;">
            <div style="width:120px; height:120px; border-radius:50%; background:#ddd; color:#888; display:flex; align-items:center; justify-content:center; margin-bottom:30px; overflow:hidden;">
                @if($user->avatar)
                    <img id="avatar-img" src="{{ route('user.avatar') }}?t={{ time() }}" style="width:120px; height:120px; object-fit:cover;">
                @else
                    <img id="avatar-img" src="" style="width:120px; height:120px; object-fit:cover; display:none;">
                    <i id="avatar-icon" class="fa-solid fa-user" style="font-size:4rem;"></i>
                @endif
            </div>
            
            <label style="border: 1px solid #ddd; padding: 10px 20px; border-radius: 3px; font-weight: bold; color: #333; cursor:pointer; font-size:0.9rem;">
                Pilih Gambar
                <input type="file" name="avatar" style="display:none;" accept="image/*" onchange="previewImage(event)">
            </label>
            <div style="font-size:0.75rem; color:#aaa; margin-top:15px; text-align:center; max-width: 80%;">Ukuran gambar: maks. 1 MB<br>Format gambar: .JPEG, .PNG</div>
        </div>
        
    </form>
</div>

<script>
function previewImage(event) {
    const input = event.target;
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.getElementById('avatar-img');
            const icon = document.getElementById('avatar-icon');
            
            if(img) {
                img.src = e.target.result;
                img.style.display = 'block';
            }
            if(icon) {
                icon.style.display = 'none';
            }
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

@endsection
