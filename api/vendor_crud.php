<?php

// The request is using the POST method
require('connect.php');


if (isset($_GET['crud'])) {
    switch ($_GET['crud']) {

        case "insert":
            $name = $_POST['name'];
            $contact = $_POST['contact'];
            $email = $_POST['email'];
            $state = $_POST['state'];
            $address = $_POST['address'];
            $gst_number = $_POST['gst_number'];

            $result = $conn->query("INSERT INTO `vendor` (`name`, `contact`, `email`, `state`,`address`,`gst_number`) VALUES ('$name', '$contact', '$email','$state', '$address','$gst_number')");

            if ($result == TRUE) {
                $response->queryStatus = true;
            } else {
                $response->queryStatus = false;
                $response->queryError = $conn->error;
            }
            break;

        case "update":
            $id = $_POST['vendor_id'];
            $name = $_POST['name'];
            $contact = $_POST['contact'];
            $email = $_POST['email'];
            $state = $_POST['state'];
            $address = $_POST['address'];
            $gst_number = $_POST['gst_number'];

            $result = $conn->query("UPDATE `vendor` SET `name`='$name',`contact`='$contact',`email`='$email',`state`='$state',`address`='$address',`gst_number`='$gst_number' WHERE id='$id'");

            if ($result == TRUE) {
                $response->queryStatus = true;
            } else {
                $response->queryStatus = false;
                $response->queryError = $conn->error;
            }

            break;

        case "delete":
            // print_r($_POST);
            $id = $_GET['id'];

            $result = $conn->query("DELETE FROM `vendor` WHERE id='$id'");

            if ($result == TRUE) {
                $response->deleted = true;
            } else {
                $response->deleted = false;
                $response->queryError = $conn->error;
            }

            break;
    }
}


echo json_encode($response);
