<?php

include("../global.php");

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
 * ToDo:
 */
if(isset($_GET['id'])){
    $id = $_GET['id'];

    $isDeletd = delete($conn, 'categories', "id = '$id'");

    if($isDeletd){
        $session->set("success", "Category has been deleted");
    }

}

header("location: $url" . "admin/all-categories.php");
die;