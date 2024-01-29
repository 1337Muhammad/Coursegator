<?php
session_start();

include("../../global.php");

// start connecting to db
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "coursegator";
// create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// dd($_POST);

if ($request->postHas('submit')) {
    $id = $request->get('id');
    $oldImgName = $_GET['oldImgName'];

    $name = mysqli_real_escape_string($conn, $request->trimCleanPost('name'));
    $desc = mysqli_real_escape_string($conn, $request->trimCleanPost('desc'));
    $category_id = mysqli_real_escape_string($conn, $request->trimCleanPost('category_id'));

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
    $errors[] = validateName($name);

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

    $errors = cleanErrors($errors);

    if (empty($errors)) {

        if (!empty($img['name'])) {
            //upload image
            unlink("../../uploads/courses/$oldImgName");
            $randStr = uniqid() . "_" . $category_id;
            $imgNewName = "$randStr.$imgExtension";
            // dd($imgNewName);
            move_uploaded_file($imgTmpName, "../../uploads/courses/$imgNewName");


            // $sql = "UPDATE courses SET `name`='$name', `desc`='$desc', `category_id`=$category_id, img='$imgNewName'
            //     WHERE id = $id";

            $isUpdated = update(
                $conn,
                "courses",
                "`name`='$name', `desc`='$desc', `category_id`=$category_id, img='$imgNewName'",
                "id = $id"
            );
        } else {
            // $sql = "UPDATE courses SET `name`='$name', `desc`='$desc', `category_id`=$category_id
            //     WHERE id = $id";
            $isUpdated = update(
                $conn,
                "courses",
                "`name`='$name', `desc`='$desc', `category_id`=$category_id",
                "id = $id"
            );
        }

        //sql query
        if ($isUpdated) {
            $_SESSION['success'] = "Course updated succesfully";
            mysqli_close($conn);
        } else {
            $_SESSION['error'] = "Failed to edit new course!";
            mysqli_close($conn);
            header("location: $url" . "admin/all-courses.php");
            die;
        }


        header("location: $url" . "admin/all-courses.php");
        die;
    } else {
        //if $errors store it in session
        $_SESSION['errors'] = $errors;
        header("location: $url" . "admin/edit-course.php?courseId=$id");
        die;
    }
}
