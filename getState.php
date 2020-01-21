

<?php
header("Content-type:application/json");
$_SERVER['CONTENT_TYPE'] = "application/x-www-form-urlencoded"; 
error_reporting (E_ALL ^ E_WARNING && E_NOTICE);

//Response class
class Response {
    var $successful;
    var $colState;
    var $updateTime;
    function __construct () {
        $this->successful = false;
        $this->colState = "OFF";
        $this->updateTime = date("F d, Y h:i:s A", time());
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
    echo (json_encode($response));
} else {
    $response = new Response();
    echo (json_encode($response));
}
?>