<?php
session_start();

include("../inc/functions.php");

$conn = dbconnect();

// dd($_POST);

if (isset($_POST['submit'])) {
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

    if (empty($errors)) {
        $sql = "INSERT INTO categories(name)
        VALUES ('$name')";

        if(mysqli_query($conn, $sql) == true){
            //redirect with success
            $_SESSION['success'] = "Category added succesfully";
        }

        mysqli_close($conn);

        header('location: ../all-categories.php');
        die;
    }else{
        //store $errors in session
        $_SESSION['errors'] = $errors;
        header('location: ../add-category.php');
    }

}
