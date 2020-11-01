<?php

// The request is using the POST method
require('connect.php');


if (isset($_GET['crud'])) {
    switch ($_GET['crud']) {
        case "select":
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $checkout = $conn->query("SELECT * FROM `checkout` WHERE id = '$id'")->fetch_assoc();
                // $vendor_id = $checkout['vendor_id'];
                // $vendor = $conn->query("SELECT * FROM `vendor` WHERE id = '$vendor_id'")->fetch_assoc();

                // $checkout['vendor'] = json_encode($vendor);
                $checkout['customer'] = json_decode($checkout['customer'], true);
                $checkout['products'] = json_decode($checkout['products'], true);
                $response->data = $checkout;
            } else {
                // $result = $conn->query("SELECT checkout.*,vendor.name FROM checkout INNER JOIN vendor ON purchase.vendor_id = vendor.id");
                $result = $conn->query("SELECT * FROM checkout");
                $list = array();

                if ($result == TRUE) {
                    while ($row = $result->fetch_assoc()) {
                        $row['customer'] = json_decode($row['customer'], true);
                        array_push($list, $row);
                    }
                    // $response->data = json_encode($list);
                    $response->data = $list;
                } else {
                    $response->queryError = $conn->error;
                }
            }
            break;
            // case "insert":
            //     $invoice_id = $_POST['invoice_id'];
            //     $vendor_id = $_POST['vendor_id'];
            //     $products = json_encode($_POST['products']);
            //     $datetime = date("Y-m-d H:i:s");
            //     $sgst_amount = $_POST['sgst_amount'];
            //     $cgst_amount = $_POST['cgst_amount'];
            //     $sub_total = $_POST['sub_total'];
            //     $discount = $_POST['discount'];
            //     $net_total = $_POST['net_total'];
            //     $grand_total = $_POST['grand_total'];

            //     $row = $conn->query("SELECT * FROM purchase ORDER BY `id` DESC LIMIT 1")->fetch_assoc();
            //     if ($row['id'] == null) $id = 1;
            //     else $id = $row['id'] + 1;

            //     $result = $conn->query("INSERT INTO `purchase` (`id`, `vendor_id`, `products`, `sgst_amount`, `cgst_amount`, `sub_total`, `discount`, `net_total`, `grand_total`, `datetime`) 
            //                                     VALUES ('$id', '$vendor_id', '$products', '$sgst_amount', '$cgst_amount', '$sub_total', '$discount', '$net_total', '$grand_total', '$datetime')");

            //     if ($result === TRUE) {
            //         $response->status = true;
            //         $response->invoice_id = $id;
            //     } else {
            //         $response->status = false;
            //         $response->queryError = $conn->error;
            //     }
            //     break;
        case "update":
            $invoice_id = $_POST['invoice_id'];
            $customer = json_encode($_POST['customer']);
            if (isset($_POST['products'])) $products = json_encode($_POST['products']);
            else $products = '[]';
            $datetime = date("Y-m-d H:i:s");
            // $sgst_amount = $_POST['sgst_amount'];
            // $cgst_amount = $_POST['cgst_amount'];
            $sub_total = $_POST['sub_total'];
            // $discount = $_POST['discount'];
            // $net_total = $_POST['net_total'];
            $grand_total = $_POST['grand_total'];


            $result = $conn->query("UPDATE `checkout` SET 
                                `products` = '$products',
                                `sub_total`='$sub_total',
                                `grand_total`='$grand_total',
                                `datetime`='$datetime' 
                            WHERE `id` = '$invoice_id'");

            if ($result == TRUE) {
                $response->status = true;
            } else {
                $response->status = false;
                $response->queryError = $conn->error;
            }
            break;
        case "lock":
            // $invoice_id = $_POST['invoice_id'];
            // $vendor_id = $_POST['vendor_id'];
            // $products = json_encode($_POST['products']);
            // $datetime = date("Y-m-d H:i:s");
            // $sgst_amount = $_POST['sgst_amount'];
            // $cgst_amount = $_POST['cgst_amount'];
            // $sub_total = $_POST['sub_total'];
            // $discount = $_POST['discount'];
            // $net_total = $_POST['net_total'];
            // $grand_total = $_POST['grand_total'];
            // $status = $_POST['status'];

            // foreach ($_POST['products'] as $product) {
            //     $product_res = $conn->query("SELECT * FROM product WHERE id='" . $product['id'] . "'")->fetch_assoc();
            //     $quantity = $product_res['quantity'] + $product['quantity'];
            //     $product_up = $conn->query("UPDATE `product` SET `quantity` = '$quantity' WHERE id='" . $product['id'] . "'");
            // }

            // $result = $conn->query("UPDATE `purchase` SET 
            //                     `vendor_id` = '$vendor_id',
            //                     `products` = '$products',
            //                     `sgst_amount`='$sgst_amount',
            //                     `cgst_amount`='$cgst_amount',
            //                     `sub_total`='$sub_total',
            //                     `discount`='$discount',
            //                     `net_total`='$net_total',
            //                     `grand_total`='$grand_total',
            //                     `datetime`='$datetime', 
            //                     `status`='$status' 
            //                 WHERE `id` = '$invoice_id'");


            // if ($result == TRUE && $product_res == TRUE && $product_up == TRUE) {
            //     $response->status = true;
            // } else {
            //     $response->status = false;
            //     $response->queryError = $conn->error;
            // }
            // break;
    }
}

echo json_encode($response);
