<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
    header("Location: login_demo.php");
    exit();
}

$sellerId = $_SESSION['user_id'];

// Get all unassigned orders from this seller
$query = "
    SELECT o.id AS order_id, o.product_id, o.quantity, o.status, o.buyer_id, p.product_name, u.name AS buyer_name
    FROM orders o
    JOIN products p ON o.product_id = p.id
    JOIN users u ON o.buyer_id = u.id
    WHERE o.seller_id = ? AND o.courier_id IS NULL
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $sellerId);
$stmt->execute();
$orders = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Seller Orders - Afrimart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { background: #f1f5f9; font-family: 'Poppins', sans-serif; }
        .card { margin-bottom: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.05); border: none; }
        .applicant-btn { margin: 2px; }
    </style>
</head>
<body>

<div class="container py-5">
    <h2 class="mb-4">📦 Pending Orders (Awaiting Courier)</h2>

    <?php while ($order = $orders->fetch_assoc()): ?>
        <div class="card p-4">
            <h5><?= htmlspecialchars($order['product_name']) ?></h5>
            <p><strong>Quantity:</strong> <?= $order['quantity'] ?></p>
            <p><strong>Buyer:</strong> <?= htmlspecialchars($order['buyer_name']) ?></p>

            <h6>Courier Applicants:</h6>
            <?php
            $applicants = $conn->prepare("SELECT ca.courier_id, u.name FROM courier_applications ca JOIN users u ON ca.courier_id = u.id WHERE ca.order_id = ?");
            $applicants->bind_param("i", $order['order_id']);
            $applicants->execute();
            $res = $applicants->get_result();
            if ($res->num_rows > 0):
                while ($courier = $res->fetch_assoc()):
            ?>
                <form action="assign_courier.php" method="POST" style="display:inline-block;">
                    <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                    <input type="hidden" name="courier_id" value="<?= $courier['courier_id'] ?>">
                    <button type="submit" class="btn btn-sm btn-outline-primary applicant-btn">
                        Accept <?= htmlspecialchars($courier['name']) ?>
                    </button>
                </form>
            <?php endwhile; else: ?>
                <p class="text-muted">No applications yet.</p>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>
</div>

</body>
</html>
