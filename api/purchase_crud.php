<?php

// The request is using the POST method
require('connect.php');


if (isset($_GET['crud'])) {
    switch ($_GET['crud']) {
        case "select":
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $purchase = $conn->query("SELECT * FROM `purchase` WHERE id = '$id'")->fetch_assoc();
                $vendor_id = $purchase['vendor_id'];
                $vendor = $conn->query("SELECT * FROM `vendor` WHERE id = '$vendor_id'")->fetch_assoc();

                $purchase['vendor'] = json_encode($vendor);
                $response->data = json_encode($purchase);
            } else {
                $result = $conn->query("SELECT purchase.id,vendor.name as vendor_name,purchase.products as products_count,purchase.* FROM purchase INNER JOIN vendor ON purchase.vendor_id = vendor.id");
                $list = array();

                if ($result == TRUE) {
                    while ($row = $result->fetch_assoc()) {
                        $row['products_count'] = count(json_decode($row['products_count']));

                        $row['datetime'] = datetime($row['datetime']);
                        // $row['status'] = ($row['status'] == '1') ? '<span class="badge badge-pill badge-success p-2" style="min-width:80px">Locked</span>' : '<span class="badge badge-pill badge-dark p-2" style="min-width:80px">Open</span>';
                        $row['status'] = '<span class="status">' . $row['status'] . '</span>';

                        array_push($list, $row);
                    }
                    $response->data = json_encode($list);
                } else {
                    $response->queryError = $conn->error;
                }
            }
            break;
        case "insert":
            $invoice_id = $_POST['invoice_id'];
            $vendor_id = $_POST['vendor_id'];
            $products = json_encode($_POST['products']);
            $datetime = date("Y-m-d H:i:s");
            $sgst_amount = $_POST['sgst_amount'];
            $cgst_amount = $_POST['cgst_amount'];
            $sub_total = $_POST['sub_total'];
            $discount = $_POST['discount'];
            $net_total = $_POST['net_total'];
            $grand_total = $_POST['grand_total'];

            $row = $conn->query("SELECT * FROM purchase ORDER BY `id` DESC LIMIT 1")->fetch_assoc();
            if ($row['id'] == null) $id = 1;
            else $id = $row['id'] + 1;

            $result = $conn->query("INSERT INTO `purchase` (`id`, `vendor_id`, `products`, `sgst_amount`, `cgst_amount`, `sub_total`, `discount`, `net_total`, `grand_total`, `datetime`) 
                                            VALUES ('$id', '$vendor_id', '$products', '$sgst_amount', '$cgst_amount', '$sub_total', '$discount', '$net_total', '$grand_total', '$datetime')");

            if ($result === TRUE) {
                $response->status = true;
                $response->invoice_id = $id;
            } else {
                $response->status = false;
                $response->queryError = $conn->error;
            }
            break;
        case "update":
            $invoice_id = $_POST['invoice_id'];
            $vendor_id = $_POST['vendor_id'];
            $products = json_encode($_POST['products']);
            $datetime = date("Y-m-d H:i:s");
            $sgst_amount = $_POST['sgst_amount'];
            $cgst_amount = $_POST['cgst_amount'];
            $sub_total = $_POST['sub_total'];
            $discount = $_POST['discount'];
            $net_total = $_POST['net_total'];
            $grand_total = $_POST['grand_total'];

            $result = $conn->query("UPDATE `purchase` SET 
                                `vendor_id` = '$vendor_id',
                                `products` = '$products',
                                `sgst_amount`='$sgst_amount',
                                `cgst_amount`='$cgst_amount',
                                `sub_total`='$sub_total',
                                `discount`='$discount',
                                `net_total`='$net_total',
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
            $invoice_id = $_POST['invoice_id'];
            $vendor_id = $_POST['vendor_id'];
            $products = json_encode($_POST['products']);
            $datetime = date("Y-m-d H:i:s");
            $sgst_amount = $_POST['sgst_amount'];
            $cgst_amount = $_POST['cgst_amount'];
            $sub_total = $_POST['sub_total'];
            $discount = $_POST['discount'];
            $net_total = $_POST['net_total'];
            $grand_total = $_POST['grand_total'];
            $status = $_POST['status'];
            $quantity;

            foreach ($_POST['products'] as $product) {
                $product_res = $conn->query("SELECT * FROM product WHERE id='" . $product['id'] . "'")->fetch_assoc();
                $quantity = $product_res['quantity'] + $product['unit'];
                $product_up = $conn->query("UPDATE `product` SET `quantity` = '$quantity' WHERE id='" . $product['id'] . "'");
            }

            $result = $conn->query("UPDATE `purchase` SET 
                                `vendor_id` = '$vendor_id',
                                `products` = '$products',
                                `sgst_amount`='$sgst_amount',
                                `cgst_amount`='$cgst_amount',
                                `sub_total`='$sub_total',
                                `discount`='$discount',
                                `net_total`='$net_total',
                                `grand_total`='$grand_total',
                                `datetime`='$datetime' 
                            WHERE `id` = '$invoice_id'");


            if ($product_res == TRUE && $product_up == TRUE) {
                $result = $conn->query("UPDATE `purchase` SET  `status`='$status' WHERE `id` = '$invoice_id'");

                if ($result == TRUE) {

                    $response->status = true;
                }
            } else {
                $response->status = false;
                $response->queryError = $conn->error;
            }
            break;
    }
}

echo json_encode($response);
