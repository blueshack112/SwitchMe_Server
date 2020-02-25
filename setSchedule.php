<?php
header("Content-type:application/json");
$_SERVER['CONTENT_TYPE'] = "application/x-www-form-urlencoded";
error_reporting(E_ALL ^ E_WARNING && E_NOTICE);
date_default_timezone_set("Asia/Karachi");

// Response class
class Response
{
    var $successful;
    var $error;


    function __construct()
    {
        $this->successful = false;
        $this->error = "none";
    }
}

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
$datetime = $_POST["datetime"];

// Check if time has passed
$rightnow = date ('Y-m-d G:i:s');
$rightNowInMillis = strtotime($rightnow);
$datetimeInMillis = strtotime($datetime);

if ($rightNowInMillis > $datetimeInMillis) {
    $response = new Response();
    $response->error = "The time you are trying to set has passed.";
    echo (json_encode($response));
    return;
}


// Check if schedule already exists
// If exists, update it, if not, add new
$selectQuery = "SELECT * FROM switch_me.tbl_schedule WHERE relay_id = $id;";
$selectQueryResult = mysqli_query($conn, $selectQuery);
$numRows = mysqli_num_rows($selectQueryResult);

// Schedule doesn't exist
if ($numRows === 0) {
    $insertQuery = "INSERT INTO switch_me.tbl_schedule (`relay_id`, `start_time`) VALUES ($id,'$datetime');";
    $insertQueryResult = mysqli_query($conn, $insertQuery);
    if ($insertQueryResult) {
        $response = new Response();
        $response->successful = true;
        echo (json_encode($response));
    } else {
        $response = new Response();
        $response->error = mysqli_error($conn);
        echo (json_encode($response));
    }
} else {
    $updateQuery = "UPDATE switch_me.tbl_schedule SET start_time = '$datetime' WHERE relay_id =  $id;";
    $updateQueryResult = mysqli_query($conn, $updateQuery);
    if ($updateQueryResult) {
        $response = new Response();
        $response->successful = true;
        echo (json_encode($response));
    } else {
        $response = new Response();
        $response->error = mysqli_error($conn);
        echo (json_encode($response));
    }
}