<?php

// The request is using the POST method
require('connect.php');

$username = $_POST['username'];
$password = $_POST['password'];

$result = $conn->query("SELECT * FROM `system_users` WHERE `username`='$username' AND `password`='$password'");

if ($result == TRUE) {
    // $response->data = json_encode($list);

    if ($result->num_rows == 1) {
        $response->login_status = true;
        $user = $result->fetch_assoc();
        $user['password'] = '';
        $_SESSION['user_in'] = $user['username'];
        $response->user = $user;
    } else {
        $response->login_status = false;
    }
} else {
    $response->queryError = $conn->error;
}

echo json_encode($response);
