<?php

session_start();

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

// dd($_POST['name']);

if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($conn, trim(htmlspecialchars($_POST['name'])));
    $email = mysqli_real_escape_string($conn, trim(htmlspecialchars($_POST['email'])));
    $phone = mysqli_real_escape_string($conn, trim(htmlspecialchars($_POST['phone'])));
    $spec = mysqli_real_escape_string($conn, trim(htmlspecialchars($_POST['spec'])));

    $course_id = mysqli_real_escape_string($conn, trim(htmlspecialchars($_POST['course_id'])));

    //validation 
    $errors = [];

    //name: required | string non numeric | max:255
    $errors[] = validateName($name);

    //email: required | email | max:100
    $errors[] = validateEmail($email);


    //phone: required | string | max:255
    if(empty($phone)){
        $errors[] = "Phone is required!";
    }elseif(! is_string($phone) or strlen($phone) > 255 or strlen($phone) < 8){
        $errors[] = "Invalid phone number! <i>Format: +20123456789</i>";
    }

    //spec: string | max:255
    if(!empty($spec)){
        if(! is_string($spec) or is_numeric($spec) or strlen($spec) > 255){
            $errors[] = "Invalid Specialisation!"; 
        }
    }

    //course_id: required | [in:courses.id]
    $sql = "SELECT id FROM courses WHERE id = $course_id";
    $result = mysqli_query($conn, $sql);
    if(empty($course_id) or mysqli_num_rows($result) != 1){
        $errors[] = "Invalid course selection!";
    }

    $errors = cleanErrors($errors);

    // dd($errors);
    if(empty($errors)){
        //isnert data into db
        $isInserted = insert(
            $conn,
            "reservations",
            "`name`, email, phone, speciality, course_id",
            "'$name', '$email', '$phone', '$spec', '$course_id'"
        );

        if($isInserted){
            $_SESSION['success']= "Enrolled Successfuly";
        }else{
            // JUSTiNcASE
            $_SESSION['queryError'] = "Error inserting into db !!!";
        }

    }else{
        //store errors in session
        $_SESSION['errors'] = $errors;
    }

    header("location: $url" . "enroll.php");
    die;

}