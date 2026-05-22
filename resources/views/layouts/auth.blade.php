<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CHMSU Lost & Found Management System')</title>
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

        /* Animated Gradient Button for Back to Home */
        .btn-animated-gradient {
            background: linear-gradient(90deg, #1e3a8a, #845ec2, #2563eb);
            background-size: 200% 100%;
            color: #fff !important;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            transition: background-position 0.5s, box-shadow 0.3s, color 0.3s;
            box-shadow: 0 2px 12px 0 rgba(36, 54, 120, 0.12);
            position: relative;
            z-index: 1;
        }
        .btn-animated-gradient:hover, .btn-animated-gradient:focus {
            background-position: 100% 50%;
            color: #fff !important;
            box-shadow: 0 4px 18px 0 rgba(36, 54, 120, 0.18);
            animation: animated-gradient-auth 0.7s linear forwards;
        }
        @keyframes animated-gradient-auth {
            0% {
                background-position: 0% 50%;
            }
            100% {
                background-position: 100% 50%;
            }
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

