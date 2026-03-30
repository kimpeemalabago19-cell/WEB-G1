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

            /* Admin Design Variables */
            --primary-gradient: linear-gradient(135deg, #2563eb, #1e40af);
            --success: #16a34a;
            --danger: #dc2626;
            --warning: #b45309;
            --icon-size: 1.3em;
            --icon-size-sm: 1.1em;
            --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --icon-glow: 0 0 0 0.2rem rgba(37, 99, 235, 0.3);
        }
        
* { 
            box-sizing: border-box; 
            margin: 0; 
            padding: 0; 
        }

        /* ICON GLOBAL STYLES FROM ADMIN */
        .admin-icon {
            font-size: var(--icon-size);
            width: 1.4em;
            height: 1.4em;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition-smooth);
            flex-shrink: 0;
        }

        .admin-icon:hover,
        .admin-icon:focus {
            transform: scale(1.1);
            filter: drop-shadow(0 2px 8px rgba(37, 99, 235, 0.4));
        }

        .admin-icon-sm {
            font-size: var(--icon-size-sm) !important;
        }

        /* ADMIN SIDEBAR LINK STYLES */
        .sidebar a,
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
            color: rgba(255,255,255,0.9);
            text-decoration: none;
            border-radius: 12px;
            margin-bottom: 8px;
            font-weight: 500;
            transition: var(--transition-smooth);
            position: relative;
            overflow: hidden;
            width: 100%;
            box-sizing: border-box;
        }
        
        .sidebar a:hover,
        .sidebar a.active,
        .sidebar-link:hover {
            background: var(--primary-gradient);
            color: white !important;
            transform: translateX(3px);
            box-shadow: 0 4px 20px rgba(37, 99, 235, 0.4);
        }

        .sidebar a::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .sidebar a:hover::before {
            left: 100%;
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
            width: 260px;
            height: 100vh;
            background: #0f172a;
            padding: 30px 20px;
            color: white;
            z-index: 100;
            top: 0;
            left: 0;
            box-shadow: 4px 0 20px rgba(0,0,0,0.1);
            overflow-y: auto;
            box-sizing: border-box;
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
            margin-left: 260px;
            padding: 35px;
            min-height: 100vh;
            box-sizing: border-box;
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
            .sidebar a span,
            .sidebar-link span,
            .sidebar-heading,
            .sidebar-logout span {
                display: none;
            }
            .sidebar a,
            .sidebar-link {
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

    <!-- SIDEBAR - Admin Design -->
    <div class="sidebar">
    <h4>User Panel</h4>
    
    <a href="{{ route('home') }}" class="{{ Request::routeIs('home') ? 'active' : '' }}">
        <i class="bi bi-house admin-icon"></i> Home
    </a>
    
    <a href="{{ route('user.dashboard') }}" class="{{ Request::routeIs('user.dashboard') ? 'active' : '' }}">
        <i class="bi bi-grid-1x2 admin-icon"></i> Dashboard
    </a>

    <!-- Claim page link -->
    <a href="{{ route('user.claim.get') }}" class="{{ Request::routeIs('user.claim.get') ? 'active' : '' }}">
        <i class="bi bi-hand-thumbs-up admin-icon"></i> Claim
    </a>
    
    <hr style="border-color: rgba(255,255,255,0.2); margin: 25px 0;">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="sidebar-link text-danger" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer;">
            <i class="bi bi-box-arrow-right admin-icon"></i> Logout
        </button>
    </form>
</div>

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
