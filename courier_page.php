<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'courier') {
    header('Location: login_demo.php');
    exit;
}

$userId = $_SESSION['user_id'];

// Fetch orders where courier can apply OR already assigned but not accepted
$query = "
   SELECT o.*, u.name AS buyer_name
FROM orders o
JOIN users u ON o.buyer_id = u.id
WHERE 
    (o.courier_id IS NULL AND o.status = 'Pending')
    OR (o.courier_id = ? AND o.status IN ('In Transit', 'Assigned'))

";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courier Dashboard - Afrimart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: #f9f9f9;
            font-family: 'Poppins', sans-serif;
        }
        .dashboard {
            margin-top: 60px;
        }
        .order-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container dashboard">
    <div class="text-center mb-4">
        <h2> Courier Dashboard</h2>
        <p>Welcome, <strong><?= htmlspecialchars($_SESSION['name']) ?></strong></p>
        <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
    </div>

    <h4>Available Orders:</h4>
    <?php while ($order = $result->fetch_assoc()): ?>
    <div class="order-card">
        <h5><?= htmlspecialchars($order['product_name']) ?></h5>
        <p><?= htmlspecialchars($order['description']) ?></p>
        <p><strong>Quantity:</strong> <?= $order['quantity'] ?></p>
        <p><strong>Buyer:</strong> <?= htmlspecialchars($order['buyer_name']) ?></p>

        <?php if (is_null($order['courier_id'])): ?>
            <!-- Apply button -->
            <form action="apply_for_order.php" method="POST">
                <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                <button type="submit" class="btn btn-primary">Apply for Delivery</button>
            </form>
        <?php elseif ($order['courier_id'] == $_SESSION['user_id'] && $order['status'] == 'In Transit'): ?>
            <!-- Accept button -->
            <form action="accept_courier_job.php" method="POST">
                <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                <button type="submit" class="btn btn-success">Accept Delivery</button>
            </form>
        <?php endif; ?>
    </div>
<?php endwhile; ?>

</div>

</body>
</html>
