<?php
session_start();
require_once 'config.php';

// Ensure seller is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
    header('Location: login_demo.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = intval($_POST['order_id']);
    $courierId = intval($_POST['courier_id']);
    
    // Update the order with the selected courier
    $stmt = $conn->prepare("UPDATE orders SET courier_id = ?, status = 'In Transit' WHERE id = ?");
    $stmt->bind_param("ii", $courierId, $orderId);
    $stmt->execute();
    $stmt->close();

    // Optional: remove other courier applications for this order
    $cleanup = $conn->prepare("DELETE FROM courier_applications WHERE order_id = ? AND courier_id != ?");
    $cleanup->bind_param("ii", $orderId, $courierId);
    $cleanup->execute();
    $cleanup->close();
}

header("Location: seller_orders.php");
exit();