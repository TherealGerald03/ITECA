<?php
$host = "localhost";  
$user = "nope";       
$password = "nope";  
$database = "nope"; 

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
