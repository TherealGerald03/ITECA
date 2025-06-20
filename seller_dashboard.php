<?php
session_start();
require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch seller profile data
$stmt = $conn->prepare("SELECT * FROM seller_profiles WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    // If profile not set up yet, redirect to profile setup
    header("Location: seller_profile.php");
    exit();
}

$seller = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Seller Dashboard - Afrimart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(to right, #f8fafc, #e0e7ff);
            font-family: 'Poppins', sans-serif;
        }
        .dashboard {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            margin-top: 50px;
        }
        .profile-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 15px;
            border: 3px solid #f97316;
        }
        .btn-custom {
            background-color: #f97316;
            color: white;
            font-weight: bold;
        }
        .btn-custom:hover {
            background-color: #ea580c;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="dashboard mx-auto col-md-6 text-center">
        <h2 class="mb-4">Welcome, <?= htmlspecialchars($seller['shop_name']) ?> 👋</h2>

        <?php if (!empty($seller['profile_image'])): ?>
            <img src="<?= htmlspecialchars($seller['profile_image']) ?>" class="profile-img" alt="Profile Image">
        <?php else: ?>
            <img src="default-avatar.png" class="profile-img" alt="Profile Image">
        <?php endif; ?>

        <p><strong>Description:</strong> <?= htmlspecialchars($seller['description']) ?></p>
        <p><strong>Phone:</strong> <?= htmlspecialchars($seller['phone']) ?></p>
        <p><strong>Address:</strong> <?= htmlspecialchars($seller['address']) ?></p>

        <div class="d-grid gap-3 mt-4">
            <a href="add_product.php" class="btn btn-custom">➕ Add New Product</a>
            <a href="manage_products.php" class="btn btn-outline-dark">🛒 Manage Products</a>
            <a href="edit_seller_profile.php" class="btn btn-outline-secondary">⚙️ Edit Profile</a>
            <a href="seller_orders.php" class="btn btn-outline-info">📬 View Orders</a>
            <a href="assign_courier_to_product.php" class="btn btn-outline-primary">🚚 Assign Courier to Product</a>
            <a href="logout.php" class="btn btn btn-outline-dark"> Logout </a>


        </div>
    </div>
</div>

</body>
</html>
