<?php
session_start();
include "config.php";

/* 🔐 Protect page (ADMIN ONLY) */
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: login.php");
    exit;
}

$allowedItemCategories = ['Clothing','Bags','Gadgets','Documents','Accessories','Others'];
$errors = [];
$success = '';

/* Handle Add Item */
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $item_name = trim($_POST['item_name']);
    $description = trim($_POST['description']);
    $category = $_POST['category'];
    $status = $_POST['status'];
    $date_found = $_POST['date_found'] ?? null;
    $imagePath = '';
    $reported_by = $_SESSION['user_id'];

    // Validate
    if (!$item_name || !$description || !$category || !$status) {
        $errors[] = "All fields except image and Date Found are required.";
    } elseif (!in_array($category, $allowedItemCategories)) {
        $errors[] = "Invalid category.";
    } elseif (!in_array($status, ['lost','found'])) {
        $errors[] = "Invalid status.";
    }

    // Handle Image Upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $allowedExt = ['jpg','jpeg','png','gif'];
        if (!in_array(strtolower($ext), $allowedExt)) {
            $errors[] = "Image must be jpg, jpeg, png, or gif.";
        } else {
            $targetDir = "uploads/";
            if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);
            $filename = uniqid() . "." . $ext;
            $imagePath = $targetDir . $filename;
            move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
        }
    }

    // Insert into DB
    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO items (item_name, description, category, status, image, date_found, reported_by) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssi", $item_name, $description, $category, $status, $imagePath, $date_found, $reported_by);
        if ($stmt->execute()) {
            $success = "Item added successfully!";
        } else {
            $errors[] = "Database error: " . $conn->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>CHMSU Lost & Found Management System</title>
    <style>
        body { font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background:#f1f5f9; padding:20px; }
        .header { display:flex; justify-content:space-between; align-items:center; background:#1e293b; color:#fff; padding:20px 30px; border-radius:10px; margin-bottom:30px; box-shadow:0 4px 8px rgba(0,0,0,0.1);}
        .system-title { border:2px solid #2563eb; padding:10px 20px; border-radius:8px; font-weight:bold; font-size:1.5rem; background-color:#1e293b; }
        .logout-btn { background:#2563eb; color:#fff; padding:10px 20px; border-radius:6px; text-decoration:none; font-weight:bold; transition:0.3s; }
        .logout-btn:hover { background:#1e40af; }
        .nav-links { margin-top:15px; display:flex; gap:15px; justify-content:center; }
        .nav-links a { text-decoration:none; padding:8px 15px; border-radius:6px; background:#2563eb; color:#fff; transition:0.3s; }
        .nav-links a:hover { background:#1e40af; }
        .dashboard-card { background:#fff; padding:30px; border-radius:12px; box-shadow:0 6px 20px rgba(0,0,0,0.1); max-width:700px; margin:0 auto 40px auto; }
        h3 { text-align:center; margin-bottom:20px; }
        input, select, textarea, button { width:100%; padding:10px; margin:8px 0; border-radius:6px; border:1px solid #ccc; font-size:0.95rem; }
        button { background:#2563eb; color:#fff; border:none; cursor:pointer; font-weight:bold; transition:0.3s; }
        button:hover { background:#1e40af; }
        .alert { padding:10px; border-radius:6px; margin-bottom:10px; }
        .alert-success { background:#d1fae5; color:#065f46; }
        .alert-error { background:#fee2e2; color:#b91c1c; }
    </style>
</head>
<body>

<div class="header">
    <div class="system-title">CHMSU Lost & Found Management System</div>
    <a class="logout-btn" href="logout.php">Logout</a>
</div>

<!-- Navigation Links -->
<div class="nav-links">
    <a href="admindash.php">Add Item</a>
    <a href="reported_items.php">Reported Items</a>
    <a href="found_items.php">Found Items</a>
</div>

<!-- Add Item Form -->
<div class="dashboard-card">
    <h3>Add New Item</h3>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>

    <?php foreach($errors as $err): ?>
        <div class="alert alert-error"><?= $err ?></div>
    <?php endforeach; ?>

    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="item_name" placeholder="Item Name" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <select name="category" required>
            <option value="">Select Category</option>
            <?php foreach($allowedItemCategories as $cat): ?>
                <option value="<?= $cat ?>"><?= $cat ?></option>
            <?php endforeach; ?>
        </select>
        <select name="status" required>
            <option value="">Select Status</option>
            <option value="lost">Lost</option>
            <option value="found">Found</option>
        </select>
        <input type="date" name="date_found" placeholder="Date Found (optional)">
        <input type="file" name="image" accept="image/*">
        <button type="submit">Add Item</button>
    </form>
</div>

</body>
</html>
