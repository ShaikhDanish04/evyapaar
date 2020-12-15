<?php

header('Access-Control-Allow-Origin: *');
header("Content-type: application/json; charset=utf-8");

require('connect.php');

if (isset($_FILES['file']['name'])) {

    /* Getting file name */
    if (!is_dir(__DIR__ . "/../upload")) {
        mkdir(__DIR__ . "/../upload");
    }
    if (!is_dir(__DIR__ . "/../upload/" . $domain)) {
        mkdir(__DIR__ . "/../upload/" . $domain);
    }
    $imageFileType = strtolower(pathinfo(basename($_FILES["file"]["name"]), PATHINFO_EXTENSION));
    if (isset($_POST['filename'])) {
        $filename = $_POST['filename'] . '.' . $imageFileType;
        $filepost = $_POST['filename'];
        $conn->query("UPDATE `system_users` SET `" . $filepost . "_ext` = '" . $imageFileType . "' WHERE domain='$domain'");
    } else {
        $filename = $_FILES['file']['name'];
    }
    $location = __DIR__ . "/../upload/" . $domain . '/' . $filename;

    /* Location */
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
    } else {
        $response->image['status'] = false;
    }


    $response->dump = $imageFileType;
}
echo json_encode($response);
// echo 0;
