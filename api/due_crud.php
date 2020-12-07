<?php

// The request is using the POST method
require('connect.php');


if (isset($_GET['crud'])) {
    switch ($_GET['crud']) {
        case "select":
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $result = $conn->query("SELECT * FROM due WHERE id = '$id'")->fetch_assoc();
                $response->data = json_encode($result);
            } else {
                $result = $conn->query("SELECT * FROM due");
                $list = array();

                if ($result == TRUE) {
                    $array = array();
                    while ($row = $result->fetch_assoc()) {

                        $row['type'] = ($row['type'] == 'checkout') ? '<span class="badge badge-info px-3 py-2 ">Checkout</span>' : '<span class="badge badge-dark px-3 py-2">Purchase</span>';
                        $row['status'] = ($row['status'] == '0') ? '<span class="badge badge-warning px-3 py-2" data-status="0">Pending</span>' : '<span class="badge badge-success px-3 py-2" data-status="1">Cleared</span>';
                        $row['datetime'] = datetime($row['datetime']);
                        array_push($list, $row);
                    }
                    $response->data = json_encode($list);
                } else {
                    $response->queryError = $conn->error;
                }
            }
            break;

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
