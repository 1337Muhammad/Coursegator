<?php

include 'functions.php';

// Absolute path
$root = __DIR__;

// Absolute url for (imgs / css / js ) files
$url = "http://localhost/";

// classes
require_once("$root" . "/classes/Request.php");
require_once("$root" . "/classes/Session.php");
require_once("$root" . "/classes/Db.php");
require_once("$root" . "/classes/Validator.php");


// objects
$request = new Request;
$session = new Session;
$db = new Db("localhost", "root", "", "coursegator");