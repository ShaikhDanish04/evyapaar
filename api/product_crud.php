<?php

// The request is using the POST method
require('connect.php');


if (isset($_GET['crud'])) {
    switch ($_GET['crud']) {

        case "insert":
            $name = $_POST['name'];
            $hsn = $_POST['hsn'];
            $gst = $_POST['gst'];
            $selling_cost = $_POST['selling_cost'];
            $barcode = $_POST['barcode'];

            $result = $conn->query("INSERT INTO `product` ( `name`, `hsn`, `gst_id`,`selling_cost`, `barcode`) 
                                     VALUES ('$name', '$hsn', '$gst','$selling_cost', '$barcode')");

            if ($result == TRUE) {
                $response->queryStatus = true;
            } else {
                $response->queryStatus = false;
                $response->queryError = $conn->error;
            }
            break;

        case "update":
            $id = $_POST['product_id'];
            $name = $_POST['name'];
            $hsn = $_POST['hsn'];
            $selling_cost = $_POST['selling_cost'];
            $gst = $_POST['gst'];
            $barcode = $_POST['barcode'];

            $result = $conn->query("UPDATE `product` SET `name`='$name',
                                              `hsn`='$hsn',
                                              `selling_cost`='$selling_cost',
                                              `gst_id`='$gst',
                                              `barcode`='$barcode' 
                                              WHERE id='$id'");

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

            $result = $conn->query("DELETE FROM `product` WHERE id='$id'");

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
