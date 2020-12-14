<?php

// The request is using the POST method
require('connect.php');


if (isset($_GET['crud'])) {
    switch ($_GET['crud']) {
     
        case "insert":
            $name = $_POST['name'];
            $contact = $_POST['contact'];
            $email = $_POST['email'];
            $address = $_POST['address'];

            $result = $conn->query("INSERT INTO `vendor` (`name`, `contact`, `email`, `address`) VALUES ('$name', '$contact', '$email', '$address')");

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
            $address = $_POST['address'];

            $result = $conn->query("UPDATE `vendor` SET `name`='$name',`contact`='$contact',`email`='$email',`address`='$address' WHERE id='$id'");

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
