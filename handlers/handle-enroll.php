<?php
include("../global.php");


if ($request->postHas('submit')) {

    $name = $db->evadeSql($request->trimCleanPost('name'));
    $email = $db->evadeSql($request->trimCleanPost('email'));
    $phone = $db->evadeSql($request->trimCleanPost('phone'));
    $spec = $db->evadeSql($request->trimCleanPost('spec'));

    $course_id = $db->evadeSql($request->trimCleanPost('course_id'));

    //validation 
    $errors = [];

    //name: required | string non numeric | max:255
    $errors[] = validateName($name);

    //email: required | email | max:100
    $errors[] = validateEmail($email);

    //phone: required | string | max:255
    if (empty($phone)) {
        $errors[] = "Phone is required!";
    } elseif (!is_string($phone) or strlen($phone) > 255 or strlen($phone) < 8) {
        $errors[] = "Invalid phone number! <i>Format: +20123456789</i>";
    }

    //spec: string | max:255
    if (!empty($spec)) {
        if (!is_string($spec) or is_numeric($spec) or strlen($spec) > 255) {
            $errors[] = "Invalid Specialisation!";
        }
    }

    //course_id: required | [in:courses.id]
    $sql = "SELECT id FROM courses WHERE id = $course_id";
    $result = mysqli_query($db->getConn(), $sql);
    if (empty($course_id) or mysqli_num_rows($result) != 1) {
        $errors[] = "Invalid course selection!";
    }

    $errors = cleanErrors($errors);

    // dd($errors);
    if (empty($errors)) {
        //isnert data into db
        $isInserted = $db->insert(
            "reservations",
            "`name`, email, phone, speciality, course_id",
            "'$name', '$email', '$phone', '$spec', '$course_id'"
        );

        if ($isInserted) {
            $session->set("success", "Enrolled Successfuly");
        } else {
            // JUSTiNcASE
            $session->set("queryError", "Error inserting into db !");
        }
    }
    
}else{
    // error on 'submit'
    $errors = ['Ops! Please Try Again'];
}

//store errors in session
$session->set('errors', $errors);
header("location: $url" . "enroll.php");
die;
