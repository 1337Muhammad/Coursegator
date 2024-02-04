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

    // Validation
    $validator = new Validator;
    //name: required | string | max:255
    $validator->str($name, "name", 255);

    //email: required | email | max:255
    $validator->email($email);

    //password is not required
    $emptyPass = $validator->passwordConfirmed($password, $confirmPassword, 9, 60);
    if($emptyPass === false){  // if pass has value
        $passHash = password_hash($password, PASSWORD_DEFAULT);
    }

    // $errors = cleanErrors($errors);

    if ($validator->valid()) {

        if ($emptyPass == true) {
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
            $errors = ['Error updating database!'];
            $session->set('errors', $validator->getErrors());

            header("location: $url" . "admin/edit-profile.php");
            die;
        }
    }

} else {
    $errors = ['Error Submitting! Please Try Again'];
}

$session->set('errors', $validator->getErrors());

header("location: $url" . "admin/edit-profile.php");
die;
