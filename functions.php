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


