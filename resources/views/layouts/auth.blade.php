<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Sociolla</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/sociolla/public/css/style.css">
</head>
<body>
    <div class="auth-container">
        <h1 class="auth-logo">Sociolla</h1>
        
        <div class="auth-card">
            @if (session('success'))
                <div style="color: #155724; background-color: #d4edda; border: 1px solid #c3e6cb; margin-bottom: 15px; padding: 10px; font-size: 0.8rem; text-align:center; border-radius: 4px;">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div style="color: red; margin-bottom: 15px; font-size: 0.8rem; text-align:center;">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            @yield('content')
        </div>
    </div>
</body>
</html>
