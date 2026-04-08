<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Sociolla</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Great+Vibes&family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background-color: #F5F5F5;
        }
        a { text-decoration: none; color: inherit; }
        .product-card {
            background: white;
            padding: 20px;
            text-align: center;
        }
        .product-card img {
            height: 150px;
            object-fit: contain;
            width: 100%;
            margin-bottom: 15px;
        }
        .product-card .brand {
            font-weight: bold;
            font-size: 0.85rem;
            color: #111;
            margin-bottom: 5px;
            text-transform: uppercase;
        }
        .product-card .name {
            font-size: 0.8rem;
            color: #444;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin-bottom: 10px;
            height: 30px;
        }
        .product-card .price {
            color: #d32f2f;
            font-weight: bold;
            font-size: 1rem;
        }
        .product-card .original-price {
            color: #999;
            text-decoration: line-through;
            font-size: 0.75rem;
            margin-left: 5px;
        }
        .product-card .rating {
            margin-top: 10px;
            font-size: 0.8rem;
            color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }
    </style>
</head>
<body>
    <!-- HEADER (Overrides via yields) -->
    <div style="background-color: @yield('header_bg', '#BADFDB'); width: 100%;">
        <div style="max-width: 1100px; margin: 0 auto; padding-top: 20px;">
            
            <!-- Logo, Search, User Links -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <a href="{{ route('home') }}" style="display:flex; align-items:center; gap:5px; text-decoration:none;">
                    <span style="color: @yield('header_icon_color', '#F9A3A3'); font-size:1.5rem;"><i class="fa-solid fa-leaf"></i></span>
                    <span style="font-family: 'Great Vibes', cursive; font-size: 2.2rem; color: @yield('header_color', '#333');">Sociolla</span>
                </a>
                
                <form action="{{ route('home') }}" method="GET" style="display:flex; flex: 1; max-width: 500px; background: white; border-radius: 3px; overflow: hidden; border: 1px solid #ccc; margin:0;">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search beauty products..." style="flex:1; border:none; outline:none; padding: 10px 15px; font-size:0.9rem;">
                    <button type="submit" style="background-color: #a3c4f9; border:none; padding: 0 20px; cursor:pointer;"><i class="fa-solid fa-magnifying-glass" style="color:white;"></i></button>
                </form>
                
                <div style="display: flex; gap: 20px; font-size: 0.85rem; font-weight: bold; color: @yield('header_color', '#333'); align-items:center;">
                    <a href="{{ route('home') }}">Home</a>
                    <a href="{{ route('orders.index') }}" style="text-decoration: @yield('nav_order_underline', 'none');">Order</a>
                    @auth
                        <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                            @csrf
                            <button type="submit" style="background:none; border:none; color:inherit; font:inherit; font-weight:bold; cursor:pointer; padding:0;">Logout</button>
                        </form>
                        <a href="{{ route('cart.index') }}" style="color:@yield('cart_icon_color', '#2b7a6f'); text-decoration:none;"><i class="fa-solid fa-cart-shopping"></i> Cart <span style="background:#4ade80; color:white; padding:2px 5px; border-radius:3px; font-size:0.7rem;">{{ \App\Models\CartItem::where('user_id', Auth::id())->sum('quantity') }}</span></a>
                        <a href="{{ route('chat.index') }}"><i class="fa-regular fa-comments"></i> Chat</a>
                        <a href="{{ route('profile') }}"><i class="fa-solid fa-user"></i> My Account <i class="fa-solid fa-caret-down"></i></a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                        <a href="#"><i class="fa-solid fa-cart-shopping"></i> Cart</a>
                    @endauth
                </div>
            </div>
            
            <!-- Category Navigation Row (Bottom of header) -->
            <div style="display: flex; height: 45px;">
                <a href="{{ route('home') }}" style="text-decoration:none; background-color: @yield('cat_bg_1', '#F9A3A3'); color: @yield('cat_color_1', 'white'); display: flex; align-items: center; padding: 0 25px; font-weight: bold; font-size:0.85rem; gap:10px;">
                    <i class="fa-solid fa-bars"></i> ALL CATEGORIES
                </a>
                <div style="background-color: @yield('cat_bg_2', 'white'); flex: 1; display: flex; align-items: center; gap: 25px; padding-left: 20px; font-weight: bold; font-size: 0.8rem; color: @yield('cat_color_2', '#111');">
                    <a href="{{ route('home', ['filter' => 'new']) }}" style="text-decoration:none; color:inherit; {{ request('filter') == 'new' || (!request('filter') && !request('search')) ? 'color:#F9A3A3; border-bottom:2px solid #F9A3A3; padding-bottom:5px; margin-top:5px;' : '' }}">New Products</a>
                    <a href="{{ route('home', ['filter' => 'popular']) }}" style="text-decoration:none; color:inherit; {{ request('filter') == 'popular' ? 'color:#F9A3A3; border-bottom:2px solid #F9A3A3; padding-bottom:5px; margin-top:5px;' : '' }}">Popular Products</a>
                    <a href="{{ route('home', ['filter' => 'best']) }}" style="text-decoration:none; color:inherit; {{ request('filter') == 'best' ? 'color:#F9A3A3; border-bottom:2px solid #F9A3A3; padding-bottom:5px; margin-top:5px;' : '' }}">Best Seller</a>
                    <a href="{{ route('home', ['filter' => 'deals']) }}" style="text-decoration:none; color:inherit; {{ request('filter') == 'deals' ? 'color:#F9A3A3; border-bottom:2px solid #F9A3A3; padding-bottom:5px; margin-top:5px;' : '' }}">Daily Deals</a>
                    <a href="{{ route('home', ['filter' => 'trending']) }}" style="text-decoration:none; color:inherit; {{ request('filter') == 'trending' ? 'color:#F9A3A3; border-bottom:2px solid #F9A3A3; padding-bottom:5px; margin-top:5px;' : '' }}">Trending</a>
                </div>
            </div>
            
        </div>
    </div>
    
    <!-- MAIN CONTENT -->
    <div style="background-color: #F5F5F5; min-height: 50vh;">
        @yield('content')
    </div>
    
    <!-- FOOTER (CYAN FULL WIDTH) -->
    <div style="background-color: #BADFDB; width: 100%; padding: 40px 0;">
        <div style="max-width: 1100px; margin: 0 auto; display: flex; font-size: 0.8rem; color:#333; justify-content:space-between;">
            
            <!-- Col 1 -->
            <div style="width: 30%;">
                <div style="display:flex; align-items:center; gap:5px; margin-bottom:15px;">
                    <span style="color:#F9A3A3; font-size:1.5rem;"><i class="fa-solid fa-leaf"></i></span>
                    <span style="font-family: 'Great Vibes', cursive; font-size: 1.8rem; color:#333;">Sociolla</span>
                </div>
                <p style="line-height:1.6; color:#555; margin-bottom:20px;">Contemporary beauty and skincare brand dedicated to natural elegance and professional results for all genders.</p>
                <div style="display:flex; gap:10px;">
                    <div style="width:25px; height:25px; background:white; color:#BADFDB; border-radius:50%; display:flex; align-items:center; justify-content:center;"><i class="fa-solid fa-envelope"></i></div>
                    <div style="width:25px; height:25px; background:white; color:#BADFDB; border-radius:50%; display:flex; align-items:center; justify-content:center;"><i class="fa-brands fa-instagram"></i></div>
                    <div style="width:25px; height:25px; background:white; color:#BADFDB; border-radius:50%; display:flex; align-items:center; justify-content:center;"><i class="fa-brands fa-youtube"></i></div>
                </div>
            </div>
            
            <!-- Col 2 -->
            <div>
                <strong style="display:block; margin-bottom:15px; font-size:0.85rem;">SHOP</strong>
                <div style="display:flex; flex-direction:column; gap:10px; color:#555;">
                    <a href="#">Women Skincare</a>
                    <a href="#">Men Grooming</a>
                    <a href="#">Best Sellers</a>
                    <a href="#">New Arrivals</a>
                </div>
            </div>
            
            <!-- Col 3 -->
            <div>
                <strong style="display:block; margin-bottom:15px; font-size:0.85rem;">COMPANY</strong>
                <div style="display:flex; flex-direction:column; gap:10px; color:#555;">
                    <a href="#">Our Story</a>
                    <a href="#">Ingredients</a>
                    <a href="#">Sustainability</a>
                    <a href="#">Careers</a>
                </div>
            </div>
            
            <!-- Col 4 -->
            <div>
                <strong style="display:block; margin-bottom:15px; font-size:0.85rem;">HELP</strong>
                <div style="display:flex; flex-direction:column; gap:10px; color:#555;">
                    <a href="#">Track Order</a>
                    <a href="#">Shipping Policy</a>
                    <a href="#">Returns & Refunds</a>
                    <a href="#">Contact Support</a>
                </div>
            </div>
            
        </div>
        
        <div style="max-width: 1100px; margin: 40px auto 0 auto; text-align: center; color:#666; font-size:0.75rem;">
            Copyright © 2024 Sociolla. Designed with care for premium beauty experiences. <span style="margin-left:20px;">PRIVACY POLICY</span> <span style="margin-left:20px;">TERMS OF SERVICE</span>
        </div>
    </div>

</body>
</html>
