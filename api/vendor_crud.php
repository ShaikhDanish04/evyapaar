<?php

// The request is using the POST method
require('connect.php');


if (isset($_GET['crud'])) {
    switch ($_GET['crud']) {
        case "select":
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $result = $conn->query("SELECT * FROM vendor WHERE id = '$id'")->fetch_assoc();
                $response->data = json_encode($result);
            } else {
                $result = $conn->query("SELECT * FROM vendor");
                $list = array();

                if ($result == TRUE) {
                    while ($row = $result->fetch_assoc()) {
                        array_push($list, $row);
                    }
                    $response->data = json_encode($list);
                } else {
                    $response->queryError = $conn->error;
                }
            }
            break;

        case "insert":
            $name = $_POST['name'];
            $contact = $_POST['contact'];
            $email = $_POST['email'];
            $address = $_POST['address'];

            $result = $conn->query("INSERT INTO `vendor` (`name`, `contact`, `email`, `address`) VALUES ('$name', '$contact', '$email', '$address')");

            if ($result == TRUE) {
                $response->inserted = true;
            } else {
                $response->inserted = false;
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
                $response->updated = true;
            } else {
                $response->updated = false;
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
