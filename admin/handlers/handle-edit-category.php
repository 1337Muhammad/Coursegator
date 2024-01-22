<?php
session_start();

include("../../global.php");
include("$root/admin/inc/functions.php");

$conn = dbconnect();

// dd($_POST);

if (isset($_POST['submit'])) {
    $id = $_GET['id'] ?? false;

    $name = mysqli_real_escape_string($conn, trim(htmlspecialchars($_POST['name'])));

    //validation 
    $errors = [];

    //name: required | string | max:255
    if (empty($name)) {
        $errors[] = "Name is required!";
    } elseif(!is_string($name)){
        $errors[] = "Name must be string";
    } elseif(strlen($name) > 255) {
        $errors[] = "Name must be less than 255 character";
    }

    if (empty($errors) && $id !== false) {
        $sql = "UPDATE categories SET `name` = '$name' WHERE id = $id";

        if(mysqli_query($conn, $sql) == true){
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
