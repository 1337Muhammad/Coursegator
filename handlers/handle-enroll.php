<?php

session_start();

include("../global.php");
include("$root/inc/functions.php");

$conn = dbconnect();

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
    if(empty($name)){
        $errors[] = "Name is required!";
    }elseif(! is_string($name) or is_numeric($name) or strlen($name) > 255 or strlen($name) < 3){
        $errors[] = "Invalid name!";
    }

    //email: required | email | max:255
        if(empty($email)){
        $errors[] = "Email is required!";
    }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL) or strlen($email) > 255){
        $errors[] = "Invalid email!";
    }

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


    if(empty($errors)){
        //isnert data into db
        $sql = "INSERT INTO reservations (`name`, email, phone, speciality, course_id)
        VALUES ('$name', '$email', '$phone', '$spec', '$course_id')";

        // dd(var_export(mysqli_query($conn, $sql)));

        if(mysqli_query($conn, $sql)){
            $_SESSION['success']= "Enrolled Successfuly";
        }else{
            // Mustn't happens in production..
            $_SESSION['queryError'] = "Error inserting into db !!!";
        }


        //redirect with success msg
    }else{
        //store errors in session
        $_SESSION['errors'] = $errors;
        //redirect with error msg
    }

    header('location: /enroll.php');
    die;

}

// header('location: /');
