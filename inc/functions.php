<?php 

/**
 * pretty print & die
 */
function dd($var){
    echo "<pre>";
    print_r($var);
    echo "</pre>";
    die();
}

/**
 * santitized user get request parameter and return it
 */
function getSanitized($var){
    echo "";
}

function dbconnect(){
        
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "coursegator";

    /**
     * ToDo: Handle if errors happened connecting to db
     */
    $conn = mysqli_connect($servername, $username, $password, $dbname) ?? mysqli_connect_error();
    //Check Connection
    if(!$conn){
        die("Connection failed: " . mysqli_connect_error());
    }

    return $conn;
}