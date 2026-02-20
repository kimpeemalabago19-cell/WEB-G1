<?php
session_start();
include "config.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: login.php");
    exit;
}

$id = intval($_GET['id']);
$item = $conn->query("SELECT * FROM items WHERE id=$id")->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = $_POST['item_name'];
    $desc = $_POST['description'];
    $category = $_POST['category'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE items SET item_name=?, description=?, category=?, status=? WHERE id=?");
    $stmt->bind_param("ssssi", $name, $desc, $category, $status, $id);
    $stmt->execute();

    header("Location: reported_items.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Item - CHMSU Lost & Found</title>
<style>

body {
    font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #1e293b, #2563eb);
    display:flex;
    justify-content:center;
    align-items:center;
    height:110vh;
    margin:0;
}

.edit-card {
    background:#fff;
    width:600px;
    padding:40px;
    border-radius:30px;
    box-shadow:0 15px 35px rgba(0,0,0,0.2);
    animation: fadeIn 0.5s ease-in-out;
}

@keyframes fadeIn {
    from {opacity:0; transform:translateY(20px);}
    to {opacity:1; transform:translateY(0);}
}

h2 {
    text-align:center;
    margin-bottom:25px;
    color:#1e293b;
}

label {
    font-weight:600;
    font-size:0.9rem;
    color:#334155;
}

input, textarea, select {
    width:100%;
    padding:12px;
    margin-top:6px;
    margin-bottom:18px;
    border-radius:8px;
    border:1px solid #cbd5e1;
    font-size:0.95rem;
    transition:0.3s;
}

input:focus, textarea:focus, select:focus {
    border-color:#2563eb;
    box-shadow:0 0 0 3px rgba(37,99,235,0.2);
    outline:none;
}

textarea {
    resize:none;
    height:90px;
}

.image-preview {
    text-align:center;
    margin-bottom:20px;
}

.image-preview img {
    width:160px;
    height:120px;
    object-fit:cover;
    border-radius:10px;
    border:3px solid #2563eb;
}

.status-badge {
    display:inline-block;
    padding:6px 12px;
    border-radius:20px;
    font-size:0.8rem;
    font-weight:bold;
    margin-bottom:15px;
}

.status-lost {
    background:#fee2e2;
    color:#dc2626;
}

.status-found {
    background:#dcfce7;
    color:#16a34a;
}

.button-group {
    display:flex;
    justify-content:space-between;
    gap:10px;
}

.btn {
    flex:1;
    padding:12px;
    border:none;
    border-radius:8px;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

.btn-update {
    background:#2563eb;
    color:#fff;
}

.btn-update:hover {
    background:#1e40af;
    transform:translateY(-2px);
}

.btn-cancel {
    background:#e2e8f0;
}

.btn-cancel:hover {
    background:#cbd5e1;
}

.back-link {
    text-align:center;
    margin-top:15px;
}

.back-link a {
    text-decoration:none;
    color:#2563eb;
    font-size:0.9rem;
}

</style>
</head>
<body>

<div class="edit-card">

    <h2>Update Item Details</h2>

    <div class="image-preview">
        <img src="<?= !empty($item['image']) ? htmlspecialchars($item['image']) : 'placeholder.png' ?>">
    </div>

    <div style="text-align:center;">
        <span class="status-badge <?= $item['status']=='lost' ? 'status-lost' : 'status-found' ?>">
            <?= strtoupper($item['status']) ?>
        </span>
    </div>

    <form method="POST">

        <label>Item Name</label>
        <input name="item_name" value="<?= htmlspecialchars($item['item_name']) ?>" required>

        <label>Description</label>
        <textarea name="description"><?= htmlspecialchars($item['description']) ?></textarea>

        <label>Category</label>
        <input name="category" value="<?= htmlspecialchars($item['category']) ?>">

        <label>Status</label>
        <select name="status">
            <option value="lost" <?= $item['status']=="lost"?"selected":"" ?>>Lost</option>
            <option value="found" <?= $item['status']=="found"?"selected":"" ?>>Found</option>
        </select>

        <div class="button-group">
            <button type="submit" class="btn btn-update">Update Item</button>
            <button type="button" class="btn btn-cancel" onclick="window.location='reported_items.php'">Cancel</button>
        </div>

    </form>

    <div class="back-link">
        <a href="reported_items.php">← Back to Reported Items</a>
    </div>

</div>

</body>
</html>
