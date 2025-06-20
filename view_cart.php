<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$query = "
SELECT ci.*, p.product_name, p.price, p.product_image
FROM cart_items ci
JOIN products p ON ci.product_id = p.id
WHERE ci.user_id = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Cart - Afrimart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4">🛒 Your Cart</h2>
    <a href="sales.php" class="btn btn-secondary mb-3">← Continue Shopping</a>

    <?php if ($result->num_rows > 0): ?>
        <table class="table table-bordered">
    <thead class="table-light">
        <tr>
            <th>Image</th>
            <th>Product</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $grand_total = 0;
        while ($item = $result->fetch_assoc()):
            $total = $item['price'] * $item['quantity'];
            $grand_total += $total;
        ?>
            <tr>
                <td><img src="<?= htmlspecialchars($item['product_image']) ?>" width="70"></td>
                <td><?= htmlspecialchars($item['product_name']) ?></td>
                <td><?= $item['quantity'] ?></td>
                <td>R<?= number_format($item['price'], 2) ?></td>
                <td>R<?= number_format($total, 2) ?></td>
                <td>
                    <form action="remove_from_cart.php" method="POST">
                        <input type="hidden" name="cart_id" value="<?= $item['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-danger">🗑 Remove</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<div class="text-end mt-4">
    
    <a href="checkout.php" class="btn btn-success btn-lg mt-2">🧾 Checkout</a>
</div>

        <h4 class="text-end">Total: R<?= number_format($grand_total, 2) ?></h4>
    <?php else: ?>
        <p>This is a demo website nothing here is for sale!</p>
    <?php endif; ?>
</div>

</body>
</html>
