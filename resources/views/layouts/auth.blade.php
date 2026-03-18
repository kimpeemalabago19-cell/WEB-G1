<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CHMSU Lost & Found')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .auth-card {
            width: 100%;
            max-width: 420px;
            border-radius: 20px;
            backdrop-filter: blur(15px);
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            padding: 35px;
        }
        .form-control, .form-select {
            border-radius: 10px;
        }
        .btn-primary {
            border-radius: 10px;
            padding: 10px;
            font-weight: 600;
        }
        .brand-title {
            font-weight: 700;
            color: #1e3a8a;
        }
        .toggle-password {
            cursor: pointer;
        }
    </style>
    @yield('styles')
</head>
<body>
    @yield('content')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>

