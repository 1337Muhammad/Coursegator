<?php

class Request{
    /**
     * Return Get parameter from get request
     */
    public function get($key){
       return $_GET[$key];
    }

    /**
     * Check if a $key parameter exist in a get request
     */
    public function getHas($key){
       return isset($_GET[$key]);
    }

    /**
     * Return Post parameter from post request
     */
    public function post($key){
       return $_POST[$key];
    }

    /**
     * Check if a $key parameter exist in a post request
     */
    public function postHas($key){
       return isset($_POST[$key]);
    }

    /**
     * return cleaned $key from POST request to protect from XSS attacks
     */
    public function trimCleanPost($key){
       return trim(htmlspecialchars($_POST[$key]));
    }
}