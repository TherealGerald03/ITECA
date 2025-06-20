<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id']) && $_SESSION['role'] === 'courier') {
    $orderId = intval($_POST['order_id']);
    $courierId = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO courier_applications (courier_id, order_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $courierId, $orderId);
    $stmt->execute();
    $stmt->close();
}

header("Location: courier_page.php");
exit;
