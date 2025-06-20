<?php
$host = "localhost";  
$user = "root";       
$password = "NewStrongPassword123!";  
$database = "users_db"; 

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
