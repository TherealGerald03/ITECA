<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
    header("Location: login_demo.php");
    exit;
}

$product_id = $_POST['product_id'];
$courier_id = $_POST['courier_id'];

// Update product to set default courier
$stmt = $conn->prepare("UPDATE products SET default_courier_id = ? WHERE id = ?");
$stmt->bind_param("ii", $courier_id, $product_id);
$stmt->execute();

header("Location: seller_dashboard.php?msg=courier_assigned");
exit;
