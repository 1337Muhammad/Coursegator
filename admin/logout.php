<?php

require_once('../global.php');

$session->destroy();

header("location: $url" . "login.php");
die;