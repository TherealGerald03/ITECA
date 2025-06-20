<?php
session_start();
require_once 'config.php';

// Check if seller is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login_demo.php");
    exit();
}

// Fetch seller ID based on email
$email = $_SESSION['email'];
$query = $conn->query("SELECT id FROM users WHERE email = '$email'");
$user = $query->fetch_assoc();
$seller_id = $user['id'];

// Handle form submission
if (isset($_POST['submit'])) {
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $quantity = $_POST['quantity'];

    // Handle file upload
    $target_dir = "uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0755, true);
    }
    $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
    move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file);

    // Insert product
    $stmt = $conn->prepare("INSERT INTO products (seller_id, product_name, description, price, category, quantity, product_image) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issdsis", $seller_id, $product_name, $description, $price, $category, $quantity, $target_file);

    if ($stmt->execute()) {
        $success = "Product added successfully!";
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product - Seller Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f4f4;
            padding: 30px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input[type="text"], input[type="number"], textarea, input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        button {
            margin-top: 20px;
            width: 100%;
            padding: 12px;
            background: #4CAF50;
            border: none;
            color: white;
            font-weight: bold;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #45a049;
        }

        .message {
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Add New Product</h2>

    <?php if (isset($success)): ?>
        <div class="message success"><?= $success ?></div>
    <?php elseif (isset($error)): ?>
        <div class="message error"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <label>Product Name:</label>
        <input type="text" name="product_name" required>

        <label>Description:</label>
        <textarea name="description" required></textarea>

        <label>Price:</label>
        <input type="number" step="0.01" name="price" required>

        <label>Category:</label>
        <input type="text" name="category" required>

        <label>Quantity:</label>
        <input type="number" name="quantity" required>

        <label>Product Image:</label>
        <input type="file" name="product_image" required>

        <button type="submit" name="submit">Add Product</button>
    </form>
</div>

</body>
</html>
