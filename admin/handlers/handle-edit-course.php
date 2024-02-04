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

    // Validation
    $validator = new Validator;
    //name: required | string | max:255
    $validator->str($name, "name" , 255);

    //desc: required | string
    $validator->str($desc, "describtion");

    //category_id: required
    $validator->required($category_id, "Category");

    if (!empty($img['name'])) {
        //img: no_errors | available extension | max 2MB
        $imgExtension = pathinfo($imgName, PATHINFO_EXTENSION);
        $imgSizeMb = $imgSize / (1024 ** 2);

        $validator->image($imgError, $imgExtension, $imgSizeMb);
    }

    if ($validator->valid()) {

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
        $session->set('errors', $validator->getErrors());
        header("location: $url" . "admin/edit-course.php?courseId=$id");
        die;
    }
}
