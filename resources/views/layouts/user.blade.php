<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CHMSU Lost & Found')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        :root {
            /* Clean & Unique Color Palette */
            --bg-cream: #faf9f6;
            --bg-white: #ffffff;
            --bg-light-gray: #f5f5f3;
            --bg-soft-lavender: #f0eeff;
            
            /* Accent Colors - Vibrant & Unique */
            --accent-coral: #ff6b6b;
            --accent-mint: #4ecdc4;
            --accent-violet: #845ec2;
            --accent-gold: #ffd93d;
            --accent-sky: #6bcbff;
            
            /* Text Colors */
            --text-dark: #1a1a2e;
            --text-gray: #6b7280;
            --text-light: #9ca3af;
            
            /* Glassmorphism */
            --glass-bg: rgba(255, 255, 255, 0.7);
            --glass-bg-hover: rgba(255, 255, 255, 0.9);
            --glass-border: rgba(255, 255, 255, 0.5);
            --glass-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            
            /* Status Colors */
            --status-claimed: #845ec2;
            --status-processing: #ff6b6b;
            --status-lost: #ffd93d;
            --status-found: #4ecdc4;
        }
        
        * { 
            box-sizing: border-box; 
            margin: 0; 
            padding: 0; 
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, var(--bg-cream) 0%, var(--bg-white) 50%, var(--bg-soft-lavender) 100%);
            color: var(--text-dark);
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        /* Animated Background Pattern */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 10% 20%, rgba(132, 94, 194, 0.08) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(78, 205, 196, 0.08) 0%, transparent 40%),
                radial-gradient(circle at 50% 50%, rgba(255, 107, 107, 0.05) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }
        
        /* HEADER - Blue Gradient from Homepage */
        .header-strip {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 70px;
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(96, 165, 250, 0.2);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 35px;
            z-index: 1000;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.3);
        }
        
        .header-brand {
            color: #ffffff;
            font-size: 23px;
            font-weight: 700;
            letter-spacing: -0.5px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s ease;
        }
        
        .header-brand:hover {
            transform: translateX(5px);
        }
        
        .header-brand i {
            color: #60a5fa;
            font-size: 26px;
            filter: drop-shadow(0 0 8px rgba(96, 165, 250, 0.5));
        }
        
        .header-brand span {
            color: #ffffff;
        }
        
        .header-nav {
            display: flex;
            align-items: center;
            gap: 25px;
        }
        
        .header-nav a {
            color: var(--text-gray);
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            padding: 8px 16px;
            border-radius: 8px;
        }
        
        .header-nav a:hover {
            color: var(--accent-violet);
            background: var(--bg-soft-lavender);
        }
        
        .btn-logout {
            background: linear-gradient(135deg, var(--accent-coral) 0%, #ff5252 100%);
            padding: 10px 20px;
            border-radius: 12px;
            color: white;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
        }
        
        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 107, 107, 0.4);
            color: white;
        }
        
        /* SIDEBAR - Clean Glassmorphism */
        .sidebar {
            position: fixed;
            top: 70px;
            left: 0;
            width: 280px;
            height: calc(100vh - 70px);
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            padding: 30px 20px;
            border-right: 1px solid rgba(132, 94, 194, 0.08);
            z-index: 900;
            overflow-y: auto;
            box-shadow: 4px 0 30px rgba(132, 94, 194, 0.05);
        }
        
        .sidebar-nav {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .sidebar-nav li {
            margin-bottom: 8px;
        }
        
        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 18px;
            color: var(--text-gray);
            text-decoration: none;
            border-radius: 14px;
            font-size: 15px;
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .sidebar-nav a::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 0;
            background: var(--accent-violet);
            border-radius: 0 4px 4px 0;
            transition: all 0.3s ease;
        }
        
        .sidebar-nav a:hover {
            background: var(--bg-soft-lavender);
            color: var(--accent-violet);
            transform: translateX(5px);
        }
        
        .sidebar-nav a:hover::before {
            height: 60%;
        }
        
        .sidebar-nav a.active {
            background: linear-gradient(135deg, rgba(132, 94, 194, 0.15) 0%, rgba(132, 94, 194, 0.05) 100%);
            color: var(--accent-violet);
            font-weight: 600;
            border: 1px solid rgba(132, 94, 194, 0.2);
        }
        
        .sidebar-nav a.active::before {
            height: 60%;
        }
        
        .sidebar-nav a i {
            font-size: 20px;
            width: 24px;
            text-align: center;
        }
        
        .sidebar-logout {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 18px;
            color: var(--accent-coral);
            background: none;
            border: none;
            border-radius: 14px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s ease;
        }
        
        .sidebar-logout:hover {
            background: rgba(255, 107, 107, 0.1);
            transform: translateX(5px);
        }
        
        .sidebar-logout i {
            font-size: 20px;
            width: 24px;
            text-align: center;
        }
        
        .sidebar-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent 0%, rgba(132, 94, 194, 0.1) 50%, transparent 100%);
            margin: 25px 0;
        }
        
        .sidebar-heading {
            font-size: 11px;
            font-weight: 600;
            color: var(--text-light);
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 0 18px;
            margin-bottom: 12px;
        }
        
        /* MAIN CONTENT */
        .main-wrapper {
            margin-left: 280px;
            margin-top: 70px;
            min-height: calc(100vh - 70px);
            padding: 40px;
            position: relative;
            z-index: 1;
        }
        
        .main-container {
            max-width: 1600px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 28px;
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: var(--glass-shadow);
            padding: 45px;
            min-height: calc(100vh - 150px);
            animation: fadeInUp 0.6s ease-out;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(132, 94, 194, 0.05);
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, var(--accent-violet) 0%, var(--accent-coral) 100%);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, var(--accent-violet) 0%, #9b59b6 100%);
        }
        
        /* Responsive */
        @media (max-width: 1200px) {
            .sidebar {
                width: 80px;
                padding: 25px 12px;
            }
            .sidebar-nav a span,
            .sidebar-heading,
            .sidebar-logout span {
                display: none;
            }
            .sidebar-nav a {
                justify-content: center;
                padding: 14px;
            }
            .sidebar-logout {
                justify-content: center;
                padding: 14px;
            }
            .main-wrapper {
                margin-left: 80px;
            }
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
                transition: transform 0.3s ease;
            }
            .sidebar.active {
                transform: translateX(0);
            }
            .main-wrapper {
                margin-left: 0;
                padding: 20px;
            }
            .main-container {
                padding: 25px;
                border-radius: 16px;
            }
            .header-strip {
                padding: 0 20px;
            }
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- HEADER -->
    <header class="header-strip">
        <a href="{{ route('home') }}" class="header-brand">
            <i class="bi bi-search-heart"></i>
            <span>CHMSU Lost & Found</span>
        </a>
        
        <nav class="header-nav">
        </nav>
    </header>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <ul class="sidebar-nav">
            <li>
                <a href="{{ route('home') }}" class="{{ Request::routeIs('home') ? 'active' : '' }}">
                    <i class="bi bi-house"></i>
                    <span>Home</span>
                </a>
            </li>
            <li>
                <a href="{{ route('user.dashboard') }}" class="{{ Request::routeIs('user.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
        </ul>
        
        <div class="sidebar-divider"></div>
        
        <ul class="sidebar-nav">
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="sidebar-logout">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="main-wrapper">
        <main class="main-container">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
