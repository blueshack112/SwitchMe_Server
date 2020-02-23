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
$volt = $_POST["volts"];
$amps = $_POST["amps"];
$power = $_POST["power"];
$energy = $_POST["energy"];
$cost = $_POST["cost"];
$id = $_POST["id"];


// Update new state
$insertQuery = "UPDATE switch_me.tbl_state SET volts = $volt, amps = $amps, power = $power, energy = $energy, cost = $cost WHERE id = $id";
$insertQueryResult = mysqli_query($conn, $insertQuery);


if ($insertQueryResult) {
  echo (json_encode([$successful = true]));
} else {
  echo (json_encode([$successful = false]));
}