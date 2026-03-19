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
            --glass-bg: rgba(255, 255, 255, 0.9);
            --glass-bg-hover: rgba(255, 255, 255, 1);
            --glass-border: rgba(255, 255, 255, 0.8);
            --glass-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
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
        
        /* HEADER for Public - Simplified, no logout */
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
        
        .header-auth {
            display: flex;
            gap: 15px;
        }
        
        .header-auth a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .header-auth a:hover {
            color: white;
            background: rgba(255,255,255,0.1);
        }
        
        /* MAIN CONTENT Full Width for Public */
        .main-wrapper {
            margin-top: 70px;
            padding: 40px 20px;
            position: relative;
            z-index: 1;
        }
        
        .main-container {
            max-width: 1400px;
            margin: 0 auto;
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 28px;
            border: 1px solid var(--glass-border);
            box-shadow: var(--glass-shadow);
            padding: 60px 45px;
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
        
        /* Scrollbar */
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
        
        @media (max-width: 768px) {
            .main-wrapper {
                padding: 20px 15px;
            }
            .main-container {
                padding: 40px 25px;
                border-radius: 20px;
            }
            .header-strip {
                padding: 0 20px;
            }
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- HEADER Public -->
    <header class="header-strip">
        <a href="/" class="header-brand">
            <i class="bi bi-search-heart"></i>
            <span>CHMSU Lost & Found</span>
        </a>
        
        <div class="header-auth">
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Register</a>
        </div>
    </header>

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
