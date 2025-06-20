<?php
session_start();

$errors = [
    'login' => $_SESSION['login_error'] ?? '',
    'register' => $_SESSION['register_error'] ?? ''  // storing error messages from the session 
];

$activeForm = $_SESSION['active_form'] ?? 'login';

session_unset();

function showError($error) {
    return !empty($error) ? "<p class='error-message'>$error</p>" : '';
}

function isActiveForm($formName, $activeForm) {
    return $formName === $activeForm ? 'active' : '';  // empty string will be returned 
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login-Afrimart</title>
    <link rel="stylesheet" href="login.css">
</head>

<body>
    <div class="container">
       <div class="form-box <?= isActiveForm('login', $activeForm); ?>" id="login-form">  <!-- Login page starts here -->
            <form action="login_register.php" method="post">
                <h2>Login</h2>
                <?= showError($errors['login']); ?>
                <input type="email" name="email" placeholder="Email" required> 
                <input type="password" name="password" placeholder="Password" required>  
                <button type="submit" name="login">Login</button>
                <p>Dont have a account? <a onclick="showForm('register-form')">Register</a></p> <!--Js called-->
            </form>
        </div>


        <div class="form-box <?= isActiveForm('register', $activeForm); ?>" id="register-form">  <!--Register page starts here -->
            <form action="login_register.php" method="post">
                <h2> Register </h2>
                <?= showError($errors['register']); ?>
                <input type="text" name="name" placeholder="Name" required> 
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <select name="role" required> 
                    <option value="">--Select Role--</option>   
                    <option value="user">User</option>
                  <!--  <option value="admin">Admin</option> -->
                    <option value="courier">Courier</option>
                    <option value="seller">Seller</option>
                </select>
                <button type="submit" color="#f97316" name="register" >Register</button>
                <p> Already have an account ?<a onclick="showForm('login-form')"> Login</a> </p><!--Js called-->

            </form>
        </div>
    </div>
<script src="login_logic.js"></script>
</body>

</html>