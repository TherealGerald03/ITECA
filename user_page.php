<?php
session_start(); 

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header('location: login_demo.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Afrimart</title>
    <link rel="stylesheet" href="login.css">
    <style>
        .button-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 15px; /* this adds spacing between buttons */
    margin-top: 30px;
}

.button-container button {
    padding: 12px 30px;
    background-color: #333;
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 8px;
    font-size: 16px;
    min-width: 200px;
    transition: background 0.2s ease;
}

.button-container button:hover {
    background-color: #555;
}

    </style>
</head>

<body>

    <div class="box">
        <h1>Welcome to Afrimart, <span><?= htmlspecialchars($_SESSION['name']); ?></span> 👋</h1>
        <p>This is your <strong>User Dashboard</strong></p>

       <div class="button-container">
         <button onclick="window.location.href='sales.php'">🛍 Browse Listings</button>
         <button onclick="window.location.href='view_cart.php'">🛒 View Cart</button>
         <button onclick="window.location.href='logout.php'">🚪 Logout</button>
     </div>  
  </div>

</body>
</html>
