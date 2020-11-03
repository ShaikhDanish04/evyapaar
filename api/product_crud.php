<?php

// The request is using the POST method
require('connect.php');


if (isset($_GET['crud'])) {
    switch ($_GET['crud']) {
        case "select":
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $result = $conn->query("SELECT product.*,gst_slab.tax_percent FROM product INNER JOIN gst_slab ON product.gst_id = gst_slab.id WHERE product.id = '$id'")->fetch_assoc();
                $response->data = json_encode($result);
            } else {
                $result = $conn->query("SELECT product.*,gst_slab.tax_percent FROM product INNER JOIN gst_slab ON product.gst_id = gst_slab.id ORDER BY product.id ASC");
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
            $hsn = $_POST['hsn'];
            $gst = $_POST['gst'];
            $barcode = $_POST['barcode'];

            $result = $conn->query("INSERT INTO `product` ( `name`, `hsn`, `gst_id`, `barcode`) 
                                     VALUES ('$name', '$hsn', '$gst', '$barcode')");

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
