<?php 
$host= "localhost";  // will change on server migration
$user= "root";   // will change to administrator on SM 
$password="NewStrongPassword123!";  // change on SM 
$database= "users_db"; // hopefully remains the same 

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>


