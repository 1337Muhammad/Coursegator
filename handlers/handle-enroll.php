<?php
include("../global.php");


if ($request->postHas('submit')) {

    $name = $db->evadeSql($request->trimCleanPost('name'));
    $email = $db->evadeSql($request->trimCleanPost('email'));
    $phone = $db->evadeSql($request->trimCleanPost('phone'));
    $spec = $db->evadeSql($request->trimCleanPost('spec'));

    $course_id = $db->evadeSql($request->trimCleanPost('course_id'));

    //validation 
    $validator = new Validator;

    //name: required | string non numeric | max:255
    $errors[] = $validator->str($name, "name", 255);

    //email: required | email | max:100
    $errors[] = $validator->email($email);

    //phone: required | string | max:255
    if (empty($phone)) {
        $errors[] = "Phone is required!";
    } elseif (!is_string($phone) or strlen($phone) > 255 or strlen($phone) < 8) {
        $errors[] = "Invalid phone number! <i>Format: +20123456789</i>";
    }

    //Phone validation
    //Todo
    $validator->required($phone, "phone");
    if (!is_string($phone) or strlen($phone) > 255 or strlen($phone) < 7) {
        $validator->setError("Invalid phone number! <i>Format: +20123456789</i>");
    }

    //spec: string | max:255
    if (!empty($spec)) {
        if (!is_string($spec) or is_numeric($spec) or strlen($spec) > 255) {
            $validator->setError("Invalid Specialisation!");
        }
    }
    // $validator->str($spec, "Specializaion", 255);

    //course_id: required | [in:courses.id]
    $sql = "SELECT id FROM courses WHERE id = $course_id";
    $result = mysqli_query($db->getConn(), $sql);
    if (empty($course_id) or mysqli_num_rows($result) != 1) {
        $validator->setError("Invalid course selection!");
    }
    // $row = $db->selectOne(
    //     "id",
    //     "courses",
    //     "WHERE id = $course_id"
    // );


    // dd($errors);
    if ($validator->valid()) {
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
    
}

//store errors in session
$session->set('errors', $validator->getErrors());
header("location: $url" . "enroll.php");
die;
