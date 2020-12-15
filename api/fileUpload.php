<?php

header('Access-Control-Allow-Origin: *');
header("Content-type: application/json; charset=utf-8");

require('connect.php');

if (isset($_FILES['file']['name'])) {

    /* Getting file name */
    $filename = $_FILES['file']['name'];

    /* Location */
    $location = __DIR__ . "/../upload/" . $filename;
    $imageFileType = pathinfo($location, PATHINFO_EXTENSION);
    $imageFileType = strtolower($imageFileType);

    /* Valid extensions */
    $valid_extensions = array("jpg", "jpeg", "png");

    /* Check file extension */
    if (in_array(strtolower($imageFileType), $valid_extensions)) {
        /* Upload file */
        if (move_uploaded_file($_FILES['file']['tmp_name'], $location)) {
            $response->image['location'] = $location;
            $response->image['filename'] = $filename;
            $response->image['status'] = true;
        } else {
            $response->image['status'] = false;
        }
    }


    $response->dump = getcwd();
}
echo json_encode($response);
// echo 0;
