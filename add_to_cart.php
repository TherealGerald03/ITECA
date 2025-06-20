<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header('Location: login_demo.php'); // match your login page name
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;

if ($product_id > 0 && $quantity > 0) {
    // Insert or update quantity if already in cart
    $stmt = $conn->prepare("
        INSERT INTO cart_items (user_id, product_id, quantity, added_at)
        VALUES (?, ?, ?, NOW())
        ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)
    ");
    $stmt->bind_param("iii", $user_id, $product_id, $quantity);
    $stmt->execute();
    $stmt->close();
}

header("Location: sales.php");
exit;
