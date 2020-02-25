<?php
header("Content-type:application/json");
$_SERVER['CONTENT_TYPE'] = "application/x-www-form-urlencoded";
error_reporting(E_ALL ^ E_WARNING && E_NOTICE);
date_default_timezone_set("Asia/Karachi");

// Connection properties 
$servername = "localhost";
$username = "ebad";
$password = "ebad";
$dbName = "switch_me";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Extract data from POST
$id = $_POST["id"];

// Get schedule
$getQuery = "SELECT start_time FROM switch_me.tbl_schedule WHERE relay_id = $id;";
$getQueryResult = mysqli_query($conn, $getQuery);
$successful = $getQueryResult;

if ($successful) {
    $numRows = mysqli_num_rows($getQueryResult);
    if ($numRows > 0) {
        $row = mysqli_fetch_assoc($getQueryResult);

        $startTime = strtotime($row['start_time']);
        $rightNow = time();

        if ($rightNow >= $startTime) {
            echo ("yes");
        } else {
            echo ("no");
        }
    } else {
        echo ("none");
    }
} else {
    echo ("none");
}
