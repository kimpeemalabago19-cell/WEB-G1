<?php
session_start();
$message = "";

// Database connection
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"]);
    $password = $_POST["password"];
    $confirm  = $_POST["confirm"];
    $role     = $_POST["role"]; // user or admin

    // Validation
    if (empty($username) || empty($password) || empty($confirm)) {
        $message = "All fields are required.";
    } elseif ($password !== $confirm) {
        $message = "Passwords do not match.";
    } elseif (strlen($password) < 6) {
        $message = "Password must be at least 6 characters.";
    } else {

        // Check if username exists
        $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $check->bind_param("s", $username);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $message = "Username already exists.";
        } else {

            // Insert new user/admin
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare(
                "INSERT INTO users (username, password, role) VALUES (?, ?, ?)"
            );
            $stmt->bind_param("sss", $username, $hashed, $role);

            if ($stmt->execute()) {
                $message = "Registration successful! <a href='login.php'>Login here</a>";
            } else {
                $message = "Registration failed.";
            }
            $stmt->close();
        }
        $check->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - Lost & Found</title>
    <style>
        body {
            background:#1e293b;
            display:flex;
            height:100vh;
            justify-content:center;
            align-items:center;
            font-family:Arial, sans-serif;
        }
        .box {
            background:#fff;
            padding:25px;
            width:360px;
            border-radius:10px;
            box-shadow:0 0 10px rgba(0,0,0,0.3);
        }
        input, select, button {
            width:100%;
            padding:10px;
            margin:8px 0;
            border-radius:5px;
            border:1px solid #ccc;
        }
        button {
            background:#2563eb;
            color:#fff;
            border:none;
            cursor:pointer;
        }
        button:hover {
            background:#1e40af;
        }
        .error { color:red; text-align:center; }
        .success { color:green; text-align:center; }
        a { color:#2563eb; text-decoration:none; }
    </style>
</head>
<body>

<div class="box">
    <h2 style="text-align:center;">Register</h2>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>

        <input type="password" name="password" placeholder="Password" required>

        <input type="password" name="confirm" placeholder="Confirm Password" required>

        <select name="role" required>
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>

        <button type="submit">Register</button>
    </form>

    <?php if ($message): ?>
        <p class="<?= strpos($message, 'successful') !== false ? 'success' : 'error' ?>">
            <?= $message ?>
        </p>
    <?php endif; ?>

    <p style="text-align:center;">
        Already have an account? <a href="login.php">Login</a>
    </p>
</div>

</body>
</html>
