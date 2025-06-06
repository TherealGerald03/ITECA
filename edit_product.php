<?php
session_start();
require_once 'config.php';

// Verify login
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$seller_id = $_SESSION['user_id'];

// Check if product ID provided
if (!isset($_GET['id'])) {
    header("Location: manage_products.php");
    exit();
}

$product_id = intval($_GET['id']);

// Fetch product
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ? AND seller_id = ?");
$stmt->bind_param("ii", $product_id, $seller_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: manage_products.php");
    exit();
}

$product = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];

    $update_image = $product['product_image']; // Default to existing image

    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $new_file = $target_dir . basename($_FILES["product_image"]["name"]);

        if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $new_file)) {
            $update_image = $new_file;
        }
    }

    // Update DB
    $stmt = $conn->prepare("UPDATE products SET product_name=?, price=?, category=?, description=?, quantity=?, product_image=? WHERE id=? AND seller_id=?");
    $stmt->bind_param("sdsssiii", $product_name, $price, $category, $description, $quantity, $update_image, $product_id, $seller_id);
    $stmt->execute();

    header("Location: manage_products.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product - Afrimart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { background: #f8fafc; font-family: 'Poppins', sans-serif; }
        .form-container {
            background: #fff; padding: 30px; border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1); margin-top: 50px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="form-container mx-auto col-md-6">
        <h2 class="mb-4 text-center">✏️ Edit Product</h2>

        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Product Name</label>
                <input type="text" name="product_name" value="<?= htmlspecialchars($product['product_name']) ?>" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Price (R)</label>
                <input type="number" name="price" step="0.01" value="<?= htmlspecialchars($product['price']) ?>" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Category</label>
                <input type="text" name="category" value="<?= htmlspecialchars($product['category']) ?>" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control" required><?= htmlspecialchars($product['description']) ?></textarea>
            </div>

            <div class="mb-3">
                <label>Quantity</label>
                <input type="number" name="quantity" value="<?= htmlspecialchars($product['quantity']) ?>" class="form-control" required>
            </div>

            <div class="mb-3">
    <label>Current Image:</label><br>
    <?php if (!empty($product['product_image'])): ?>
        <img src="<?= htmlspecialchars($product['product_image']) ?>" alt="Product Image" style="max-width: 200px; margin-bottom:10px;">
    <?php else: ?>
        <p>No image uploaded yet.</p>
    <?php endif; ?>
</div>

<div class="mb-3">
    <label>Change Product Image (optional):</label>
    <input type="file" name="product_image" class="form-control">
</div>


            <button type="submit" class="btn btn-warning w-100">Save Changes</button>
            <a href="manage_products.php" class="btn btn-secondary w-100 mt-2">Cancel</a>
        </form>
    </div>
</div>

</body>
</html>
