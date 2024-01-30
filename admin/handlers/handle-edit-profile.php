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
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

//validation 
$errors = [];

if ($request->postHas('submit')) {
    $id = $session->get('adminId');
    // dd($id);

    $name = mysqli_real_escape_string($conn, $request->trimCleanPost('name'));
    $email = mysqli_real_escape_string($conn, $request->trimCleanPost('email'));
    // dd($email);
    $password = $request->post('password');
    $confirmPassword = $request->post('confirmPassword');

    //name: required | string | max:255
    $errors[] = validateName($name);

    //email: required | email | max:255
    $errors[] = validateEmail($email);
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

    $errors = cleanErrors($errors);

    if (empty($errors)) {

        if (empty($password)) {
            $isUpdated = update(
                $conn,
                "admins",
                "`name`='$name', `email`='$email'",
                "id = $id"
            );
        } else {
            $isUpdated = update(
                $conn,
                "admins",
                "`name`='$name', `email`='$email', `password` = '$passHash'",
                "id = $id"
            );
        }

        if ($isUpdated) {
            //redirect with success
            $session->set('success', "Profile updated successfully.");
            $session->set('adminName', $name);
        } else {
            //error on query
            $errors = ['Error updateing database!'];
            $session->set('errors', $errors);

            mysqli_close($conn);
            header("location: $url" . "admin/edit-profile.php");
            die;
        }
    }

} else {
    $errors = ['Ops! Please Try Again'];
}

$session->set('errors', $errors);

mysqli_close($conn);
header("location: $url" . "admin/edit-profile.php");
die;
