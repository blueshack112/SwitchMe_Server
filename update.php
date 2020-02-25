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

// Add to energy
$toAdd = rand(1,15) / 10;
$energy = $energy + $toAdd;

// Get current energy usage
$getQuery = "SELECT energy FROM switch_me.tbl_state WHERE id = $id;";
$getQueryResult = mysqli_query($conn, $getQuery);

if ($getQueryResult) {
  $numRows = mysqli_num_rows($getQueryResult);
  if ($numRows > 0) {
      $row = mysqli_fetch_assoc($getQueryResult);
      $prevEnergy = $row['energy'];
      $energy = $energy + $prevEnergy;
  }
}

// Update new state
$insertQuery = "UPDATE switch_me.tbl_state SET volts = $volt, amps = $amps, power = $power, energy = $energy, cost = $cost WHERE id = $id";
$insertQueryResult = mysqli_query($conn, $insertQuery);


if ($insertQueryResult) {
  echo (json_encode([$successful = true]));
} else {
  echo mysqli_error($conn);
  echo (json_encode([$successful = false]));
}