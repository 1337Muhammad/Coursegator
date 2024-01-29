<?php
session_start();

include("../../global.php");

// start connecting to db
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "coursegator";
// create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// dd(var_export($request->post('submit')));

if ($request->postHas('submit')) {
    $id = $_SESSION['adminId'];
    // dd($id);

    $name = mysqli_real_escape_string($conn, $request->trimCleanPost('name'));
    $email = mysqli_real_escape_string($conn, $request->trimCleanPost('email'));
    // dd($email);
    $password = $request->post('password');
    $confirmPassword = $request->post('confirmPassword');

    //validation 
    $errors = [];

    //name: required | string | max:255
    $errors[] = validateName($name);

    //email: required | email | max:255
    $errors[] = validateEmail($email);

    $errors = cleanErrors($errors);

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
            // $sql = "UPDATE admins SET `name` = '$name',
            //         email = '$email'
            //         WHERE id = $id";
            $isUpdated = update(
                $conn,
                "admins",
                "`name`='$name', `email`='$email', `password` = '$passHash'",
                "id = $id"
            );
        } else {
            // $sql = "UPDATE admins SET `name` = '$name',
            //         email = '$email',
            //         `password` = '$passHash'
            //         WHERE id = $id";
            $isUpdated = update(
                $conn,
                "admins",
                "`name`='$name', `email`='$email', `password` = '$passHash'",
                "id = $id"
            );
        }

        if ($isUpdated) {
            //redirect with success
            $_SESSION['success'] = "Profile updated successfully.";
            $_SESSION['adminName'] = $name;
        }

        mysqli_close($conn);
    } else {
        $_SESSION['errors'] = $errors;
    }
    // dd($_SESSION);
}

header("location: $url" . "admin/edit-profile.php");
die;
