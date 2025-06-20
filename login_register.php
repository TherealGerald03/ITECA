<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'config.php';

// REGISTRATION
if (isset($_POST['register'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $conn->real_escape_string($_POST['role']);

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

// LOGIN
if (isset($_POST['login'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE email = '$email'");
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            //  Set all session values
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];

            // ✅ Redirect based on role
            switch ($user['role']) {
                case 'admin':
                    header("Location: admin_page.php");
                    break;

                case 'courier':
                    header("Location: courier_page.php");
                    break;

                case 'user':
                    header("Location: user_page.php");
                    break;

                case 'seller':
                    $user_id = $user['id'];
                    $sellerCheck = $conn->query("SELECT * FROM seller_profiles WHERE user_id = $user_id");
                    if ($sellerCheck->num_rows > 0) {
                        header("Location: seller_dashboard.php");
                    } else {
                        header("Location: seller_profile.php");
                    }
                    break;

                default:
                    header("Location: index.php");
            }

            exit();
        }
    }

    //  Failed login
    $_SESSION['login_error'] = 'Incorrect email or password';
    $_SESSION['active_form'] = 'login';
    header("Location: login_demo.php");
    exit();
}
?>
