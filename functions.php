<?php 

/**
 * pretty print & die
 */
function dd($var){
    echo "<pre>";
    print_r($var);
    echo "</pre>";
    die();
}

/**
 * santitized user get request parameter and return it
 */
function getSanitized($var){
    return $var;
}

// Validation functions
// email:
function validateEmail($email){
    if(empty($email)){
        return "Email is required";
    }elseif(! filter_var($email, FILTER_VALIDATE_EMAIL)){
        return "Email is not valid";
    }elseif(strlen($email)>255){
        return "Maximum email size is 255 chars";
    }
}

/**
 * some null values get inserted to $errors array during validation process so:
 * cleaning $errors array from null values before performing sql query
 */
function cleanErrors($errors){
    foreach($errors as $index=>$error){
        if($error == null){
            unset($errors[$index]);
        }
    }
    return $errors;
}

function validateName($name){
    // name:
    if(empty($name)){
        return "Name is required";
    }elseif(!is_string($name) or is_numeric($name)){
        return "Name must be string and cannot contain only numbers";
    }elseif(strlen($name)>255){
        return "maximum name size is 255 chars";
    }
}

