<?php

$response = new stdClass();
// get domain name from config file

// $string = "";
// $myfile = fopen("../../config.json", "r") or die("Unable to open file!");
// while (!feof($myfile)) {
//     $string .= fgets($myfile);
// }
// fclose($myfile);
// $configJson = json_decode($string, true);


// $database = $configJson['database'];

// if ($database['type'] == 'local') {
    $servername = 'localhost';
    $dbname = 'evyapaar';
    $username = 'root';
    $password = '';
// }



// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    $response->connection_status = "Connection failed: " . $conn->connect_error;
} else {
    $response->connection_status = "Connected";
}

date_default_timezone_set('Asia/Kolkata');
$datetime = date("Y-m-d H:i:s");

session_start();
if (isset($_POST['logout'])) {
    unset($_SESSION['user_in']);
    echo json_encode($response);
}

if (isset($_GET['get'])) {
    if (isset($_SESSION['user_in'])) {
        $response->session_established = true;
    } else {
        $response->session_established = false;
    }
    echo json_encode($response);
}
