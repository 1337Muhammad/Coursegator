<?php
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

// for validation 
$errors = [];

if ($request->postHas('submit')) {

    $name = mysqli_real_escape_string($conn, $request->trimCleanPost('name'));
    $desc = mysqli_real_escape_string($conn, $request->trimCleanPost('desc'));
    $category_id = mysqli_real_escape_string($conn, $request->trimCleanPost('category_id'));

    $img = $_FILES['img'];

    $imgName = $img['name'];
    $imgType = $img['type'];
    $imgTmpName = $img['tmp_name'];
    $imgError = $img['error'];
    $imgSize = $img['size'];

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
    } elseif (empty($img['name'])) {
        $errors[] = "Image is required";
    }

    $errors = cleanErrors($errors);

    if (empty($errors)) {
        //upload image
        $randStr = uniqid() . "_" . $category_id;
        $imgNewName = "$randStr.$imgExtension";
        // dd($imgNewName);

        $uploaded = move_uploaded_file($imgTmpName, "$root"."/uploads/courses/$imgNewName");
        if ($uploaded) {
            //insert into db
            $isInserted = insert(
                $conn,
                "courses",
                "`name`, `desc`, `category_id`, `img`",
                "'$name', '$desc', '$category_id', '$imgNewName'"
            );

            if ($isInserted) {
                //redirect with success
                $session->set("success", "Course added succesfully");
            } else {
                $session->set("error", "Failed to add new course!");
                mysqli_close($conn);
                header("location: $url" . "admin/all-courses.php");
                die;
            }
        }

        mysqli_close($conn);
        header("location: $url" . "admin/all-courses.php");
        die;
    }
}else{
    // no "submit" sent
    $errors = ['Ops! Please Try Again'];
}
//store $errors in session
$session->set('errors', $errors);
mysqli_close($conn);
header("location: $url" . "admin/add-course.php");
die;