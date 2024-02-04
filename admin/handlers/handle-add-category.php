<?php
include("../../global.php");

if ($request->postHas('submit')) {

    $name = $db->evadeSql($request->trimCleanPost('name'));

    //validation 
    $validator = new Validator;

    //name: required | string | max:255
    $errors[] = $validator->str($name, "name", 255);

    if ($validator->valid()) {
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
$session->set('errors', $validator->getErrors());
header("location: $url" . "admin/add-category.php");
die;