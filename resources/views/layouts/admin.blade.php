<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CHMSU Lost & Found - Admin')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #2563eb, #1e40af);
            --success: #16a34a;
            --danger: #dc2626;
            --warning: #b45309;
            --icon-size: 1.3em;
            --icon-size-sm: 1.1em;
            --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --icon-glow: 0 0 0 0.2rem rgba(37, 99, 235, 0.3);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background: #f4f6f9;
            font-family: 'Segoe UI', sans-serif;
        }
        
        /* ICON GLOBAL STYLES */
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

        /* SIDEBAR */
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
        }
        
        .sidebar h4 {
            font-weight: 600;
            margin-bottom: 35px;
            font-size: 1.4em;
        }
        
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
            color: white;
            transform: translateX(6px);
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
        
        /* MAIN */
        .main-content {
            margin-left: 260px;
            padding: 35px;
            min-height: 100vh;
        }
        
        /* HEADER */
        .header {
            background: var(--primary-gradient);
            color: white;
            padding: 22px 35px;
            border-radius: 16px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 8px 32px rgba(37, 99, 235, 0.3);
            animation: headerSlide 0.6s ease-out;
        }

        @keyframes headerSlide {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        
        .header h5 .admin-icon {
            animation: iconPulse 2s infinite;
        }

        @keyframes iconPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.15); }
        }

        /* CARD */
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.08);
        }
        
        .card-header {
            font-weight: 600;
            font-size: 1.1em;
            background: var(--primary-gradient);
            color: white;
            border-radius: 12px 12px 0 0 !important;
        }

        .form-control,
        .form-select {
            padding: 12px 16px;
            border-radius: 12px;
            border: 2px solid #e5e7eb;
            transition: var(--transition-smooth);
        }
        
        .form-control:focus,
        .form-select:focus {
            border-color: #2563eb;
            box-shadow: var(--icon-glow);
            transform: translateY(-1px);
        }
        
        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 500;
            transition: var(--transition-smooth);
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.4);
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255,255,255,0.3);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-primary:active::before {
            width: 300px;
            height: 300px;
        }

        /* ACTION BUTTONS */
        .action-icon-btn {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition-smooth);
            cursor: pointer;
            font-size: 1.1em;
            position: relative;
            overflow: hidden;
        }

        .action-icon-btn:hover {
            transform: scale(1.15) rotate(5deg);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        }

        .btn-edit { background: var(--success); color: white; }
        .btn-edit:hover { background: #15803d; }

        .btn-delete { background: var(--danger); color: white; }
        .btn-delete:hover { background: #b91c1c; }

        /* STATUS */
        .status-badge {
            padding: 8px 16px;
            border-radius: 25px;
            font-size: 0.85em;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        @media (max-width: 768px) {
            .sidebar { width: 220px; padding: 20px 15px; }
            .main-content { margin-left: 220px; padding: 20px; }
            .admin-icon { font-size: 1.2em !important; }
        }
    </style>
    @yield('styles')
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h4>Admin Panel</h4>
    
    <a href="{{ route('admin.dashboard') }}" class="{{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="bi bi-plus-circle admin-icon"></i> Add Item
    </a>
    
    <a href="{{ route('admin.reported') }}" class="{{ Request::routeIs('admin.reported') ? 'active' : '' }}">
        <i class="bi bi-list-check admin-icon"></i> Reported Items
    </a>
    
    <a href="{{ route('admin.found') }}" class="{{ Request::routeIs('admin.found') ? 'active' : '' }}">
        <i class="bi bi-search admin-icon"></i> Found Items
    </a>
    
    <a href="{{ route('admin.lost') }}" class="{{ Request::routeIs('admin.lost') ? 'active' : '' }}">
        <i class="bi bi-x-circle admin-icon"></i> Lost Items
    </a>
    
    <a href="{{ route('admin.claim') }}" class="{{ Request::routeIs('admin.claim') ? 'active' : '' }}">
        <i class="bi bi-check-circle admin-icon"></i> Claim Items
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
<div class="main-content">
    <div class="header">
        <h5>
            <i class="bi bi-box-seam admin-icon"></i>
            CHMSU Lost &amp; Found Management System
        </h5>
        <span>
            <i class="bi bi-person-circle admin-icon-sm"></i> Admin
        </span>
    </div>
    
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
