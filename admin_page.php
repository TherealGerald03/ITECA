import os

# Create the contents of admin_page.php with full backend logic
php_code = """<?php
session_start();
require_once 'config.php';

// Restrict access to admins only
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Get all users
$users = $conn->query("SELECT id, name, email, role FROM users");

// Get all products with seller info
$products = $conn->query("SELECT p.id, p.product_name, p.price, u.name AS seller 
                          FROM products p 
                          JOIN users u ON p.seller_id = u.id");

// Get sales insights
$sales_insight = $conn->query("SELECT COUNT(*) AS total_sales, SUM(amount) AS revenue FROM sales");
$sales_data = $sales_insight->fetch_assoc();

// Optional: Site traffic
$traffic_data = [];
$traffic_query = $conn->query("SELECT page, SUM(views) as total_views FROM site_traffic GROUP BY page");
while ($row = $traffic_query->fetch_assoc()) {
    $traffic_data[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Afrimart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Welcome to Admin Panel</h2>

    <h4 class="mt-5">Users</h4>
    <table class="table table-bordered">
        <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th></tr></thead>
        <tbody>
        <?php while ($user = $users->fetch_assoc()): ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= htmlspecialchars($user['name']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= $user['role'] ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <h4 class="mt-5">Products</h4>
    <table class="table table-bordered">
        <thead><tr><th>ID</th><th>Product</th><th>Price</th><th>Seller</th></tr></thead>
        <tbody>
        <?php while ($product = $products->fetch_assoc()): ?>
            <tr>
                <td><?= $product['id'] ?></td>
                <td><?= htmlspecialchars($product['product_name']) ?></td>
                <td>R<?= number_format($product['price'], 2) ?></td>
                <td><?= htmlspecialchars($product['seller']) ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <h4 class="mt-5">Sales Insights</h4>
    <p><strong>Total Sales:</strong> <?= $sales_data['total_sales'] ?></p>
    <p><strong>Total Revenue:</strong> R<?= number_format($sales_data['revenue'], 2) ?></p>

    <h4 class="mt-5">Site Traffic (Optional)</h4>
    <table class="table table-bordered">
        <thead><tr><th>Page</th><th>Views</th></tr></thead>
        <tbody>
        <?php foreach ($traffic_data as $page): ?>
            <tr>
                <td><?= htmlspecialchars($page['page']) ?></td>
                <td><?= $page['total_views'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
"""

path = "/mnt/data/admin_page.php"
with open(path, "w") as file:
    file.write(php_code)

path
