<?php

include('../global.php');

// dd("$root/functions.php");

// include("$root/functions.php");

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

/**
 * ToDo: take the image not from the url but the db
 */
if(isset($_GET['id'])){
    $id = $_GET['id'];

    $isDeletd = delete($conn, 'courses', "`id` = '$id'");
    if($isDeletd){
        $session->set("success", "Course has been deleted");

        // delete image file
        $del = false;
        $oldImgName = $_GET['oldImgName'];
        if(file_exists("$root/uploads/courses/$oldImgName")){
            $del = unlink("$root/uploads/courses/$oldImgName");
        }
    }

}

header("location: $url" . "admin/all-courses.php");
die;