<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: login_demo.php');
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Couriers</title>
    <link rel="stylesheet" href="login.css">
</head>

<body style="background: #fff;">

    <div class="box">
        <h1>Welcome to Afrimart, <span><?= htmlspecialchars($_SESSION['name'] ?? 'Guest'); ?></span></h1>   <!-- add a link to the sales page below the welcome page: Guest is the fallback name -->
        <p> This is the<span>courier</span>page:</p>
       <button style="padding: 10px 20px; background-color: #333; color: white; border: none;" onclick="window.location.href='logout.php'">Logout</button> // logout.php button not appearing yet 
    </div>

    
</body>
</html>