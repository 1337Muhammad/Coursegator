<?php
session_start();

include("../../global.php");
include("$root/admin/inc/functions.php");

$conn = dbconnect();

// dd($_POST);

if (isset($_POST['submit'])) {
    $id = $_GET['id'];
    $oldImgName = $_GET['oldImgName'];

    $name = mysqli_real_escape_string($conn, trim(htmlspecialchars($_POST['name'])));
    $desc = mysqli_real_escape_string($conn, trim(htmlspecialchars($_POST['desc'])));
    $category_id = mysqli_real_escape_string($conn, trim(htmlspecialchars($_POST['category_id'])));

    $img = $_FILES['img'];
    if (!empty($img['name'])) {
        $imgName = $img['name'];
        $imgType = $img['type'];
        $imgTmpName = $img['tmp_name'];
        $imgError = $img['error'];
        $imgSize = $img['size'];
    }

    //validation 
    $errors = [];

    //name: required | string | max:255
    if (empty($name)) {
        $errors[] = "Name is required!";
    } elseif (!is_string($name)) {
        $errors[] = "Name must be string";
    } elseif (strlen($name) > 255) {
        $errors[] = "Name must be less than 255 character";
    }

    //desc: required | string
    if (empty($desc)) {
        $errors[] = "Description is required!";
    } elseif (!is_string($desc)) {
        $errors[] = "Description must be string";
    }

    //category_id: required
    if (empty($category_id)) {
        $errors[] = "Category is required!";
    }

    if (!empty($img['name'])) {
        //img: no_errors | available extension | max 2MB
        $allowedExtensions = ['png', 'jpg', 'jpeg'];
        $imgExtension = pathinfo($imgName, PATHINFO_EXTENSION);
        $imgSizeMb = $imgSize / (1024 ** 2);

        if ($imgError) {
            $errors[] = "Errors uploading the image";
        } elseif (!in_array($imgExtension, $allowedExtensions)) {
            $errors[] = "Allowed extensions: png, jpg & jpeg";
        } elseif ($imgSizeMb > 2) {
            $errors[] = "Image maximum size is 2MB";
        }
    }

    if (empty($errors)) {

        if (!empty($img['name'])) {
            //upload image
            unlink("../../uploads/courses/$oldImgName");
            $randStr = uniqid() . "_" . $category_id;
            $imgNewName = "$randStr.$imgExtension";
            // dd($imgNewName);
            move_uploaded_file($imgTmpName, "../../uploads/courses/$imgNewName");


            $sql = "UPDATE courses SET `name`='$name', `desc`='$desc', `category_id`=$category_id, img='$imgNewName'
                WHERE id = $id";

        } else {
            $sql = "UPDATE courses SET `name`='$name', `desc`='$desc', `category_id`=$category_id
                WHERE id = $id";
        }

        //sql query
        if (mysqli_query($conn, $sql) == true) {
            $_SESSION['success'] = "Course updated succesfully";
            mysqli_close($conn);
        } else {
            $_SESSION['error'] = "Failed to edit new course!";
            mysqli_close($conn);
            header('location: ../all-courses.php');
            die;
        }


        header('location: ../all-courses.php');
        die;
    } else {
        //if $errors store it in session
        $_SESSION['errors'] = $errors;
        header("location: ../edit-course.php?courseId=$id");
        die;
    }
}
