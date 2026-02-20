<?php
session_start();
$error = "";

// Include database connection
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Trim and validate inputs
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    if (empty($username) || empty($password)) {
        $error = "Please enter both username and password.";
    } else {

        // 🔹 UPDATED: include role in query
        $stmt = $conn->prepare(
            "SELECT id, username, password, role FROM users WHERE username = ?"
        );

        if ($stmt) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();

                // Verify password
                if (password_verify($password, $user["password"])) {

                    // 🔹 Store user info in session
                    $_SESSION["user_id"] = $user["id"];
                    $_SESSION["username"] = $user["username"];
                    $_SESSION["role"] = $user["role"];

                    // 🔹 Redirect based on role
                    if ($user["role"] === "admin") {
                        header("Location: admindash.php");
                    } else {
                        header("Location: userdash.php");
                    }
                    exit;

                } else {
                    $error = "Invalid username or password.";
                }
            } else {
                $error = "Invalid username or password.";
            }

            $stmt->close();
        } else {
            $error = "Database query failed.";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Lost & Found</title>
    <style>
        body {
            background: #1e293b;
            display: flex;
            height: 100vh;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
        }
        .box {
            background: #fff;
            padding: 25px;
            width: 350px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            background: #2563eb;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background: #1e40af;
        }
        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
        a {
            color: #2563eb;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="box">
    <h2 style="text-align:center;">Login</h2>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <p style="text-align:center">
        No account? <a href="register.php">Register</a>
    </p>
</div>

</body>
</html>
