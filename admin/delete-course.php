<?php

include('../global.php');

/**
 * ToDo: take the image not from the url but the db
 */
if($request->getHas('id')){
    $id = $request->get('id');

    $isDeletd = $db->delete('courses', "`id` = '$id'");
    if($isDeletd){
        $session->set("success", "Course has been deleted");

        // delete image file
        $del = false;
        $oldImgName = $_GET['oldImgName'];
        $oldImgName = $request->get('oldImgName');
        if(file_exists("$root/uploads/courses/$oldImgName")){
            $del = unlink("$root/uploads/courses/$oldImgName");
        }
    }

}

header("location: $url" . "admin/all-courses.php");
die;