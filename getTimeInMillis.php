<?php
header("Content-type:application/json");
$_SERVER['CONTENT_TYPE'] = "application/x-www-form-urlencoded";
error_reporting(E_ALL ^ E_WARNING && E_NOTICE);
date_default_timezone_set("Asia/Karachi");

$milliseconds = time() * 1000;
echo ($milliseconds);