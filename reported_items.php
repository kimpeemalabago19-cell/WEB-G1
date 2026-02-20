<?php
session_start();
include "config.php";

/* 🔐 Protect page (ADMIN ONLY) */
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: login.php");
    exit;
}

$items = $conn->query("SELECT * FROM items ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
<title>Reported Items - CHMSU Lost & Found</title>
<style>
body { font-family:'Segoe UI'; background:#f1f5f9; padding:20px; }

.header { display:flex; justify-content:space-between; align-items:center; background:#1e293b; color:#fff; padding:20px 30px; border-radius:10px; margin-bottom:20px;}
.system-title { border:2px solid #2563eb; padding:10px 20px; border-radius:8px; font-weight:bold; font-size:1.5rem;}
.logout-btn { background:#2563eb; color:#fff; padding:10px 20px; border-radius:6px; text-decoration:none; font-weight:bold; }

.nav-links { display:flex; gap:15px; justify-content:center; margin-bottom:20px; }
.nav-links a { text-decoration:none; padding:8px 15px; border-radius:6px; background:#2563eb; color:#fff; }

.items-list { width:100%; display:flex; flex-direction:column; gap:10px; }

.header-row { display:flex; justify-content:space-between; background:#2563eb; color:#fff; padding:12px 15px; border-radius:6px; font-weight:bold; }
.header-row div { flex:1; padding:0 5px; }
.header-row .image-col { flex:0 0 120px; text-align:center; }
.header-row .action-col { flex:0 0 140px; text-align:center; }

.item-row { display:flex; align-items:center; background:#fff; padding:12px 15px; border-radius:6px; border:1px solid #e5e7eb; }
.item-row:nth-child(even) { background:#f9fafb; }

.item-image { flex:0 0 120px; margin-right:15px; text-align:center; }
.item-image img { width:100px; height:80px; object-fit:cover; border-radius:6px; }

.item-info { flex:1; display:flex; flex-wrap:wrap; gap:10px; }
.item-info div { flex:1 1 150px; }

.item-status.lost { color:red; font-weight:bold; }
.item-status.found { color:green; font-weight:bold; }

.action-buttons { flex:0 0 140px; text-align:center; }
.btn-edit { background:#16a34a; color:#fff; padding:6px 10px; border-radius:5px; text-decoration:none; margin-right:5px; }
.btn-delete { background:#dc2626; color:#fff; padding:6px 10px; border-radius:5px; text-decoration:none; }
</style>
</head>
<body>

<div class="header">
    <div class="system-title">CHMSU Lost & Found Management System</div>
    <a class="logout-btn" href="logout.php">Logout</a>
</div>

<div class="nav-links">
    <a href="admindash.php">Add Item</a>
    <a href="reported_items.php">Reported Items</a>
    <a href="found_items.php">Found Items</a>
</div>

<div class="items-list">

    <div class="header-row">
        <div class="image-col">Image</div>
        <div>Name</div>
        <div>Description</div>
        <div>Category</div>
        <div>Status</div>
        <div>Date Found</div>
        <div>Reported At</div>
        <div class="action-col">Action</div>
    </div>

<?php while($row = $items->fetch_assoc()): ?>
    <div class="item-row">
        <div class="item-image">
            <img src="<?= !empty($row['image']) ? htmlspecialchars($row['image']) : 'placeholder.png' ?>">
        </div>

        <div class="item-info">
            <div><?= htmlspecialchars($row['item_name']) ?></div>
            <div><?= htmlspecialchars($row['description']) ?></div>
            <div><?= htmlspecialchars($row['category']) ?></div>
            <div class="item-status <?= $row['status'] ?>"><?= strtoupper($row['status']) ?></div>
            <div><?= !empty($row['date_found']) ? $row['date_found'] : 'N/A' ?></div>
            <div><?= $row['created_at'] ?></div>
        </div>

        <div class="action-buttons">
            <a class="btn-edit" href="edit_items.php?id=<?= intval($row['id']) ?>">Edit</a>
            <a class="btn-delete"
               href="delete_items.php?id=<?= intval($row['id']) ?>"
               onclick="return confirm('Are you sure you want to delete this item?');">
               Delete
            </a>
        </div>
    </div>
<?php endwhile; ?>

</div>
</body>
</html>
