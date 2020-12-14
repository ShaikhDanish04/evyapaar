<?php

// The request is using the POST method
require('connect.php');


if (isset($_GET['crud'])) {
    switch ($_GET['crud']) {

        case "insert":
            $type = $_POST['type'];
            $invoice_id = $_POST['invoice_id'];
            $due_amount = $_POST['due_amount'];
            $datetime = date("Y-m-d H:i:s");


            $result = $conn->query("INSERT INTO `due` (`type`, `invoice_id`, `due_amount`, `datetime`) VALUES ('$type', '$invoice_id', '$due_amount', '$datetime')");

            if ($result == TRUE) {
                $response->queryStatus = true;
            } else {
                $response->queryStatus = false;
                $response->queryError = $conn->error;
            }
            break;
    }
}


echo json_encode($response);
