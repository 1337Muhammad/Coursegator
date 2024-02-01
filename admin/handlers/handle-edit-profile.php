<?php
include("../../global.php");


//validation 
$errors = [];

if ($request->postHas('submit')) {
    $id = $session->get('adminId');
    // dd($id);

    $name = $db->evadeSql($request->trimCleanPost('name'));
    $email = $db->evadeSql($request->trimCleanPost('email'));
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
            $isUpdated = $db->update(
                "admins",
                "`name`='$name', `email`='$email'",
                "id = $id"
            );
        } else {
            $isUpdated = $db->update(
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

            header("location: $url" . "admin/edit-profile.php");
            die;
        }
    }

} else {
    $errors = ['Error Submitting! Please Try Again'];
}

$session->set('errors', $errors);

header("location: $url" . "admin/edit-profile.php");
die;
