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
if(!$conn){
    die("Connection failed: ".mysqli_connect_error());
}

// dd($_POST);

if ($request->postHas('submit')) {
    $id = $request->getHas('id') ? $request->get('id') : false;

    $name = mysqli_real_escape_string($conn, $request->trimCleanPost('name'));

    //validation 
    $errors = [];

    //name: required | string | max:255
    $errors[] = validateName($name);

    $errors = cleanErrors($errors);

    if (empty($errors) && $id !== false) {
        
        $isUpdated = update(
            $conn,
            "categories",
            "`name` = '$name'",
            "id = $id"
        );

        if($isUpdated){
            //redirect with success
            $_SESSION['success'] = "Category updated.";
        }

        mysqli_close($conn);

        header("location: $url" . "admin/all-categories.php");
        die;
    }else{
        //store $errors in session
        $_SESSION['errors'] = $errors;
        header("location: $url" . "admin/edit-category.php?id=$id");
    }

}
