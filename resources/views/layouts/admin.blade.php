<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Sociolla</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { margin: 0; padding: 0; font-family: 'Inter', sans-serif; background: #fbfbfb; display: flex; color: #333; height: 100vh; overflow: hidden; }
        
        /* Sidebar */
        .admin-sidebar {
            width: 260px;
            background: #BADFDB;
            display: flex;
            flex-direction: column;
            padding: 30px 0;
            box-shadow: 2px 0 10px rgba(0,0,0,0.02);
            z-index: 10;
        }

        .admin-logo {
            padding: 0 40px;
            margin-bottom: 50px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .admin-logo .icon {
            width: 40px;
            height: 40px;
            background: #F9A3A3;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        .admin-logo .text {
            color: #F9A3A3;
            font-family: 'Inter', sans-serif;
            font-weight: 800;
            font-size: 1.4rem;
            letter-spacing: 1px;
        }

        .nav-item {
            padding: 15px 40px;
            color: #F9A3A3;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 15px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .nav-item i { font-size: 1.1rem; width: 25px; text-align: center; }
        
        .nav-item.active { background: white; border-radius: 0 30px 30px 0; margin-right: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
        .nav-item:hover:not(.active) { opacity: 0.8; }

        .logout-wrapper { margin-top: auto; padding-top: 20px; }

        /* Main Content wrapper */
        .admin-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow-y: auto;
        }

        /* Top Header */
        .admin-topbar {
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 50px;
            background: white;
            z-index: 5;
        }

        .topbar-title {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1.8rem;
            color: #111;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .topbar-user { display: flex; align-items: center; gap: 15px; text-decoration: none; }
        .topbar-user .role { color: #555; font-weight: 700; font-size: 0.95rem; }
        .topbar-user .avatar { width: 35px; height: 35px; background: #BADFDB; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #235850; }

        /* Content Area */
        .admin-main { flex: 1; display: flex; flex-direction: column; background: #fbfbfb; }

        /* The pink background wrap for active content block */
        .admin-frame {
            margin: 0;
            background: #F9A3A3;
            flex: 1;
            position: relative;
            padding: 40px 50px;
        }

    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="admin-sidebar">
        <div class="admin-logo">
            <div class="icon"><i class="fa-solid fa-leaf"></i></div>
            <div class="text">SOCIOLLA</div>
        </div>

        @php $prefix = auth()->check() ? auth()->user()->role . '.' : 'admin.'; @endphp
        
        <a href="{{ route($prefix . 'dashboard') }}" class="nav-item {{ request()->routeIs($prefix . 'dashboard') ? 'active' : '' }}">
            <i class="fa-brands fa-microsoft"></i> Dashboard
        </a>
        <a href="{{ route($prefix . 'users.index') }}" class="nav-item {{ request()->routeIs($prefix . 'users.*') ? 'active' : '' }}">
            <i class="fa-regular fa-user"></i> User
        </a>
        <a href="{{ route($prefix . 'transactions.index') }}" class="nav-item {{ request()->routeIs($prefix . 'transactions.*') ? 'active' : '' }}">
            <i class="fa-solid fa-file-invoice"></i> Transaction
        </a>
        @if(auth()->check() && auth()->user()->role === 'admin')
        <a href="{{ route('admin.backup') }}" class="nav-item {{ request()->routeIs('admin.backup') ? 'active' : '' }}">
            <i class="fa-solid fa-cloud-arrow-up"></i> BackUp Data
        </a>
        <a href="{{ route('admin.restore') }}" class="nav-item {{ request()->routeIs('admin.restore') ? 'active' : '' }}">
            <i class="fa-solid fa-cloud-arrow-down"></i> Restore Data
        </a>
        @endif
        <a href="{{ route($prefix . 'reports') }}" class="nav-item {{ request()->routeIs($prefix . 'reports') ? 'active' : '' }}">
            <i class="fa-solid fa-chart-simple"></i> Reports
        </a>
        <a href="{{ route($prefix . 'chats.index') }}" class="nav-item {{ request()->routeIs($prefix . 'chats.*') ? 'active' : '' }}">
            <i class="fa-regular fa-comments"></i> Customer Chat
        </a>
        <a href="{{ route($prefix . 'products') }}" class="nav-item {{ request()->routeIs($prefix . 'products*') ? 'active' : '' }}">
            <i class="fa-solid fa-box-open"></i> Products
        </a>

        <div class="logout-wrapper">
            <!-- Form for logout -->
            <form action="{{ route('logout') }}" method="POST" id="logout-form">
                @csrf
                <a href="#" onclick="document.getElementById('logout-form').submit()" class="nav-item" style="color: #e55c5c;">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
                </a>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="admin-content">
        <!-- Topbar -->
        <div class="admin-topbar">
            <div class="topbar-title">@yield('page_title', 'DASHBOARD')</div>
            <a href="{{ route($prefix . 'profile') }}" class="topbar-user">
                <span class="role">{{ ucfirst(auth()->user()->role ?? 'Admin') }}</span>
                @if(auth()->check() && auth()->user()->avatar)
                    <img src="{{ auth()->user()->avatar }}" alt="Avatar" style="object-fit:cover; border-radius:50%; width:35px; height:35px;">
                @else
                    <div class="avatar"><i class="fa-solid fa-user"></i></div>
                @endif
            </a>
        </div>

        <!-- Frame -->
        <div class="admin-main">
            @yield('content')
        </div>
    </div>

</body>
</html>
