<?php

class Session
{
    public function __construct() {
        session_start();
    }

    /**
     * Set $key = $value on $_SESSION
     */
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Get $value stored in $_SESSION using $key
     */
    public function get($key)
    {
        return $_SESSION[$key];
    }

    /**
     * Check if a $key exists in $_SESSION
     */
    public function has($key)
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Remove a $key from $_SESSION
     */
    public function remove($key){
       unset($_SESSION[$key]);
    }


}
