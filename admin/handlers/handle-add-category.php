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

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, trim(htmlspecialchars($_POST['name'])));

    //validation 
    $errors = [];

    //name: required | string | max:255
    $errors[] = validateName($name);

    $errors = cleanErrors($errors);

    if (empty($errors)) {
        $sql = "INSERT INTO categories(name)
        VALUES ('$name')";

            $isInserted = insert(
            $conn,
            "categories",
            "`name`",
            "'$name'"
        );

        if($isInserted){
            //redirect with success
            $_SESSION['success'] = "Category added succesfully";
        }

        mysqli_close($conn);

        header('location: ../all-categories.php');
        die;
    }else{
        //store $errors in session
        $_SESSION['errors'] = $errors;
        header("location: $url" . "admin/add-category.php");
    }

}
