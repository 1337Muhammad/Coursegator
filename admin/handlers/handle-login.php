<?php
include("../../global.php");

if ($request->postHas('submit')) {
    $email = $db->evadeSql($request->trimCleanPost('email'));
    $password = $db->evadeSql($request->trimCleanPost('password'));

    // $db->evadeSql($request->trimCleanPost('');

    //validation 
    $validator = new Validator;
    $errors = [];

    //email: required | email | max:255
    $validator->email($email);

    //password: required | string | -min:12- | -max:255-
    $validator->required($password, "Password");

    // $errors = cleanErrors($errors);

    // (email & password format is good) --->  check if email exist then check if credentials matches
    if ($validator->valid()) {
        
        $admin = $db->selectOne("*", "admins", "WHERE email = '$email'");
        if($admin){
            echo "\$admin = " . var_export($admin);
            if (password_verify($password, $admin['password'])) {
                //all goood. kollo tmam. --> store admin data in session
                $session->set('adminId', $admin['id']);
                $session->set('adminName', $admin['name']);
                $session->set('isLogin', true);

                header("location: $url" . "admin/index.php");
                die;
            }
        }

        // mail not in admins table  &/or incorrect password 
        $_SESSION['errors'][] = "Invalid Credentials!";

    } else { 
        // if $errors is not empty
        $session->set('errors', $validator->getErrors());
    }

    //goto login if $errors found
    header("location: $url" . "admin/login.php");
    die;
}
