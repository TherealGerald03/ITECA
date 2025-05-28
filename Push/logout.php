<?php  // logout logic 

session_start();
session_unset();
session_destroy();  // terminates active session 
header("Location: index.php"); // logout header redirect location will be changed 
exit();
 
?>  

