<?php
session_start();

// simulate clearing the cart after checkout
if (!empty($_SESSION['cart'])) {
    unset($_SESSION['cart']);
    $message = "Thank you for your purchase!";
} else {
    $message = "Your cart was empty.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Checkout</h2>
    <p class="alert alert-info"><?= $message ?></p>
    <a href="index.php" class="btn btn-primary">Return to Home</a>
</body>
</html>
