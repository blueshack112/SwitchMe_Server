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

//Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//Extract data from POST
$state = $_POST["state"];
$time = $_POST["time"];

// Truncate table
$truncateQuery = "TRUNCATE TABLE switch_me.tbl_state";
$truncateQueryResult = mysqli_query($conn, $truncateQuery);

// Insert new state
$insertQuery = "INSERT INTO switch_me.tbl_state (col_state, created_at) values ('$state', '$time')";
$insertQueryResult = mysqli_query($conn, $insertQuery);

if ($insertQueryResult) {
    echo (json_encode([$successful = true]));
} else {
    echo (json_encode([$successful = false]));
}