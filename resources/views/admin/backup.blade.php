@extends('layouts.admin')
@section('title', 'Backup Data')
@section('page_title', 'BACKUP DATA')

@section('content')
<style>
    .backup-widget {
        background: white;
        border-radius: 20px;
        padding: 40px;
        width: 350px;
        margin: 0 auto 50px auto;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
    
    .cloud-icon {
        width: 80px;
        height: 80px;
        background: #BADFDB;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin: 20px auto;
    }
    
    .btn-backup {
        background: #BADFDB;
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 30px;
        font-weight: 800;
        cursor: pointer;
        font-size: 0.95rem;
        letter-spacing: 1px;
    }

    .table-frame {
        background: white; 
        border-radius: 10px;
        overflow: hidden;
    }
    .data-table { width:100%; border-collapse:collapse; text-align:left; }
    .data-table th, .data-table td { border-bottom: 1px solid #ddd; border-right: 1px solid #ddd; padding: 20px 15px; }
    .data-table th:last-child, .data-table td:last-child { border-right: none; }
    .data-table th { font-weight:800; font-size:0.8rem; color:#111; text-transform:uppercase; }
    .data-table td { color:#555; }
    
    .icon-action { font-size:1.1rem; cursor:pointer; color:#BADFDB; margin-right:15px; }
    .icon-trash { font-size:1.1rem; cursor:pointer; color:#F9A3A3; }
</style>

<div class="admin-frame" style="background-color: #F9A3A3; padding: 50px; border-radius: 15px; min-height: 70vh; margin: 0 40px 40px 40px;">
    
    @if(session('success'))
        <div style="background:#d4edda; color:#155724; padding:10px; border-radius:5px; margin-bottom:20px; text-align:center; font-weight:600;">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div style="background:#f8d7da; color:#721c24; padding:10px; border-radius:5px; margin-bottom:20px; text-align:center; font-weight:600;">{{ session('error') }}</div>
    @endif

    <!-- Central Backup Widget -->
    <div class="backup-widget">
        <h3 style="margin:0; font-weight:700; color:#333; font-size:1.1rem;">Database Backup</h3>
        <div class="cloud-icon">
            <i class="fa-solid fa-cloud-arrow-up"></i>
        </div>
        <form action="{{ route('admin.backup.create') }}" method="POST">
            @csrf
            <button type="submit" class="btn-backup">BACKUP NOW</button>
        </form>
    </div>

    <!-- History Table -->
    <div class="table-frame">
        <table class="data-table">
            <tr>
                <th style="width: 50px; text-align:center;">NO</th>
                <th>BACKUP DATE</th>
                <th>FILE NAME</th>
                <th>SIZE</th>
                <th style="text-align:center;">ACTION</th>
            </tr>
            @foreach($backups as $i => $rec)
            <tr>
                <td style="font-weight:700; text-align:center;">{{ $i + 1 }}.</td>
                <td>{{ $rec->date }}</td>
                <td>{{ $rec->name }}</td>
                <td>{{ $rec->size }}</td>
                <td style="text-align:center;">
                    <a href="{{ route('admin.backup.download', $rec->name) }}" title="Download"><i class="fa-solid fa-download icon-action"></i></a>
                    <form action="{{ route('admin.backup.delete', $rec->name) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Delete this backup file?')">
                        @csrf
                        <button type="submit" style="background:none; border:none; padding:0; outline:none;" title="Delete"><i class="fa-solid fa-trash-can icon-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>

</div>
@endsection
