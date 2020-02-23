<?php
header("Content-type:application/json");
$_SERVER['CONTENT_TYPE'] = "application/x-www-form-urlencoded"; 
error_reporting (E_ALL ^ E_WARNING && E_NOTICE);

//Connection properties 
$servername = "localhost";
$username = "ebad";
$password = "ebad";
$dbName = "switch_me";

//Create connection
$conn = new mysqli($servername, $username, $password, $dbName);

echo "HELLO!";