<?php
session_start();
require_once 'config.php';

// Check if logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch existing profile data
$stmt = $conn->prepare("SELECT * FROM seller_profiles WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$seller = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $shop_name = $_POST['shop_name'];
    $description = $_POST['description'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Handle file upload
    if (!empty($_FILES['profile_image']['name'])) {
        $target_dir = "uploads/";
        if (!file_exists($target_dir)) { mkdir($target_dir, 0777, true); }
        $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
        move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file);
    } else {
        $target_file = $seller['profile_image']; // Keep existing image
    }

    $update = $conn->prepare("UPDATE seller_profiles SET shop_name=?, description=?, phone=?, address=?, profile_image=? WHERE user_id=?");
    $update->bind_param("sssssi", $shop_name, $description, $phone, $address, $target_file, $user_id);
    $update->execute();

    header("Location: seller_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Seller Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { background: #f8fafc; font-family: 'Poppins', sans-serif; }
        .form-container { margin-top: 50px; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

<div class="container col-md-6 mx-auto form-container">
    <h2 class="mb-4 text-center">Edit Seller Profile</h2>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Shop Name</label>
            <input type="text" name="shop_name" class="form-control" value="<?= htmlspecialchars($seller['shop_name']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control"><?= htmlspecialchars($seller['description']) ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($seller['phone']) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Address</label>
            <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($seller['address']) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Profile Image (optional)</label>
            <input type="file" name="profile_image" class="form-control">
            <?php if (!empty($seller['profile_image'])): ?>
                <img src="<?= htmlspecialchars($seller['profile_image']) ?>" class="img-thumbnail mt-2" width="150">
            <?php endif; ?>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Update Profile</button>
            <a href="seller_dashboard.php" class="btn btn-secondary mt-2">Cancel</a>
        </div>
    </form>
</div>

</body>
</html>
