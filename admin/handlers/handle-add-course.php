<?php
session_start();

include("../../global.php");
include("$root/admin/inc/functions.php");

$conn = dbconnect();

// dd($_POST);

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, trim(htmlspecialchars($_POST['name'])));
    $desc = mysqli_real_escape_string($conn, trim(htmlspecialchars($_POST['desc'])));
    $category_id = mysqli_real_escape_string($conn, trim(htmlspecialchars($_POST['category_id'])));

    $img = $_FILES['img'];

    $imgName = $img['name'];
    $imgType = $img['type'];
    $imgTmpName = $img['tmp_name'];
    $imgError = $img['error'];
    $imgSize = $img['size'];

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

    //img: required | no_errors | available extension | max 2MB
    $allowedExtensions = ['png', 'jpg', 'jpeg'];
    $imgExtension = pathinfo($imgName, PATHINFO_EXTENSION);
    $imgSizeMb = $imgSize / (1024 ** 2);

    if ($imgError) {
        $errors[] = "Errors uploading the image";
    } elseif (!in_array($imgExtension, $allowedExtensions)) {
        $errors[] = "Allowed extensions: png, jpg & jpeg";
    } elseif ($imgSizeMb > 2) {
        $errors[] = "Image maximum size is 2MB";
    }elseif(empty($img['name'])){
        $errors[] = "Image is required";
    }

    if (empty($errors)) {
        //upload image
        $randStr = uniqid() . "_" . $category_id;
        $imgNewName = "$randStr.$imgExtension";
        // dd($imgNewName);

        $uploaded = move_uploaded_file($imgTmpName, "$url/uploads/courses/$imgNewName");

        if ($uploaded) {
            //insert into db
            $sql = "INSERT INTO courses (`name`, `desc`, `category_id`, `img`)
            VALUES ('$name', '$desc', '$category_id', '$imgNewName')";

            if (mysqli_query($conn, $sql) == true) {
                //redirect with success
                $_SESSION['success'] = "Course added succesfully";
            } else {
                $_SESSION['error'] = "Failed to add new course!";
                header("location: $url" . "admin/all-courses.php");
                die;
                mysqli_close($conn);
            }
        }


        header("location: $url" . "admin/all-courses.php");
        die;
    } else {
        //store $errors in session
        $_SESSION['errors'] = $errors;
        header("location: $url" . "admin/add-course.php");
    }
}
