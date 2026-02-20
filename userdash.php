<?php
session_start();
include "config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$categoryFilter = $_GET['search_category'] ?? 'all';

/* Fetch items */
if($categoryFilter == "lost" || $categoryFilter == "found"){
    $stmt = $conn->prepare("SELECT * FROM items WHERE status=? ORDER BY id DESC");
    $stmt->bind_param("s",$categoryFilter);
    $stmt->execute();
    $result = $stmt->get_result();
}else{
    $result = $conn->query("SELECT * FROM items ORDER BY id DESC");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>User Dashboard</title>

<style>
*{box-sizing:border-box;margin:0;padding:0;font-family:Segoe UI}

body{
    background:#020617;
    color:white;
}

/* NAVBAR SAME AS HOME */
.navbar{
    position:fixed;
    top:0;
    width:100%;
    height:70px;
    background:rgba(15,23,42,0.95);
    backdrop-filter:blur(10px);
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:0 70px;
    border-bottom:1px solid #1e293b;
}

.logo{font-size:22px;font-weight:bold}

.nav-links{
    display:flex;
    gap:30px;
    align-items:center;
}

.nav-links a{
    color:#94a3b8;
    text-decoration:none;
    font-weight:500;
}
.nav-links a:hover{color:white}

.logout{
    background:#ef4444;
    padding:8px 16px;
    border-radius:8px;
    color:white !important;
}

.spacer{height:80px}

/* PAGE HEADER */
.page-title{
    text-align:center;
    font-size:36px;
    margin-top:20px;
}

/* FILTER BUTTONS */
.filters{
    text-align:center;
    margin:25px 0;
}
.filters a{
    text-decoration:none;
    padding:10px 20px;
    border:1px solid #334155;
    border-radius:8px;
    margin:5px;
    color:white;
}
.filters a:hover{background:#3b82f6}

/* ITEMS GRID */
.grid{
    width:90%;
    margin:auto;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:25px;
    padding-bottom:50px;
}

.card{
    background:#0f172a;
    border-radius:14px;
    overflow:hidden;
    border:1px solid #1e293b;
    transition:.3s;
}
.card:hover{transform:translateY(-5px)}

.card img{
    width:100%;
    height:200px;
    object-fit:cover;
}

.card-body{padding:15px}

.badge{
    padding:4px 10px;
    border-radius:6px;
    font-size:12px;
}
.lost{background:#ef4444}
.found{background:#22c55e}
</style>
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
    <div class="logo">Lost & Found</div>
    <div class="nav-links">
        <a href="home.php">Home</a>
        <a href="userdash.php?search_category=lost">Lost</a>
        <a href="userdash.php?search_category=found">Found</a>

        <?php if($_SESSION["role"]=="admin"): ?>
            <a href="admindash.php">Admin Panel</a>
        <?php endif; ?>

        <a class="logout" href="logout.php">Logout</a>
    </div>
</div>

<div class="spacer"></div>

<h1 class="page-title">Items Dashboard</h1>

<div class="filters">
    <a href="userdash.php">All</a>
    <a href="userdash.php?search_category=lost">Lost</a>
    <a href="userdash.php?search_category=found">Found</a>
</div>

<div class="grid">

<?php while($row = $result->fetch_assoc()): ?>
    <div class="card">
        <?php if($row['image']): ?>
            <img src="<?= $row['image'] ?>">
        <?php else: ?>
            <img src="https://via.placeholder.com/300x200">
        <?php endif; ?>

        <div class="card-body">
            <h3><?= htmlspecialchars($row['item_name']) ?></h3>
            <p><?= htmlspecialchars($row['description']) ?></p>
            <br>
            <span class="badge <?= $row['status'] ?>">
                <?= strtoupper($row['status']) ?>
            </span>
        </div>
    </div>
<?php endwhile; ?>

</div>

</body>
</html>
