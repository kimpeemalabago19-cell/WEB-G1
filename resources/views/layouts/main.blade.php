<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CHMSU Lost & Found</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', sans-serif; }
        body { background: #f8fafc; color: #1e293b; overflow-x: hidden; }
        
        .navbar-custom {
            position: fixed;
            top: 0;
            width: 100%;
            height: 65px;
            background: #0f172a;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 50px;
            z-index: 1000;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }
        
        .logo { color: #3b82f6; font-size: 20px; font-weight: 700; }
        
        .nav-links { display: flex; gap: 20px; align-items: center; }
        .nav-links a { text-decoration: none; color: #cbd5e1; font-size: 14px; font-weight: 500; transition: all 0.3s; }
        .nav-links a:hover { color: #38bdf8; }
        
        .logout-btn {
            background: #ef4444;
            padding: 6px 16px;
            border-radius: 8px;
            color: white !important;
            font-size: 13px;
            font-weight: 500;
            transition: 0.3s;
            border: none;
            cursor: pointer;
        }
        .logout-btn:hover { background: #dc2626; transform: translateY(-2px); }
        
        .main-content { padding-top: 80px; padding-bottom: 40px; min-height: 100vh; }
        
        .hero {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 60px 20px 40px 20px;
            margin-bottom: 40px;
            background: linear-gradient(120deg, #e0f2fe, #f1f5f9);
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        }
        
        .hero h1 { font-size: 38px; line-height: 1.3; margin-bottom: 15px; font-weight: 700; color: #1e293b; }
        .hero span { color: #3b82f6; }
        .hero p { color: #475569; max-width: 650px; font-size: 16px; line-height: 1.5; }
        
        .tutorial-section {
            max-width: 950px;
            margin: -20px auto 60px auto;
            padding: 30px;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            color: #1e293b;
        }
        
        .tutorial-section h2 { font-size: 26px; font-weight: 700; margin-bottom: 20px; text-align: center; color: #3b82f6; }
        .tutorial-intro { text-align: center; margin-bottom: 25px; font-size: 15px; line-height: 1.6; color: #64748b; }
        
        .step { display: flex; align-items: flex-start; gap: 15px; background: #f1f5f9; padding: 15px 18px; border-radius: 12px; margin-bottom: 15px; }
        .step-number { min-width: 36px; height: 36px; border-radius: 50%; background: #3b82f6; color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 16px; }
        .step p { font-size: 15px; line-height: 1.5; margin: 0; }
        
        footer { background: #0f172a; color: #cbd5e1; padding: 40px 20px; margin-top: 50px; }
        
        @media screen and (max-width: 768px) {
            .hero h1 { font-size: 28px; }
            .navbar-custom { padding: 0 15px; }
            .nav-links { gap: 12px; }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar-custom">
        <div class="logo"><i class="bi bi-search"></i> CHMSU Lost & Found</div>
        <div class="nav-links">
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('items.index', ['category' => 'lost']) }}">Lost Items</a>
            <a href="{{ route('items.index', ['category' => 'found']) }}">Found Items</a>
            <a href="{{ route('items.index', ['category' => 'claimed']) }}">Claimed Items</a>
            @auth
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.items') }}" style="color: #fbbf24;"><i class="bi bi-speedometer2"></i> Admin</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            @endauth
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer>
        <div style="max-width:1200px; margin:auto; display:flex; flex-wrap:wrap; justify-content:space-between; gap:20px;">
            <div style="flex:1; min-width:200px;">
                <h3 style="color:#3b82f6; margin-bottom:15px;">Lost & Found</h3>
                <p style="font-size:14px; line-height:1.5;">
                    Quickly report, search, and recover lost items in our system. Helping everyone reconnect with their belongings.
                </p>
            </div>
            <div style="flex:1; min-width:150px;">
                <h4 style="color:#3b82f6; margin-bottom:10px;">Quick Links</h4>
                <ul style="list-style:none; padding:0; font-size:14px; line-height:2;">
                    <li><a href="{{ route('home') }}" style="color:#cbd5e1; text-decoration:none;">Home</a></li>
                    <li><a href="{{ route('items.index', ['category' => 'lost']) }}" style="color:#cbd5e1; text-decoration:none;">Lost Items</a></li>
                    <li><a href="{{ route('items.index', ['category' => 'found']) }}" style="color:#cbd5e1; text-decoration:none;">Found Items</a></li>
                    <li><a href="{{ route('items.index', ['category' => 'claimed']) }}" style="color:#cbd5e1; text-decoration:none;">Claimed Items</a></li>
                </ul>
            </div>
            <div style="flex:1; min-width:200px;">
                <h4 style="color:#3b82f6; margin-bottom:10px;">Contact Us</h4>
                <p style="font-size:14px; line-height:1.5;">
                    FaceBook: Carlos Hilado Memorial State University<br>
                    Email: <a href="mailto:cier@chmsu.edu.ph" style="color:#cbd5e1;">cier@chmsu.edu.ph</a><br>
                    Phone: <strong>(034) 454 0529</strong>
                </p>
            </div>
        </div>
        <div style="text-align:center; margin-top:30px; font-size:13px; color:#64748b;">
            &copy; {{ date('Y') }} CHMSU Lost & Found System. All rights reserved.
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

