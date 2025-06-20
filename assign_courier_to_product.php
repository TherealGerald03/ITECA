<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
    header("Location: login_demo.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Get seller products
$productQuery = $conn->prepare("SELECT id, product_name FROM products WHERE seller_id = ?");
$productQuery->bind_param("i", $user_id);
$productQuery->execute();
$products = $productQuery->get_result();

// Get available couriers
$courierQuery = $conn->query("SELECT id, name FROM users WHERE role = 'courier'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Assign Courier to Product</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-5">

    <div class="container">
        <h2 class="mb-4">Assign a Courier to Your Product</h2>

        <form action="process_assign_courier.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Select Product</label>
                <select name="product_id" class="form-select" required>
                    <?php while ($row = $products->fetch_assoc()): ?>
                        <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['product_name']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Select Courier</label>
                <select name="courier_id" class="form-select" required>
                    <?php while ($row = $courierQuery->fetch_assoc()): ?>
                        <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['name']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Assign Courier</button>
        </form>
    </div>

</body>
</html>
