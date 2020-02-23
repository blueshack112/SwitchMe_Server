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
$id = $_POST["id"];

// Truncate table
if ($state == "OFF") {
$truncateQuery = "UPDATE switch_me.tbl_state SET col_state = 'OFF', created_at = '$time' WHERE id = $id";
$truncateQueryResult = mysqli_query($conn, $truncateQuery);
if ($truncateQueryResult) {
    echo (json_encode($id));

//    echo (json_encode([$successful = true]));
} else {
    echo (json_encode($truncateQuery));
//    echo (json_encode([$successful = false]));
}

} else {
// Insert new state
$insertQuery = "UPDATE switch_me.tbl_state SET col_state = 'ON', created_at = '$time' WHERE id = $id";
$insertQueryResult = mysqli_query($conn, $insertQuery);

if ($insertQueryResult) {
    echo (json_encode($id));
//    echo (json_encode([$successful = true]));
} else {
    echo (json_encode($truncateQuery));
//    echo (json_encode([$successful = false]));
}
}