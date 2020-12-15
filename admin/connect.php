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
    die("Connection failed: " . $conn->connect_error);
}

mysqli_set_charset($conn, 'utf8');

date_default_timezone_set('Asia/Kolkata');
$datetime = date("Y-m-d H:i:s");

session_start();

function alert($type, $message)
{
    return '' .
        '<div class="alert alert-' . $type . ' alert-dismissible fade show" role="alert">' .
        '    <button type="button" class="close" data-dismiss="alert" aria-label="Close">' .
        '        <span aria-hidden="true">&times;</span>' .
        '        <span class="sr-only">Close</span>' .
        '    </button>' .
        $message .
        '</div>';
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
    return date_format(date_create($datetime), "d M Y - h:m:i A");
}
