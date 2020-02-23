

<?php
header("Content-type:application/json");
$_SERVER['CONTENT_TYPE'] = "application/x-www-form-urlencoded"; 
error_reporting (E_ALL ^ E_WARNING && E_NOTICE);

//Response class
class Response {
    var $successful;
    var $colState;
    var $updateTime;
    var $volts;
    var $amps;
    var $power;
    var $energy;
    var $cost;
    
    
    function __construct () {
        $this->successful = false;
        $this->colState = "OFF";
        $this->updateTime = date("F d, Y h:i:s A", time());
	$this->volts = 0.0;
	$this->amps = 0.0;
	$this->power = 0.0;
	$this->energy = 0.0;
	$this->cost = 0.0;

    }
}

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

// Insert new state
$getQuery = "SELECT * FROM switch_me.tbl_state;";
$getQueryResult = mysqli_query($conn, $getQuery);

$successful = $getQueryResult;

if ($getQueryResult) {
    $row = mysqli_fetch_assoc($getQueryResult);
    
    $response = new Response();
    $response->successful = true;
    $response->colState = $row['col_state'];
    $response->updateTime = $row['created_at'];
    $response->volts = $row['volts'];
    $response->amps = $row['amps'];
    $response->power = $row['power'];
    $response->energy = $row['energy'];
    $response->cost = $row['cost'];

    
    echo (json_encode($response));
} else {
    $response = new Response();
    echo (json_encode($response));
}
?>