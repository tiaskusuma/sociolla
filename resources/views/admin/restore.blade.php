@extends('layouts.admin')
@section('title', 'Restore Data')
@section('page_title', 'RESTORE DATA')

@section('content')
<style>
    .restore-widget {
        background: white;
        border-radius: 20px;
        padding: 50px 80px;
        max-width: 500px;
        margin: 50px auto;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
    
    .sync-icon {
        width: 70px;
        height: 70px;
        background: #f0fdf4;
        color: #F9A3A3;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin: 0 auto 20px auto;
    }

    .upload-zone {
        border: 2px dashed #BADFDB;
        border-radius: 10px;
        padding: 40px 20px;
        margin: 30px 0;
        cursor: pointer;
        transition: 0.3s;
    }
    .upload-zone:hover { background: #f0fdf4; }
    
    .btn-restore {
        background: #BADFDB;
        color: white;
        border: none;
        padding: 15px 40px;
        border-radius: 30px;
        font-weight: 800;
        cursor: pointer;
        font-size: 1rem;
        letter-spacing: 1px;
    }
</style>

<div class="admin-frame" style="background-color: #F9A3A3; padding: 50px; border-radius: 15px; min-height: 70vh; margin: 0 40px 40px 40px; display:flex; align-items:center;">
    
    <div class="restore-widget">
        <div class="sync-icon">
            <i class="fa-solid fa-rotate"></i>
        </div>
        <h2 style="margin:0 0 10px 0; color:#111; font-size:1.4rem;">Upload Backup File</h2>
        <p style="margin:0; color:#666; font-size:0.9rem;">Please upload your database backup file to restore the data.</p>
        
        <div class="upload-zone" onclick="document.getElementById('file-upload').click()">
            <i class="fa-solid fa-cloud-arrow-up" style="font-size:2rem; color:#BADFDB; margin-bottom:15px;"></i>
            <div style="color:#555; font-size:0.9rem; font-weight:600;">
                Select or drag backup file here <span style="color:#F9A3A3;">(.sql)</span>
            </div>
        </div>
        <input type="file" id="file-upload" style="display:none;" accept=".sql">

        <button class="btn-restore" onclick="alert('Simulation: Database restored successfully!')">RESTORE NOW</button>
    </div>

</div>
@endsection
