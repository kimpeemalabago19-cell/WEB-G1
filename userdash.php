<?php
session_start();
include "config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$categoryFilter = $_GET['search_category'] ?? 'all';

/* Handle claim submission */
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item_id'], $_POST['confirm'])){
    $item_id = $_POST['item_id'];
    $stmt = $conn->prepare("UPDATE items SET status='found', claimed_by=?, claim_date=NOW() WHERE id=?");
    $stmt->bind_param("ii", $user_id, $item_id);
    $stmt->execute();
    $_SESSION['message'] = "Item successfully moved to Found Items!";
    header("Location: userdash.php?search_category=found");
    exit;
}

/* Fetch items based on category */
if($categoryFilter == "lost" || $categoryFilter == "found"){
    $stmt = $conn->prepare("SELECT * FROM items WHERE status=? ORDER BY id DESC");
    $stmt->bind_param("s",$categoryFilter);
    $stmt->execute();
    $result = $stmt->get_result();
} elseif($categoryFilter == "claimed") {
    $stmt = $conn->prepare("SELECT * FROM items WHERE claimed_by=? ORDER BY claim_date DESC");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM items ORDER BY id DESC");
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Lost & Found Dashboard</title>
<style>
*{box-sizing:border-box;margin:0;padding:0;font-family:'Segoe UI',sans-serif;}
body{background:#eef2f7;color:#1e293b;}
.navbar{position:fixed;top:0;width:100%;height:65px;background:#0f172a;display:flex;align-items:center;justify-content:space-between;padding:0 70px;z-index:1000;box-shadow:0 2px 10px rgba(0,0,0,0.15);}
.nav-links{display:flex;gap:25px;align-items:center;}
.nav-links a{text-decoration:none;color:#cbd5e1;font-size:14px;font-weight:500;transition:.3s;}
.nav-links a:hover{color:#38bdf8;}
.logout{background:#ef4444;padding:6px 14px;border-radius:6px;color:white !important;font-size:13px;cursor:pointer;}
.spacer{height:90px;}
.hero{display:flex;flex-direction:column;justify-content:center;align-items:center;text-align:center;padding:30px 15px;margin-bottom:20px;background:#ffffff;border-radius:12px;box-shadow:0 4px 12px rgba(0,0,0,0.08);}
.hero h1{font-size:32px;color:#1e293b;margin-bottom:10px;}
.hero p{color:#64748b;font-size:15px;max-width:600px;line-height:1.4;}
.header-section{width:95%;max-width:1200px;margin:0 auto 25px auto;}
.page-title{font-size:22px;font-weight:600;margin-bottom:10px;}
.grid{width:95%;max-width:1200px;margin:auto;display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:25px;padding-bottom:80px;}
.card{background:white;border-radius:14px;overflow:hidden;border:1px solid #e2e8f0;transition:all .3s ease;display:flex;flex-direction:column;}
.card:hover{box-shadow:0 12px 25px rgba(0,0,0,0.1);transform:translateY(-6px) scale(1.02);}
.card-header{font-size:11px;padding:8px;text-align:center;font-weight:600;letter-spacing:.5px;}
.card-header.lost{background:#fee2e2;color:#b91c1c;}
.card-header.found{background:#dcfce7;color:#166534;}
.card-header.claimed{background:#fef3c7;color:#b45309;}
.card img{width:100%;height:190px;object-fit:cover;transition:.4s;}
.card:hover img{transform:scale(1.08);}
.card-body{padding:16px;flex:1;display:flex;flex-direction:column;justify-content:space-between;}
.card-body h3{font-size:15px;margin-bottom:8px;font-weight:600;}
.card-body p{font-size:13px;color:#64748b;margin-bottom:14px;line-height:1.5;min-height:50px;}
.card-footer{font-size:11px;color:#94a3b8;margin-top:auto;}
.claim-btn{background:#3b82f6;color:white;padding:6px 12px;border:none;border-radius:8px;font-size:13px;font-weight:500;cursor:pointer;transition:.3s;}
.claim-btn:hover{background:#2563eb;}
.empty{text-align:center;padding:70px;color:#64748b;font-size:15px;}
.modal{display:none;position:fixed;z-index:2000;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,0.6);justify-content:center;align-items:center;}
.modal-content{background:white;width:90%;max-width:500px;border-radius:15px;overflow:hidden;animation:zoomIn .3s ease;position:relative;}
.modal-body{padding:20px;}
.close-btn{position:absolute;top:15px;right:20px;font-size:28px;color:#1e293b;cursor:pointer;}
.confirm-btn{background:#10b981;color:white;padding:8px 16px;border:none;border-radius:8px;font-weight:600;cursor:pointer;margin-top:15px;transition:.3s;}
.confirm-btn:hover{background:#059669;}
#claimForm input[type=checkbox]{margin-right:8px;}
@keyframes zoomIn{from{transform:scale(.8);opacity:0;}to{transform:scale(1);opacity:1;}}
@media(max-width:768px){.grid{grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:18px;}.card img{height:150px;}.navbar{padding:0 25px;}}
</style>
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
    <div class="logo">Lost & Found</div>
    <div class="nav-links">
        <a href="home.php">Home</a> <!-- restored -->
        <a href="userdash.php?search_category=lost">Lost Items</a>
        <a href="userdash.php?search_category=found">Found Items</a>
        <a href="userdash.php?search_category=claimed">Claimed Items</a>
        <a class="logout" href="logout.php">Logout</a>
    </div>
</div>

<div class="spacer"></div>

<!-- HERO / Homepage inside userdash -->
<?php if($categoryFilter == 'all'): ?>
<div class="hero">
    <h1>Welcome back, <?= htmlspecialchars($_SESSION['name'] ?? 'User') ?>!</h1>
    <p>Quickly report, search, and claim lost items using our system. You can also view found items and your claimed items here.</p>
</div>
<?php endif; ?>

<!-- ITEMS GRID -->
<?php if($categoryFilter != 'all'): ?>
<div class="header-section">
    <div class="page-title">
        <?php
            if($categoryFilter == "lost"){echo "Lost Items";}
            elseif($categoryFilter == "found"){echo "Found Items";}
            elseif($categoryFilter == "claimed"){echo "Claimed Items";}
        ?>
    </div>
</div>

<div class="grid">
<?php if($result->num_rows > 0): ?>
<?php while($row = $result->fetch_assoc()): ?>
    <div class="card">
        <div class="card-header 
            <?php 
            if($categoryFilter=='lost') echo 'lost'; 
            elseif($categoryFilter=='found') echo 'found'; 
            elseif($categoryFilter=='claimed') echo 'claimed'; 
            ?>
        ">
        <?php 
            if($categoryFilter=='lost') echo 'LOST'; 
            elseif($categoryFilter=='found') echo 'FOUND'; 
            elseif($categoryFilter=='claimed') echo 'CLAIMED'; 
        ?>
        </div>
        <img src="<?= !empty($row['image']) ? htmlspecialchars($row['image']) : 'https://via.placeholder.com/400x300' ?>">
        <div class="card-body">
            <div>
                <h3><?= htmlspecialchars($row['item_name']) ?></h3>
                <p><?= htmlspecialchars($row['description']) ?></p>
            </div>
            <div class="card-footer">
                Reported: <?= date("M d, Y", strtotime($row['date_found'])) ?>
                <?php if($categoryFilter=='claimed'): ?>
                    <br>Claimed on: <?= date("M d, Y", strtotime($row['claim_date'])) ?>
                <?php endif; ?>
            </div>
            <?php if($categoryFilter=='lost'): ?>
                <button class="claim-btn" onclick="openClaimModal('<?= htmlspecialchars($row['id']) ?>','<?= htmlspecialchars($row['item_name']) ?>')">Claim</button>
            <?php endif; ?>
        </div>
    </div>
<?php endwhile; ?>
<?php else: ?>
    <div class="empty">No items available.</div>
<?php endif; ?>
</div>
<?php endif; ?>

<!-- CLAIM MODAL -->
<div class="modal" id="claimModal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeClaimModal()">&times;</span>
        <div class="modal-body">
            <h2>Confirm Claim</h2>
            <p id="claimItemName" style="font-weight:600;margin-bottom:10px;"></p>
            <form id="claimForm" method="POST">
                <input type="hidden" name="item_id" id="claimItemId">
                <label><input type="checkbox" name="confirm" required> I confirm this is my item and I will claim it at OSAS.</label>
                <br>
                <button type="submit" class="confirm-btn">Submit Claim</button>
            </form>
        </div>
    </div>
</div>

<script>
function openClaimModal(itemId, itemName){
    document.getElementById("claimModal").style.display = "flex";
    document.getElementById("claimItemId").value = itemId;
    document.getElementById("claimItemName").innerText = itemName;
}
function closeClaimModal(){
    document.getElementById("claimModal").style.display = "none";
}
window.onclick = function(event){
    const modal = document.getElementById("claimModal");
    if(event.target == modal){ closeClaimModal(); }
}
</script>

</body>
</html>