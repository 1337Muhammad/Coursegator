<?php

session_start();

include('inc/functions.php');

$conn = dbconnect();

/**
 * ToDo:
 */
if(isset($_GET['id'])){
    $id = $_GET['id'];

    $oldImgName = $_GET['oldImgName'];
    unlink("../uploads/courses/$oldImgName");

    $sql = "DELETE FROM courses WHERE id = $id";

    if(mysqli_query($conn, $sql)){
        $_SESSION['success'] = "Course has been deleted";
    }

}

header('location: all-courses.php');
die;