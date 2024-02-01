<?php
include("../../global.php");


if ($request->postHas('submit')) {
    $id = $request->get('id');
    $oldImgName = $request->get('oldImgName');

    $name = $db->evadeSql($request->trimCleanPost('name'));
    $desc = $db->evadeSql($request->trimCleanPost('desc'));
    $category_id = $db->evadeSql($request->trimCleanPost('category_id'));

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
            $newImgPath = "$root/uploads/courses/$imgNewName";

            move_uploaded_file($imgTmpName, $newImgPath);

            $isUpdated = $db->update(
                "courses",
                "`name`='$name', `desc`='$desc', `category_id`=$category_id, img='$imgNewName'",
                "id = $id"
            );
        } else {
            $isUpdated = $db->update(
                "courses",
                "`name`='$name', `desc`='$desc', `category_id`=$category_id",
                "id = $id"
            );
        }

        //sql query
        if ($isUpdated) {
            $session->set('success', "Course updated succesfully");
        } else {
            $session->set('error', "Failed to edit new course!");
            header("location: $url" . "admin/all-courses.php");
            die;
        }


        header("location: $url" . "admin/all-courses.php");
        die;
    } else {
        //if $errors store it in session
        $session->set('errors', $errors);
        header("location: $url" . "admin/edit-course.php?courseId=$id");
        die;
    }
}
