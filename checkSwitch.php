<?php
header("Content-type:application/json");
$_SERVER['CONTENT_TYPE'] = "application/x-www-form-urlencoded";
error_reporting(E_ALL ^ E_WARNING && E_NOTICE);

//Connection properties 
$servername = "localhost";
$username = "ebad";
$password = "ebad";
$dbName = "switch_me";

//Create connection
$conn = new mysqli($servername, $username, $password, $dbName);

//Extract data from POST
$id = $_POST["id"];

// Update new state
$selectQuery = "SELECT (col_state) FROM switch_me.tbl_state WHERE id = $id";
$selectQueryResult = mysqli_query($conn, $selectQuery);


$successful = $selectQueryResult;

if ($selectQueryResult) {
    $row = mysqli_fetch_assoc($selectQueryResult);
    $colState = $row['col_state'];
    echo ($colState);
} else {
    echo ("OFF");
}
