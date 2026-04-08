@extends('layouts.admin')
@section('title', 'Manajemen User')
@section('page_title', 'MANAJEMEN USER')

@section('content')
<style>
    .user-frame {
        background: white; 
        border: 2px solid #333; 
        margin: 20px 50px 50px 50px; 
    }
    .user-table { width:100%; border-collapse:collapse; text-align:center; }
    .user-table th, .user-table td { border: 1px solid #333; padding: 15px; }
    .user-table th { font-weight:800; font-size:0.85rem; color:#111; }
    
    .btn-edit { background:#BADFDB; color:white; border:none; padding:8px 12px; border-radius:5px; cursor:pointer; }
    .btn-del { background:#F9A3A3; color:white; border:none; padding:8px 12px; border-radius:5px; cursor:pointer; }
    
    .status-badge { background:#4ade80; color:white; padding:5px 15px; border-radius:20px; font-weight:700; font-size:0.75rem; }
</style>

<div class="admin-frame" style="background-color: #F9A3A3; padding: 40px; border-radius: 15px; min-height: 70vh; margin: 0 40px 40px 40px;">
    <!-- Top toolbar inside pink area -->
    <div style="display:flex; margin-bottom:30px;">
        <input type="text" placeholder="Search" style="padding:15px 25px; border:none; border-radius:30px; width:400px; outline:none; font-weight:600; font-size:0.95rem;">
    </div>

    <!-- White table container -->
    <div class="user-frame" style="background: white; border: 2px solid #333; /* padding inside or just raw table */">
        @if(session('success'))
            <div style="background:#d4edda; color:#155724; padding:10px; border-radius:5px; margin-bottom:20px;">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div style="background:#f8d7da; color:#721c24; padding:10px; border-radius:5px; margin-bottom:20px;">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div style="background:#f8d7da; color:#721c24; padding:10px; border-radius:5px; margin-bottom:20px;">
                @foreach ($errors->all() as $e) <div>{{ $e }}</div> @endforeach
            </div>
        @endif

        <table class="user-table">
            <tr>
                <th style="width: 50px;">NO</th>
                <th>USERNAME</th>
                <th>FULL NAME</th>
                <th>ROLE</th>
                <th>STATUS</th>
                <th>ACTION</th>
            </tr>
            @php $prefix = auth()->check() ? auth()->user()->role . '.' : 'admin.'; @endphp
            @foreach($usersList as $user)
            <tr>
                <td style="font-weight:700;">{{ $loop->iteration }}.
                    <form action="{{ route($prefix . 'users.update', $user->id) }}" method="POST" id="edit-form-{{ $user->id }}">@csrf</form>
                    <form action="{{ route($prefix . 'users.delete', $user->id) }}" method="POST" id="del-form-{{ $user->id }}">@csrf</form>
                </td>
                <td style="color:#555; font-weight:600;">
                    <input type="text" name="username" value="{{ $user->username }}" form="edit-form-{{ $user->id }}" style="border:1px solid #ddd; padding:5px; border-radius:5px; width:90%; outline:none;" class="edit-input-{{ $user->id }}" disabled>
                </td>
                <td style="color:#555;">
                    <input type="text" name="name" value="{{ $user->name }}" form="edit-form-{{ $user->id }}" style="border:1px solid #ddd; padding:5px; border-radius:5px; width:90%; outline:none;" class="edit-input-{{ $user->id }}" disabled>
                </td>
                <td style="color:#555;">
                    <select name="role" form="edit-form-{{ $user->id }}" style="border:1px solid #ddd; padding:5px; border-radius:5px; outline:none; text-transform:capitalize;" class="edit-input-{{ $user->id }}" disabled>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="petugas" {{ $user->role == 'petugas' ? 'selected' : '' }}>Petugas</option>
                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                    </select>
                </td>
                <td><span class="status-badge">Aktif</span></td>
                <td>
                    <button type="button" class="btn-edit" onclick="toggleEdit({{ $user->id }})" id="btn-edit-{{ $user->id }}"><i class="fa-solid fa-pencil"></i></button>
                    <button type="submit" class="btn-edit" style="display:none; background:#4ade80;" form="edit-form-{{ $user->id }}" id="btn-save-{{ $user->id }}"><i class="fa-solid fa-check"></i></button>
                    <button type="submit" class="btn-del" form="del-form-{{ $user->id }}" onclick="return confirm('Delete user {{ $user->name }}?')"><i class="fa-solid fa-trash"></i></button>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>

<script>
function toggleEdit(id) {
    let inputs = document.querySelectorAll('.edit-input-' + id);
    let editBtn = document.getElementById('btn-edit-' + id);
    let saveBtn = document.getElementById('btn-save-' + id);
    
    inputs.forEach(el => el.disabled = false);
    editBtn.style.display = 'none';
    saveBtn.style.display = 'inline-block';
}
</script>
@endsection
