<?php
session_start();
require_once 'config.php';

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $checkEmail = $conn->query("SELECT email FROM users WHERE email = '$email'");
    if ($checkEmail->num_rows > 0) {
        $_SESSION['register_error'] = 'Email is already registered!';
        $_SESSION['active_form'] = 'register';
    } else {
        $conn->query("INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')");
    }

    header("Location: login_demo.php");
    exit();
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE email = '$email'");
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        $_SESSION['name'] = $user['name'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['user_id'] = $user['id'];  // You will need this for the profile check

        if ($user['role'] === 'admin') {
            header("Location: admin_page.php");
            exit();
        } elseif ($user['role'] === 'courier') {
            header("Location: courier_page.php");
            exit();
        } elseif ($user['role'] === 'user') {
            header("Location: user_page.php");
            exit();
        } elseif ($user['role'] === 'seller') {
            //  seller profile check 
            $user_id = $user['id'];  // getting the ID of this user

            $sellerCheck = $conn->query("SELECT * FROM seller_profiles WHERE user_id = $user_id");

            if ($sellerCheck->num_rows > 0) {
                // profile exists
                header("Location: seller_dashboard.php");
            } else {
                // no profile yet
                header("Location: seller_profile.php");
            }
            exit();
        } else {
            header("Location: index.php");
            exit();
        }
    }
}


        }


    // Only reached if email not found or password failed
    $_SESSION['login_error'] = 'Incorrect email or password';
    $_SESSION['active_form'] = 'login';
    header("Location: index.php");
    exit();

?>
