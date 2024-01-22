<?php
session_start();

include("../inc/functions.php");

$conn = dbconnect();

// dd($_POST);

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, trim(htmlspecialchars($_POST['email'])));
    $password = mysqli_real_escape_string($conn, trim(htmlspecialchars($_POST['password'])));

    //validation 
    $errors = [];

    //email: required | email | max:255
    if (empty($email)) {
        $errors[] = "Email is required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) or strlen($email) > 255) {
        $errors[] = "Invalid email format!";
    }

    //password: required | string | -min:12- | -max:255-
    if (empty($password)) {
        $errors[] = "password is required!";
    }

    // (email & password format is good) --->  check if email exist then check if credentials matches
    if (empty($errors)) {
        //select row by mail
        $sql = "SELECT * FROM admins where email = '$email'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $admin = mysqli_fetch_assoc($result);
            if (password_verify($password, $admin['password'])) {
                //all goood. kollo tmam. --> store admin data in session
                $_SESSION['adminId'] = $admin['id'];
                $_SESSION['adminName'] = $admin['name'];
                $_SESSION['isLogin'] = true;

                header('location: /admin/index.php');
                die;
            }
        }
        
        // mail not in admins table  &&/or incorrect password 
        $_SESSION['errors'][] = "Invalid Credentials!";

    } else { // if $errors is not empty
        // dd('not empty');
        $_SESSION['errors'] = $errors;
    }

    //goto login if $errors found
    header('location: ../login.php');
    die;
}
