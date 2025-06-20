<?php
session_start(); 
if (!isset($_SESSION['email'])) {
    header('location: login_demo.php');
    exit;

} 
 // page needs to change to show users profiles where they can make changes and logout descriptions 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Page</title>
    <link rel="stylesheet" href="login.css">
</head>

<body style="background: #fff;">

    <div class="box">
        <h1> Welcome to Afrimart, <span><?= htmlspecialchars($_SESSION['name']); ?></span> </h1>   <!-- add a link to the sales page below the welcome page -->
        <p> This is the<span> Seller </span>page:</p>
        <button style="padding: 10px 20px; background-color: #333; color: white; border: none;" 
        onclick="window.location.href='index.php'"> Start
    </button>
       
    


        <button style="padding: 10px 20px; background-color: #333; color: white; border: none;" onclick="window.location.href='logout.php'">Logout</button>
 
    </div>

    
</body>
</html>