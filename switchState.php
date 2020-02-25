<?php
header("Content-type:application/json");
$_SERVER['CONTENT_TYPE'] = "application/x-www-form-urlencoded";
error_reporting(E_ALL ^ E_WARNING && E_NOTICE);
date_default_timezone_set("Asia/Karachi");

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

// Update Queries
if ($state == "OFF") {
    $updateQuery = "UPDATE switch_me.tbl_state SET col_state = 'OFF', created_at = '$time', energy = 0.4 WHERE id = $id";
    $updateQueryResult = mysqli_query($conn, $updateQuery);
    if ($updateQueryResult) {
        // Update into logs when turning off
        // First, get the energy usage
        $selectEnergyUsageQuery = "SELECT energy FROM switch_me.tbl_state WHERE id = $id;";
        $selectEnergyUsageQueryResult = mysqli_query($conn, $selectEnergyUsageQuery);
        $row = mysqli_fetch_assoc($selectEnergyUsageQueryResult);
        $energyUsage = $row['energy'];

        // Run update query
        $updateLogsQuery = "UPDATE switch_me.tbl_log SET ended_at = '$time', energy_usage = $energyUsage, transaction_status = 'complete' WHERE relay_id = $id AND transaction_status = 'pending';";
        $updateLogsQueryResult = mysqli_query($conn, $updateLogsQuery);
        if ($updateLogsQueryResult) {
            echo (json_encode([$successful = true]));
        } else {
            echo (json_encode([$successful = false]));
        }
    } else {
        echo (json_encode([$successful = false]));
    }
} else {
    $updateQuery = "UPDATE switch_me.tbl_state SET col_state = 'ON', created_at = '$time' WHERE id = $id";
    $updateQueryResult = mysqli_query($conn, $updateQuery);

    if ($updateQueryResult) {
        // Insert into logs when turning on
        $insertQuery = "INSERT INTO switch_me.tbl_log (relay_id, started_at) VALUES ($id, '$time');";
        $insertQueryResult = mysqli_query($conn, $insertQuery);
        if ($insertQueryResult) {
            echo (json_encode([$successful = true]));
        } else {
            echo (json_encode([$successful = false]));
        }
    } else {
        echo (json_encode([$successful = false]));
    }
}
