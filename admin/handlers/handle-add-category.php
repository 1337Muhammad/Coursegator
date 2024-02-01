<?php
include("../../global.php");

if ($request->postHas('submit')) {

    $name = $db->evadeSql($request->trimCleanPost('name'));

    //validation 
    $errors = [];

    //name: required | string | max:255
    $errors[] = validateName($name);

    $errors = cleanErrors($errors);

    if (empty($errors)) {
        $sql = "INSERT INTO categories(name)
        VALUES ('$name')";
            $isInserted = $db->insert(
            "categories",
            "`name`",
            "'$name'"
        );

        if($isInserted){
            //redirect with success
            $session->set('success', "Category added succesfully");
        }

        header("location: $url" . "all-categories.php");
        die;
    }
}else{
    $errors = ['Ops! Please Try Again'];
}

//store $errors in session
$session->set('errors', $errors);
header("location: $url" . "admin/add-category.php");
die;