<?php
session_start();
$message = "";

// Database connection
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"]);
    $password = $_POST["password"];
    $confirm  = $_POST["confirm"];
    $role     = $_POST["role"];

    if (empty($username) || empty($password) || empty($confirm)) {
        $message = "<div class='alert alert-danger text-center'>All fields are required.</div>";
    } elseif ($password !== $confirm) {
        $message = "<div class='alert alert-danger text-center'>Passwords do not match.</div>";
    } elseif (strlen($password) < 6) {
        $message = "<div class='alert alert-warning text-center'>Password must be at least 6 characters.</div>";
    } else {

        $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $check->bind_param("s", $username);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $message = "<div class='alert alert-danger text-center'>Username already exists.</div>";
        } else {

            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare(
                "INSERT INTO users (username, password, role) VALUES (?, ?, ?)"
            );
            $stmt->bind_param("sss", $username, $hashed, $role);

            if ($stmt->execute()) {
                $message = "<div class='alert alert-success text-center'>
                                Registration successful! 
                                <a href='login.php' class='fw-bold text-decoration-none'>Login here</a>
                            </div>";
            } else {
                $message = "<div class='alert alert-danger text-center'>Registration failed.</div>";
            }
            $stmt->close();
        }
        $check->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - CHMSU Lost & Found</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .register-card {
            width: 100%;
            max-width: 420px;
            border-radius: 20px;
            backdrop-filter: blur(15px);
            background: rgba(255, 255, 255, 0.92);
            box-shadow: 0 15px 35px rgba(0,0,0,0.25);
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
</head>
<body>

<div class="register-card">

    <div class="text-center mb-4">
        <h3 class="brand-title">CHMSU Lost & Found</h3>
        <p class="text-muted">Create your account</p>
    </div>

    <?= $message ?>

    <form method="POST">

        <div class="mb-3">
            <label class="form-label">Username</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" name="username" class="form-control" placeholder="Enter username" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
                <span class="input-group-text toggle-password" onclick="togglePassword('password','eye1')">
                    <i class="bi bi-eye" id="eye1"></i>
                </span>
            </div>
            <small class="text-muted">Minimum 6 characters</small>
        </div>

        <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                <input type="password" name="confirm" id="confirm" class="form-control" placeholder="Confirm password" required>
                <span class="input-group-text toggle-password" onclick="togglePassword('confirm','eye2')">
                    <i class="bi bi-eye" id="eye2"></i>
                </span>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Account Role</label>
            <select name="role" class="form-select" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Register</button>
        </div>

    </form>

    <div class="text-center mt-3">
        <small>
            Already have an account?
            <a href="login.php" class="fw-semibold text-decoration-none">
                Login here
            </a>
        </small>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
function togglePassword(fieldId, iconId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(iconId);

    if (field.type === "password") {
        field.type = "text";
        icon.classList.remove("bi-eye");
        icon.classList.add("bi-eye-slash");
    } else {
        field.type = "password";
        icon.classList.remove("bi-eye-slash");
        icon.classList.add("bi-eye");
    }
}
</script>

</body>
</html>