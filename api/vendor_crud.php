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
                        $vendor_id = $row['id'];
                        $purchase_list = $conn->query("SELECT * FROM purchase WHERE vendor_id = '$vendor_id'");

                        $row['Invoice'] = $purchase_list->num_rows;
                        $row['Total Purchase'] = 0;
                        // $row['purchase'] = '';

                        while ($purchase = $purchase_list->fetch_assoc()) {
                            // $row['purchase'] = json_encode($purchase);
                            $row['Total Purchase'] = $row['Total Purchase'] + $purchase['grand_total'];
                        }



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
