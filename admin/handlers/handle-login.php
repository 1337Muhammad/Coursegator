<?php
include("../../global.php");

// start connecting to db
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "coursegator";
// create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// check connection
if(!$conn){
    die("Connection failed: ".mysqli_connect_error());
}

// dd($_POST);

if ($request->postHas('submit')) {
    $email = mysqli_real_escape_string($conn, $request->trimCleanPost('email'));
    $password = mysqli_real_escape_string($conn, trim($request->post('password')));

    //validation 
    $errors = [];

    //email: required | email | max:255
    $errors[] = validateEmail($email);

    //password: required | string | -min:12- | -max:255-
    if (empty($password)) {
        $errors[] = "password is required!";
    }

    $errors = cleanErrors($errors);

    // (email & password format is good) --->  check if email exist then check if credentials matches
    if (empty($errors)) {
        //select row by mail
        $sql = "SELECT * FROM admins where email = '$email'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $admin = mysqli_fetch_assoc($result);
            if (password_verify($password, $admin['password'])) {
                //all goood. kollo tmam. --> store admin data in session
                $session->set('adminId', $admin['id']);
                $session->set('adminName', $admin['name']);
                $session->set('isLogin', true);

                header('location: /admin/index.php');
                die;
            }
        }
        
        // mail not in admins table  &/or incorrect password 
        $_SESSION['errors'][] = "Invalid Credentials!";

    } else { 
        // if $errors is not empty
        $session->set('errors', $errors);
    }

    //goto login if $errors found
    header("location: $url" . "admin/login.php");
    die;
}
