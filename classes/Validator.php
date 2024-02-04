<?php

class Validator
{

    private $errors = [];


    /**
     * check in input is a valid email
     */
    public function email($email)
    {
        if (empty($email)) {
            $this->errors[] =  "Email is required";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] =  "Email is not valid";
        } elseif (strlen($email) > 255) {
            $this->errors[] =  "Maximum email size is 255 chars";
        }
    }

    /**
     * check if valid string (name)
     */
    public function str($str, $inputName, $max = NULL)
    {
        // name:
        if (empty($str)) {
            $this->errors[] =  ucfirst($inputName) . " is required";
        } elseif (!is_string($str) or is_numeric($str)) {
            $this->errors[] =  ucfirst($inputName) . " must be string and cannot contain only numbers";
        } elseif ($max !== NULL and strlen($str) > $max) {
            $this->errors[] =  "Maximum $inputName size is $max chars";
        }
    }

    public function passwordConfirmed($password, $confirm_password, $min, $max)
    {

        if (!empty($password)) {
            // Validate password and passwordConfirm
            if (!is_string($password)) {
                $this->errors[] = "Password must be string";
            } elseif (strlen($password) < $min or strlen($password) > $max) {
                $this->errors[] = "Password lenght between 9 - 60 chracacter";
            } elseif ($password != $confirm_password) {
                $this->errors[] = "Password and Confirm don't match";
            }

            return false;
        }

        return true;
    }

    /**
     * Returns true if $errors is empty
     */
    public function valid()
    {
        if (empty($this->errors)) {
            return true;
        }

        return false;
    }

    /**
     * return $errors array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * setting specific error 
     */
    public function setError($errorString){
       $this->errors[] = $errorString;
    }
    
    /**
     * check if an input is empty
     */
    public function required($input, $inputName)
    {
        if (empty($input)) {
            $this->errors[] = ucfirst($inputName) . " is required!";
        }
    }

    /**
     * validate image
     */

    public function image($error, $ext, $size)
    {
        $allowedExtensions = ['png', 'jpg', 'jpeg'];

        if ($error) {
            $this->errors[] = "Errors uploading the image";
        } elseif (!in_array($ext, $allowedExtensions)) {
            $this->errors[] = "Allowed extensions: png, jpg & jpeg";
        } elseif ($size > 2) {
            $this->errors[] = "Image maximum size is 2MB";
        }
    }


}
