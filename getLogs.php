<?php
header("Content-type:application/json");
$_SERVER['CONTENT_TYPE'] = "application/x-www-form-urlencoded";
error_reporting(E_ALL ^ E_WARNING && E_NOTICE);

// Logs class
class LogItem {
    var $roomID;
    var $energyUsed;
    var $startedAt;
    var $endedAt;

    function __construct()
    {
        $this->roomID = '';
        $this->energyUsed = '';
        $this->startedAt = '';
        $this->endedAt = '';
    }
}

// Response class
class Response
{
    var $successful;
    var $logs;

    function __construct()
    {
        $this->successful = false;
        $this->logs = array();
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

// Get logs
$getQuery = "SELECT * FROM switch_me.tbl_log WHERE transaction_status = 'complete';";
$getQueryResult = mysqli_query($conn, $getQuery);
$numberOfRows = mysqli_num_rows($getQueryResult);

$response = new Response();
if ($numberOfRows >= 1) {
    $response->successful = true;
    while ($row = mysqli_fetch_assoc($getQueryResult)) {
        $temp = new LogItem;
        $temp->roomID = $row['relay_id'];
        $temp->energyUsed = $row['energy_usage'];
        $temp->startedAt = $row['started_at'];
        $temp->endedAt = $row['ended_at'];
        
        $response->logs[] = $temp;
    }
    echo (json_encode($response));
} else {
    $response->logs[] = $getQuery;
    echo (json_encode($response));
}