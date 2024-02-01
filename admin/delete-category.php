<?php

include("../global.php");

/**
 * ToDo:
 */
if($request->getHas('id')){
    $id = $request->get('id');

    $isDeletd = $db->delete('categories', "id = '$id'");

    if($isDeletd){
        $session->set("success", "Category has been deleted");
    }

}

header("location: $url" . "admin/all-categories.php");
die;