<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'courier') {
    header('Location: login_demo.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = intval($_POST['order_id']);
    $courierId = $_SESSION['user_id'];

    // Check if this order is actually assigned to this courier
    $stmt = $conn->prepare("SELECT id FROM orders WHERE id = ? AND courier_id = ? AND status = 'In Transit'");
    $stmt->bind_param("ii", $orderId, $courierId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Accept the order
        $update = $conn->prepare("UPDATE orders SET status = 'Accepted by Courier' WHERE id = ?");
        $update->bind_param("i", $orderId);
        $update->execute();
        $update->close();

        $_SESSION['success'] = "Order #$orderId accepted successfully.";
    } else {
        $_SESSION['error'] = "You are not authorized to accept this order or it's already accepted.";
    }

    $stmt->close();
}

header('Location: courier_dashboard.php');
exit();
