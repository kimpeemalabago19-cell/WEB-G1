<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CHMSU Lost & Found - Admin')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background: #f4f6f9;
            font-family: 'Segoe UI', sans-serif;
        }
        
        /* SIDEBAR */
        .sidebar {
            position: fixed;
            width: 240px;
            height: 100vh;
            background: #0f172a;
            padding: 25px;
            color: white;
            z-index: 100;
            top: 0;
            left: 0;
        }
        
        .sidebar h4 {
            font-weight: 600;
            margin-bottom: 30px;
        }
        
        .sidebar a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 15px;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 10px;
            transition: 0.25s;
        }
        
        .sidebar a:hover,
        .sidebar a.active,
        .sidebar-link:hover {
            background: #2563eb;
            transform: translateX(4px);
        }
        
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 15px;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 10px;
            transition: 0.25s;
        }
        
        /* MAIN */
        .main-content {
            margin-left: 240px;
            padding: 30px;
            min-height: 100vh;
        }
        
        /* HEADER */
        .header {
            background: linear-gradient(135deg, #2563eb, #1e40af);
            color: white;
            padding: 18px 30px;
            border-radius: 10px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        /* CARD */
        .card {
            border: none;
            border-radius: 12px;
        }
        
        .card-header {
            font-weight: 600;
            font-size: 16px;
        }
        
        .form-control,
        .form-select {
            padding: 10px;
        }
        
        .form-control:focus,
        .form-select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 0.15rem rgba(37, 99, 235, 0.25);
        }
        
        .btn-primary {
            background: #2563eb;
            border: none;
        }
        
        .btn-primary:hover {
            background: #1e40af;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }
            .main-content {
                margin-left: 200px;
                padding: 15px;
            }
        }
    </style>
    @yield('styles')
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h4>Admin Panel</h4>
    
    <a href="{{ route('admin.dashboard') }}" class="{{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="bi bi-plus-circle"></i> Add Item
    </a>
    
    <a href="{{ route('admin.reported') }}" class="{{ Request::routeIs('admin.reported') ? 'active' : '' }}">
        <i class="bi bi-list-check"></i> Reported Items
    </a>
    
    <a href="{{ route('admin.found') }}" class="{{ Request::routeIs('admin.found') ? 'active' : '' }}">
        <i class="bi bi-search"></i> Found Items
    </a>
    
    <hr style="border-color: rgba(255,255,255,0.2); margin: 20px 0;">
    
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="sidebar-link text-danger" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer;">
            <i class="bi bi-box-arrow-right"></i> Logout
        </button>
    </form>
</div>

<!-- MAIN CONTENT -->
<div class="main-content">
    <div class="header">
        <h5>
            <i class="bi bi-box-seam"></i>
            CHMSU Lost & Found Management System
        </h5>
        <span>
            <i class="bi bi-person-circle"></i> Admin
        </span>
    </div>
    
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>

