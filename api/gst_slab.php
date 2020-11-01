<?php

// The request is using the POST method
require('connect.php');

$result = $conn->query("SELECT * FROM gst_slab");
$list = array();

if ($result == TRUE) {
    while ($row = $result->fetch_assoc()) {
        array_push($list, $row);
    }
    $response->data = json_encode($list);
} else {
    $response->queryError = $conn->error;
}

echo json_encode($response);
