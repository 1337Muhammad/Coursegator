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
if(!$conn){
    die("Connection failed: ".mysqli_connect_error());
}

// dd($_POST);

if ($request->postHas('submit')) {

    $name = mysqli_real_escape_string($conn, $request->trimCleanPost('name'));

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
            $session->set('success', "Category added succesfully");
        }

        mysqli_close($conn);
        header('location: ../all-categories.php');
        die;
    }
}else{
    $errors = ['Ops! Please Try Again'];
}

//store $errors in session
$session->set('errors', $errors);
mysqli_close($conn);
header("location: $url" . "admin/add-category.php");
die;