@extends('layouts.admin')
@section('title', ucfirst(auth()->user()->role ?? 'Admin') . ' Profile')
@section('page_title', strtoupper(auth()->user()->role ?? 'Admin') . ' PROFILE')

@section('content')
<style>
    /* Use fixed exact colors from design */
    .profile-card {
        background: white;
        border-radius: 25px;
        margin: 0 auto;
        width: 850px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        overflow: hidden;
        position: relative;
        text-align: center;
        padding-bottom: 50px;
    }
    
    .profile-header {
        height: 140px;
        background: #BADFDB;
    }
    
    .avatar-wrapper {
        width: 130px; 
        height: 130px;
        background: white;
        border-radius: 50%;
        margin: -65px auto 20px auto;
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    
    .avatar-wrapper img { width:88%; height:88%; object-fit:cover; border-radius:50%; }
    .status-dot { position:absolute; bottom:12px; right:12px; width:16px; height:16px; background:#4ade80; border-radius:50%; border:3px solid white; box-sizing: content-box; }

    .name { font-size:1.7rem; font-weight:800; color:#333; margin-bottom:5px; margin-top:20px; font-family:'Inter', sans-serif;}
    .subtitle { color:#999; font-size:0.95rem; font-weight:500; margin-bottom:40px; font-family:'Inter', sans-serif;}
    
    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 25px 30px;
        padding: 0 80px;
        text-align: left;
        margin-bottom: 50px;
    }
    
    .info-group label { display:block; font-size:0.75rem; font-weight:700; color:#aaa; text-transform:uppercase; margin-bottom:10px; letter-spacing:1.5px; font-family:'Inter', sans-serif;}
    .info-input { 
        width:100%; box-sizing:border-box; background:#F8FAFB; border:none; padding:18px 25px; 
        border-radius:12px; font-weight:600; color:#333; font-family:'Inter', sans-serif;
        display:flex; align-items:center; font-size:0.95rem;
    }
    
    .info-input i { width:25px; color: #F9A3A3; font-size:1.1rem; }
    
    .btn-group { display:flex; justify-content:center; gap:20px; padding:0 80px; }
    .btn-pass { background:#BADFDB; color:#235850; border:none; padding:18px 0; width:50%; border-radius:12px; font-weight:800; cursor:pointer; font-size:0.85rem; letter-spacing:1px; text-decoration:none; text-align:center; font-family:'Inter', sans-serif;}
    .btn-edit { background:#F9A3A3; color:white; border:none; padding:18px 0; width:50%; border-radius:12px; font-weight:800; cursor:pointer; font-size:0.85rem; letter-spacing:1px; text-decoration:none; text-align:center; font-family:'Inter', sans-serif;}
    
    .footer-text { text-align:center; color:rgba(255,255,255,0.9); font-size:0.85rem; margin-top:30px; font-weight:500; font-family:'Inter', sans-serif; }

    /* Modals for editing */
    .modal-overlay { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:100; justify-content:center; align-items:center; }
    .modal-box { background:white; padding:40px; border-radius:20px; width:500px; max-width:90%; position:relative;}
    .modal-close { position:absolute; top:20px; right:20px; cursor:pointer; font-size:1.5rem; color:#888; }
    .modal-title { font-size:1.5rem; font-weight:800; margin-bottom:20px; color:#333; }
    .modal-input { width:100%; box-sizing:border-box; background:#f9f9f9; border:1px solid #eee; padding:15px; border-radius:10px; margin-bottom:20px; font-family:'Inter', sans-serif; font-weight:500;}
</style>

<div class="admin-frame" style="background-color: #F9A3A3; display:flex; flex-direction:column; justify-content:center; padding: 50px 0; min-height: calc(100vh - 80px); box-sizing:border-box;">
    
    <div class="profile-card">
        <div class="profile-header"></div>
        
        <div class="avatar-wrapper">
            <img src="{{ auth()->user()->avatar ?? 'https://i.pravatar.cc/150?img=11' }}" alt="Profile">
            <div class="status-dot"></div>
        </div>
        
        <div class="name">{{ auth()->user()->name }}</div>
        <div class="subtitle">{{ auth()->user()->role === 'petugas' ? 'Manage your staff account information and shift details' : 'Manage your account information and security' }}</div>
        
        @if(session('success'))
            <div style="background:#d4edda; color:#155724; padding:15px; border-radius:10px; margin: 0 80px 30px 80px; font-weight:600; font-size:0.9rem;">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div style="background:#f8d7da; color:#721c24; padding:15px; border-radius:10px; margin: 0 80px 30px 80px; font-weight:600; font-size:0.9rem;">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div style="background:#f8d7da; color:#721c24; padding:15px; border-radius:10px; margin: 0 80px 30px 80px; font-weight:600; font-size:0.9rem; text-align:left;">
                <ul style="margin:0; padding-left:20px;">
                @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                </ul>
            </div>
        @endif

        @php $prefix = auth()->check() ? auth()->user()->role . '.' : 'admin.'; @endphp

        <!-- Display Only Grid -->
        <div class="info-grid">
            <div class="info-group">
                <label>FULL NAME</label>
                <div class="info-input">{{ auth()->user()->name }}</div>
            </div>
            <div class="info-group">
                <label>EMAIL ADDRESS</label>
                <div class="info-input">{{ auth()->user()->email }}</div>
            </div>
            <div class="info-group">
                <label>ROLE</label>
                <div class="info-input">
                    <i class="fa-solid fa-id-badge"></i> 
                    {{ ucfirst(auth()->user()->role ?? 'Admin') }}
                </div>
            </div>
            @if(auth()->check() && auth()->user()->role === 'petugas')
            <div class="info-group">
                <label>SHIFT TIME</label>
                <div class="info-input">
                    <i class="fa-regular fa-clock" style="color:#BADFDB;"></i> 
                    08:00 AM - 04:00 PM
                </div>
            </div>
            @else
            <div class="info-group">
                <label>JOIN DATE</label>
                <div class="info-input">
                    <i class="fa-regular fa-calendar" style="color:#BADFDB;"></i> 
                    {{ auth()->user()->created_at ? auth()->user()->created_at->format('F d, Y') : 'Unknown' }}
                </div>
            </div>
            @endif
        </div>
        
        <div class="btn-group">
            <button type="button" class="btn-pass" onclick="document.getElementById('passModal').style.display='flex'">CHANGE PASSWORD</button>
            <button type="button" class="btn-edit" onclick="document.getElementById('editModal').style.display='flex'">EDIT PROFILE</button>
        </div>
    </div>
    
    <div class="footer-text">
        &copy; 2024 Sociolla Internal {{ auth()->user()->role === 'petugas' ? 'Staff' : 'Admin' }} Panel. All Rights Reserved.
    </div>
    
</div>

<!-- Edit Profile Modal -->
<div class="modal-overlay" id="editModal">
    <div class="modal-box">
        <i class="fa-solid fa-xmark modal-close" onclick="document.getElementById('editModal').style.display='none'"></i>
        <div class="modal-title">Edit Profile</div>
        <form action="{{ route($prefix . 'profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label style="font-size:0.8rem; font-weight:700; color:#555; display:block; margin-bottom:5px;">Full Name</label>
            <input type="text" name="name" class="modal-input" value="{{ auth()->user()->name }}" required>
            
            <label style="font-size:0.8rem; font-weight:700; color:#555; display:block; margin-bottom:5px;">Email Address</label>
            <input type="email" name="email" class="modal-input" value="{{ auth()->user()->email }}" required>
            
            <label style="font-size:0.8rem; font-weight:700; color:#555; display:block; margin-bottom:5px;">Profile Picture</label>
            <input type="file" name="avatar" class="modal-input" accept="image/*">
            
            <button type="submit" class="btn-edit" style="width:100%; padding:15px 0;">SAVE CHANGES</button>
        </form>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal-overlay" id="passModal">
    <div class="modal-box">
        <i class="fa-solid fa-xmark modal-close" onclick="document.getElementById('passModal').style.display='none'"></i>
        <div class="modal-title">Change Password</div>
        <form action="{{ route($prefix . 'profile.password') }}" method="POST">
            @csrf
            <label style="font-size:0.8rem; font-weight:700; color:#555; display:block; margin-bottom:5px;">Current Password</label>
            <input type="password" name="current_password" class="modal-input" placeholder="Enter current password" required>
            
            <label style="font-size:0.8rem; font-weight:700; color:#555; display:block; margin-bottom:5px;">New Password</label>
            <input type="password" name="password" class="modal-input" placeholder="Enter new password" required>
            
            <label style="font-size:0.8rem; font-weight:700; color:#555; display:block; margin-bottom:5px;">Confirm Password</label>
            <input type="password" name="password_confirmation" class="modal-input" placeholder="Confirm new password" required>
            
            <button type="submit" class="btn-pass" style="width:100%; padding:15px 0; color:white; background:#235850;">UPDATE PASSWORD</button>
        </form>
    </div>
</div>
@endsection
