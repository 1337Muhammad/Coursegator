<?php
include("../../global.php");

// for validation 
$errors = [];

if ($request->postHas('submit')) {

    $name = $db->evadeSql($request->trimCleanPost('name'));
    $desc = $db->evadeSql($request->trimCleanPost('desc'));
    $category_id = $db->evadeSql($request->trimCleanPost('category_id'));

    $img = $_FILES['img'];

    $imgName = $img['name'];
    $imgType = $img['type'];
    $imgTmpName = $img['tmp_name'];
    $imgError = $img['error'];
    $imgSize = $img['size'];

    // Validation
    $validator = new Validator;
    //name: required | string | max:255
    $validator->str($name, "name" , 255);

    //desc: required | string
    $validator->str($desc, "describtion");

    //category_id: required
    $validator->required($category_id, "Category");

    //img: required | no_errors | available extension | max 2MB
    $allowedExtensions = ['png', 'jpg', 'jpeg'];
    $imgExtension = pathinfo($imgName, PATHINFO_EXTENSION);
    $imgSizeMb = $imgSize / (1024 ** 2);

    // image validation
    $validator->image($imgError, $imgExtension, $imgSizeMb);

    if ($validator->valid()) {
        //upload image
        $randStr = uniqid() . "_" . $category_id;
        $imgNewName = "$randStr.$imgExtension";
        $newImgPath = "$root/uploads/courses/$imgNewName";
        // dd($imgNewName);

        $uploaded = move_uploaded_file($imgTmpName, $newImgPath);
        if ($uploaded) {
            //insert into db
            $isInserted = $db->insert(
                "courses",
                "`name`, `desc`, `category_id`, `img`",
                "'$name', '$desc', '$category_id', '$imgNewName'"
            );

            if ($isInserted) {
                //redirect with success
                $session->set("success", "Course added succesfully");
            } else {
                $session->set("error", "Failed to add new course!");
                header("location: $url" . "admin/all-courses.php");
                die;
            }
        }

        header("location: $url" . "admin/all-courses.php");
        die;
    }
}else{
    // no "submit" sent
    $errors = ['Ops! Please Try Again'];
}
//store $errors in session
$session->set('errors', $validator->getErrors());
header("location: $url" . "admin/add-course.php");
die;