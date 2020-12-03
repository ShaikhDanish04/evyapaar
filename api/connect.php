<?php

$response = new stdClass();
if (file_exists('env.php')) {
    include('env.php');
    $response->env = true;
} else {
    $response->env = false;
}


// Create connection
$conn = new mysqli($_ENV['mysql']['host'], $_ENV['mysql']['username'], $_ENV['mysql']['password'], $_ENV['mysql']['database']);
// Check connection
if ($conn->connect_error) {
    $response->connection_status = "Connection failed: " . $conn->connect_error;
    $response->session_established = false;
    exit;
} else {
    $response->connection_status = "Connected";
    $response->session_established = true;
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
        $user = $conn->query("SELECT username,sidebar,invoice_desc FROM `system_users` WHERE `username`='" . $_SESSION['user_in'] . "'")->fetch_assoc();
        $response->user = $user;
    } else {
        $response->session_established = false;
    }
    echo json_encode($response);
}

function status($status)
{
    switch ($status) {
        case "active":
            return '<span class="badge badge-primary px-3 py-2">Active</span>';
            break;
        case "unverified":
            return '<span class="badge badge-warning px-3 py-2">Unverified</span>';
            break;
        case "verified":
            return '<span class="badge badge-success px-3 py-2">Verified</span>';
            break;
        case "blocked":
            return '<span class="badge badge-danger px-3 py-2">Blocked</span>';
            break;
    }
}

function datetime($datetime)
{
    return date_format(date_create($datetime), "d M Y - h:i:s A");
}
function pdate($datetime)
{
    return date_format(date_create($datetime), "d M Y");
}
function ptime($datetime)
{
    return date_format(date_create($datetime), "h:i:s A");
}
