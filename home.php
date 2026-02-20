<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Lost & Found</title>

<style>
/* ===== RESET ===== */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: 'Segoe UI', sans-serif;
}

/* Hide scrollbar */
body {
    background: #020617;
    color: white;
    overflow-x: hidden;
    scrollbar-width: none; /* Firefox */
}
body::-webkit-scrollbar {
    display: none; /* Chrome, Safari */
}

/* ===== NAVBAR ===== */
.navbar {
    position: fixed;
    top: 0;
    width: 100%;
    height: 60px;
    background: rgba(15,23,42,0.95);
    backdrop-filter: blur(12px);
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 40px;
    border-bottom: 1px solid #1e293b;
    z-index: 1000;
}

.logo {
    font-size: 20px;
    font-weight: 700;
    letter-spacing: 1px;
    color: #3b82f6;
}

.nav-links {
    display: flex;
    align-items: center;
    gap: 20px;
}

.nav-links a {
    color: #94a3b8;
    text-decoration: none;
    font-weight: 500;
    font-size: 14px;
    transition: 0.3s;
    position: relative;
}

.nav-links a:hover {
    color: white;
}

.nav-links a::after {
    content: '';
    position: absolute;
    bottom: -4px;
    left: 0;
    width: 0%;
    height: 2px;
    background: #3b82f6;
    transition: 0.3s;
}

.nav-links a:hover::after {
    width: 100%;
}

/* profile circle */
.profile {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #334155;
}

/* logout button */
.logout {
    background: #ef4444;
    padding: 6px 14px;
    border-radius: 8px;
    color: white !important;
    font-size: 13px;
    transition: 0.3s;
}
.logout:hover {
    background: #dc2626;
}

/* ===== HERO SECTION ===== */
.hero {
    height: calc(100vh - 60px);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    padding: 15px;
    margin-top: 60px;
}

.hero h1 {
    font-size: 36px;
    line-height: 1.3;
    margin-bottom: 15px;
    font-weight: 700;
}

.hero span {
    color: #3b82f6;
}

.hero p {
    color: #94a3b8;
    max-width: 600px;
    font-size: 15px;
    line-height: 1.6;
    margin-bottom: 30px;
}

/* buttons */
.buttons {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
    justify-content: center;
}

.btn {
    padding: 12px 28px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 500;
    font-size: 14px;
    border: 1px solid #334155;
    background: #1e293b;
    color: white;
    transition: 0.3s;
}

.btn:hover {
    background: #3b82f6;
    transform: translateY(-1px);
    box-shadow: 0 6px 15px rgba(59,130,246,0.3);
}

.btn.secondary {
    background: transparent;
    border: 1px solid #3b82f6;
}

.btn.secondary:hover {
    background: #3b82f6;
    color: white;
}

/* RESPONSIVE */
@media screen and (max-width: 768px) {
    .hero h1 {
        font-size: 28px;
    }
    .hero p {
        font-size: 14px;
    }
    .nav-links {
        gap: 12px;
    }
    .navbar {
        padding: 0 15px;
    }
}
</style>
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
    <div class="logo">Lost & Found</div>

    <div class="nav-links">
        <a href="home.php">Home</a>
        <a href="userdash.php?search_category=lost">Lost Items</a>
        <a href="userdash.php?search_category=found">Found Items</a>
        <div class="profile"></div>
        <a class="logout" href="logout.php">Logout</a>
    </div>
</div>

<!-- HERO -->
<div class="hero">
    <h1>Reconnect People With <span>Their Belongings</span></h1>
    <p>
        Quickly report, search, and recover lost items with our system. Making it
        easier for everyone to find what matters most.
    </p>

    <div class="buttons">
        <a class="btn" href="userdash.php?search_category=lost">Browse Lost Items</a>
        <a class="btn secondary" href="userdash.php?search_category=found">Browse Found Items</a>
    </div>
</div>

</body>
</html>
