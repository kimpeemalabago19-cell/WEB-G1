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
    background: #f8fafc;
    color: #1e293b;
    overflow-x: hidden;
    scrollbar-width: none;
}
body::-webkit-scrollbar {
    display: none;
}

/* ===== NAVBAR ===== */
.navbar{
    position: fixed;
    top: 0;
    width: 100%;
    height: 65px;
    background: #0f172a;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 50px;
    z-index: 1000;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
}

.logo {
    color: #3b82f6;
    font-size: 20px;
    font-weight: 700;
}

.nav-links{
    display: flex;
    gap: 20px;
    align-items: center;
}

.nav-links a{
    text-decoration: none;
    color: #cbd5e1;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.3s;
}

.nav-links a:hover{
    color: #38bdf8;
}

/* logout button */
.logout {
    background: #ef4444;
    padding: 6px 16px;
    border-radius: 8px;
    color: white !important;
    font-size: 13px;
    font-weight: 500;
    transition: 0.3s;
}
.logout:hover {
    background: #dc2626;
    transform: translateY(-2px);
}

/* ===== HERO SECTION ===== */
.hero {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    padding: 120px 20px 40px 20px; /* offset navbar */
    margin-bottom: 40px;
    background: linear-gradient(120deg, #e0f2fe, #f1f5f9);
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
}

.hero h1 {
    font-size: 38px;
    line-height: 1.3;
    margin-bottom: 15px;
    font-weight: 700;
    color: #1e293b;
}

.hero span {
    color: #3b82f6;
}

.hero p {
    color: #475569;
    max-width: 650px;
    font-size: 16px;
    line-height: 1.5;
}

/* ===== TUTORIAL SECTION ===== */
.tutorial-section {
    max-width: 950px;
    margin: -20px auto 60px auto; /* bring closer to hero */
    padding: 30px;
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    color: #1e293b;
    transition: transform 0.3s, box-shadow 0.3s;
}

.tutorial-section:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.12);
}

.tutorial-section h2 {
    font-size: 26px;
    font-weight: 700;
    margin-bottom: 20px;
    text-align: center;
    color: #3b82f6;
}

.tutorial-intro {
    text-align: center;
    margin-bottom: 25px;
    font-size: 15px;
    line-height: 1.6;
    color: #64748b;
}

.steps {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.step {
    display: flex;
    align-items: flex-start;
    gap: 15px;
    background: #f1f5f9;
    padding: 15px 18px;
    border-radius: 12px;
    transition: transform 0.3s, background 0.3s;
}

.step:hover {
    transform: translateY(-3px);
    background: #e0f2fe;
}

.step-number {
    min-width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #3b82f6;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 16px;
    flex-shrink: 0;
    margin-top: 0;
}

.step p {
    font-size: 15px;
    line-height: 1.5;
    margin: 0;
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
    .tutorial-section {
        margin: -10px 15px 30px 15px;
        padding: 20px;
    }
    .step {
        gap: 10px;
        padding: 12px 15px;
    }
    .step-number {
        min-width: 32px;
        height: 32px;
        font-size: 14px;
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
        <a href="userdash.php?search_category=claimed">Claimed Items</a>
        <a class="logout" href="logout.php">Logout</a>
    </div>
</div>

<div class="spacer"></div>

<!-- HERO -->
<div class="hero">
    <h1>Reconnect People With <span>Their Belongings</span></h1>
    <p>
        Quickly report, search, and recover lost items with our system. Making it
        easier for everyone to find what matters most.
    </p>
</div>

<!-- TUTORIAL SECTION -->
<div class="tutorial-section">
    <h2>How to Claim Your Belongings</h2>
    <div class="tutorial-intro">
        All items reported in the system are already available at 
        <strong>OSAS (CHMSU CLAIMING STATION)</strong>. Follow the steps below to safely claim your lost items. 
        You can also contact us for assistance:
        <br>
        Message us at <strong>Carlos Hilado Memorial State University</strong>, 
        email <strong>cier@chmsu.edu.ph</strong>, or call <strong>(034) 454 0529</strong>.
    </div>

    <div class="steps">
        <div class="step">
            <div class="step-number">1</div>
            <p>Go to the <strong>Lost Items</strong> section in your dashboard to search for your missing belongings.</p>
        </div>

        <div class="step">
            <div class="step-number">2</div>
            <p>Click on the item card to view detailed information, including the finder’s contact details.</p>
        </div>

        <div class="step">
            <div class="step-number">3</div>
            <p>Once you locate your item, click the <strong>Claim</strong> button under the card. A small confirmation modal will appear asking you to verify that you are claiming the item.</p>
        </div>

        <div class="step">
            <div class="step-number">4</div>
            <p>Confirm the claim by submitting the form in the modal. After submission, the item will automatically move to the <strong>Claimed Items</strong> section and be marked with your name as the claimer.</p>
        </div>

        <div class="step">
            <div class="step-number">5</div>
            <p>Proceed to <strong>OSAS (CHMSU CLAIMING STATION)</strong> to physically collect your item. Use the provided contact info if you need further assistance.</p>
        </div>
    </div>
</div>

<!-- FOOTER -->
<footer style="background:#0f172a; color:#cbd5e1; padding:40px 20px; margin-top:50px;">
    <div style="max-width:1200px; margin:auto; display:flex; flex-wrap:wrap; justify-content:space-between; gap:20px;">
        
        <!-- About / Logo -->
        <div style="flex:1; min-width:200px;">
            <h3 style="color:#3b82f6; margin-bottom:15px;">Lost & Found</h3>
            <p style="font-size:14px; line-height:1.5;">
                Quickly report, search, and recover lost items in our system. Helping everyone reconnect with their belongings.
            </p>
        </div>

        <!-- Quick Links -->
        <div style="flex:1; min-width:150px;">
            <h4 style="color:#3b82f6; margin-bottom:10px;">Quick Links</h4>
            <ul style="list-style:none; padding:0; font-size:14px; line-height:2;">
                <li><a href="home.php" style="color:#cbd5e1; text-decoration:none;">Home</a></li>
                <li><a href="userdash.php?search_category=lost" style="color:#cbd5e1; text-decoration:none;">Lost Items</a></li>
                <li><a href="userdash.php?search_category=found" style="color:#cbd5e1; text-decoration:none;">Found Items</a></li>
                <li><a href="userdash.php?search_category=claimed" style="color:#cbd5e1; text-decoration:none;">Claimed Items</a></li>
            </ul>
        </div>

        <!-- Contact Info -->
        <div style="flex:1; min-width:200px;">
            <h4 style="color:#3b82f6; margin-bottom:10px;">Contact Us</h4>
            <p style="font-size:14px; line-height:1.5;">
                FaceBook: Carlos Hilado Memorial State University<br>
                Email: <a href="mailto:cier@chmsu.edu.ph" style="color:#cbd5e1;">cier@chmsu.edu.ph</a><br>
                Phone: <strong>(034) 454 0529</strong>
            </p>
        </div>

    </div>

    <div style="text-align:center; margin-top:30px; font-size:13px; color:#64748b;">
        &copy; <?= date('Y') ?> Lost & Found System. All rights reserved.
    </div>
</footer>



</body>
</html>