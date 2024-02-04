<?php
include("../../global.php");

if ($request->postHas('submit')) {
    $id = $request->getHas('id') ? $request->get('id') : false;

    $name = $db->evadeSql($request->trimCleanPost('name'));

    //validation 

    $validator = new Validator;
    //name: required | string | max:255
    $errors[] = $validator->str($name, "Name", 255);

    if ($validator->valid() && $id !== false) {
        
        $isUpdated = $db->update(
            "categories",
            "`name` = '$name'",
            "id = $id"
        );

        if($isUpdated){
            //redirect with success
            $session->set('success', "Category updated.");
        }

        header("location: $url" . "admin/all-categories.php");
        die;
    }else{
        //store $errors in session
        $session->set('errors', $validator->getErrors());
        header("location: $url" . "admin/edit-category.php?id=$id");
        die;
    }

// // //                                  haaqqqAAAAaAaAaAaAaaAaAaAZ                // // //

}
