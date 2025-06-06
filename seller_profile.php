<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Create upload directory if not exists
$uploadDir = 'uploads/profile_images/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $shop_name = $_POST['shop_name'];
    $description = $_POST['description'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $user_id = $_SESSION['user_id'];

    // Handle file upload
    $profile_image = null;
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $targetFile = $uploadDir . basename($_FILES['profile_image']['name']);
        move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetFile);
        $profile_image = $targetFile;
    }

    $stmt = $conn->prepare("INSERT INTO seller_profiles (user_id, shop_name, description, profile_image, phone, address) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $user_id, $shop_name, $description, $profile_image, $phone, $address);
    $stmt->execute();

    header("Location: seller_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Seller Profile Setup - Afrimart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(to right, #f8fafc, #e0e7ff);
            font-family: 'Poppins', sans-serif;
        }
        .profile-form {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            margin-top: 50px;
        }
        .form-label {
            font-weight: 600;
        }
        .btn-custom {
            background-color: #f97316;
            color: white;
        }
        .btn-custom:hover {
            background-color: #ea580c;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="profile-form mx-auto col-md-6">
        <h2 class="text-center mb-4">Setup Your Seller Profile</h2>

        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Shop Name</label>
                <input type="text" name="shop_name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Profile Image</label>
                <input type="file" name="profile_image" class="form-control" accept="image/*">
            </div>

            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Address</label>
                <input type="text" name="address" class="form-control">
            </div>

            <button type="submit" class="btn btn-custom w-100">Save Profile</button>
        </form>
    </div>
</div>

</body>
</html>
