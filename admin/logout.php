<?php

require_once('../global.php');

session_destroy();

header("location: $url" . "admin/login.php");
die;