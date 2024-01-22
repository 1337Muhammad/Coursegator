<?php

session_start();

include('inc/functions.php');

$conn = dbconnect();

/**
 * ToDo:
 */
if(isset($_GET['id'])){
    $id = $_GET['id'];

    $sql = "DELETE FROM categories WHERE id = $id";

    if(mysqli_query($conn, $sql)){
        $_SESSION['success'] = "Category has been deleted";
    }

}

header('location: all-categories.php');
die;