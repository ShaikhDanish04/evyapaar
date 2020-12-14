<?php

// The request is using the POST method
require('connect.php');


if (isset($_GET['crud'])) {
    switch ($_GET['crud']) {
      
        case "insert":
            $invoice_id = $_POST['invoice_id'];
            $vendor_id = $_POST['vendor_id'];
            if (isset($_POST['products'])) $products = json_encode($_POST['products']);
            else $products = '[]';
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
      
        case "lock":
            $invoice_id = $_POST['invoice_id'];
            $vendor_id = $_POST['vendor_id'];
            if (isset($_POST['products'])) $products = json_encode($_POST['products']);
            else $products = json_encode('{}');
            $datetime = date("Y-m-d H:i:s");
            $sgst_amount = $_POST['sgst_amount'];
            $cgst_amount = $_POST['cgst_amount'];
            $sub_total = $_POST['sub_total'];
            $discount = $_POST['discount'];
            $net_total = $_POST['net_total'];
            $grand_total = $_POST['grand_total'];

            if ($invoice_id == 'new') {
                $row = $conn->query("SELECT * FROM purchase ORDER BY `id` DESC LIMIT 1")->fetch_assoc();
                if ($row['id'] == null) $invoice_id = 1;
                else $invoice_id = $row['id'] + 1;
                $conn->query("INSERT INTO `purchase` (`id`, `vendor_id`, `products`, `sgst_amount`, `cgst_amount`, `sub_total`, `discount`, `net_total`, `grand_total`, `datetime`,`status`) 
                                            VALUES ('$invoice_id', '$vendor_id', '$products', '$sgst_amount', '$cgst_amount', '$sub_total', '$discount', '$net_total', '$grand_total', '$datetime','1')");
            }

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
                $result = $conn->query("UPDATE `purchase` SET  `status`='1' WHERE `id` = '$invoice_id'");

                if ($result == TRUE) {
                    $response->invoice_id = $invoice_id;
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
