<?php
session_start();

include("../../global.php");
include("$root/admin/inc/functions.php");

$conn = dbconnect();

// dd($_POST);

if (isset($_POST['submit'])) {
    $id = $_SESSION['adminId'];

    $name = mysqli_real_escape_string($conn, trim(htmlspecialchars($_POST['name'])));
    $email = mysqli_real_escape_string($conn, trim(htmlspecialchars($_POST['email'])));
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    //validation 
    $errors = [];

    //name: required | string | max:255
    if (empty($name)) {
        $errors[] = "Name is required!";
    } elseif (!is_string($name)) {
        $errors[] = "Name must be string";
    } elseif (strlen($name) > 255) {
        $errors[] = "Name must be less than 255 character";
    }

    //email: required | email | max:255
    if (empty($email)) {
        $errors[] = "Email is required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email must be string";
    } elseif (strlen($email) > 255) {
        $errors[] = "Email must be less than 255 character";
    }

    //password is not required
    if (!empty($password)) {
        // Validate password and passwordConfirm
        if (!is_string($password)) {
            $errors[] = "Password must be string";
        } elseif (strlen($password) < 9 or strlen($password) > 60) {
            $errors[] = "Password lenght between 9 - 60 chracacter";
        } elseif ($password != $confirmPassword) {
            $errors[] = "Password and Confirm don't match";
        }

        $passHash = password_hash($password, PASSWORD_DEFAULT);
    }

    // dd($errors);

    if (empty($errors)) {

        if (empty($password)) {
            $sql = "UPDATE admins SET `name` = '$name',
                    email = '$email'
                    WHERE id = $id";
        } else {
            $sql = "UPDATE admins SET `name` = '$name',
                    email = '$email',
                    `password` = '$passHash'
                    WHERE id = $id";
        }

        if (mysqli_query($conn, $sql) == true) {
            //redirect with success
            $_SESSION['success'] = "Profile updated successfully.";
            $_SESSION['adminName'] = $name;
        }

        mysqli_close($conn);
    } else {
        $_SESSION['errors'] = $errors;
    }
            // dd($_SESSION);

    header("location: $url" . "admin/edit-profile.php");
    die;
}
