<?php
session_start();
require_once 'config.php';

// Fetch all products with their seller info
$query = "
    SELECT p.*, s.shop_name 
    FROM products p
    JOIN seller_profiles s ON p.seller_id = s.user_id
    ORDER BY p.created_at DESC
";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Browse Products - Afrimart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: #f8fafc;
            font-family: 'Poppins', sans-serif;
        }
        .product-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 20px;
            transition: 0.3s;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }
        .product-img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 10px;
        }
    </style>
</head>
<body>
<div class="text-end p-3">
    <a href="view_cart.php" class="btn btn-dark">
         Go to Cart
    </a>
</div>
<div class="container mt-5">
    <h1 class="text-center mb-5">🛒 Products Available</h1>

   <div class="row">
    <?php while ($product = $result->fetch_assoc()): ?>
        <div class="col-md-4">
            <div class="product-card">

                <?php if (!empty($product['product_image'])): ?>
                    <img src="<?= htmlspecialchars($product['product_image']) ?>" class="product-img" alt="Product Image">
                <?php else: ?>
                    <img src="default-product.png" class="product-img" alt="No Image">
                <?php endif; ?>

                <h4 class="mt-3"><?= htmlspecialchars($product['product_name']) ?></h4>
                <p><?= htmlspecialchars($product['description']) ?></p>
                <p><strong>Category:</strong> <?= htmlspecialchars($product['category']) ?></p>
                <p><strong>Price:</strong> R<?= number_format($product['price'], 2) ?></p>
                <p><strong>Seller:</strong> <?= htmlspecialchars($product['shop_name']) ?></p>

                <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'user'): ?>
                    <form action="add_to_cart.php" method="POST" class="mt-3">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <input type="number" name="quantity" value="1" min="1" max="<?= $product['quantity'] ?>" class="form-control mb-2" style="max-width: 80px;">
                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                    </form>
                <?php else: ?>
                    <p><em>Login as a user to add to cart 🛒</em></p>
                <?php endif; ?>

            </div> <!-- .product-card -->
        </div> <!-- .col-md-4 -->
    <?php endwhile; ?>
</div>

