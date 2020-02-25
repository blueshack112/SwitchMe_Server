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

// Insert new state
$getQuery = "DELETE FROM switch_me.tbl_schedule WHERE relay_id = $id;";
$getQueryResult = mysqli_query($conn, $getQuery);
$successful = $getQueryResult;

// TODO: Insert into log tables also!

if ($successful) {
    // Now run update query
    $rightnow = date ('Y-m-d G:i:s');
    $updateQuery = "UPDATE switch_me.tbl_state SET col_state = 'ON', created_at = '$rightnow' WHERE id = $id";
    $updateQueryResult = mysqli_query($conn, $updateQuery);
    $successful = $updateQueryResult;

    // Add to logs table
    $insertQuery = "INSERT INTO switch_me.tbl_log (relay_id, started_at) VALUES ($id, '$rightnow');";
    $insertQueryResult = mysqli_query($conn, $insertQuery);
    
    if ($successful) {
        echo ("done");
    } else {
        echo $updateQuery;
        echo ("none1");
    }
} else {
    echo ("none2");
}
