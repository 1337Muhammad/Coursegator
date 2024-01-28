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

// Database
// this function tells if data inserted or not
function insert($conn, $table, $fields, $values){
    $sql = "INSERT INTO $table ($fields) VALUES ($values)";
    $isInserted = mysqli_query($conn, $sql);
    return $isInserted;
}

function update($conn, $table, $set, $condition){
    $sql = "UPDATE $table SET $set WHERE $condition";
    $isUpdated = mysqli_query($conn, $sql);
    return $isUpdated;
}

    // ToDo handle when deleting a parent row
function delete($conn, $table, $condition){
    $sql = "DELETE FROM $table WHERE $condition";
    // dd($sql);
    $isDeleted = mysqli_query($conn, $sql);
    return $isDeleted;
}

function select($conn, $fields, $table, $others = NULL){ // expandable query

    $sql = "SELECT $fields FROM $table";
    // if others default value changed from NULL to a condition we will concatenate it to query
    if($others !== NULL){
        $sql .= " $others";
    }

    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result)>0){
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }else{
        $rows = [];
    }
    return $rows;
}

function selectOne($conn, $fields, $table, $others = NULL){

    $sql = "SELECT $fields FROM $table";
    if($others !== NULL){
        $sql .= " $others";
    }
    $sql .= " LIMIT 1"; //to ensure that we always get 1 result
    // dd($sql);
    //ToDo: dont show error to user instead log it in a file for later dbugging
    $result = mysqli_query($conn, $sql) or die( "An error occurred. Please try again later: " . mysqli_error($conn));
    // if (!$result) {
    // echo "An error occurred. Please try again later.";
    // }
    // dd(mysqli_fetch_assoc($result)); 

    if(mysqli_num_rows($result)>0){
        $row = mysqli_fetch_assoc($result);
    }else{
        $row = [];
    }
    return $row;
}

function selectJoin($conn, $fields, $tables, $on, $others = NULL){

    $sql = "SELECT $fields FROM $tables ON $on";
    if($others !== NULL){
        $sql .= " $others";
    }
    
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result)>0){
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }else{
        $rows = [];
    }
    return $rows;
}

function selectJoinOne($conn, $fields, $tables, $on, $others = NULL){

    $sql = "SELECT $fields FROM $tables ON $on";
    if($others !== NULL){
        $sql .= " $others";
    }
    $sql .= " LIMIT 1";
    
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result)>0){
        $row = mysqli_fetch_assoc($result);
    }else{
        $row = [];
    }
    return $row;
}