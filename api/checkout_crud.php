<?php

// The request is using the POST method
require('connect.php');


if (isset($_GET['crud'])) {
    switch ($_GET['crud']) {
        case "select":
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $checkout = $conn->query("SELECT * FROM `checkout` WHERE id = '$id'")->fetch_assoc();
                $customer_id = $checkout['customer'];
                $customer = $conn->query("SELECT * FROM `customer` WHERE mobile = '$customer_id'")->fetch_assoc();
                $checkout['date'] = pdate($checkout['datetime']);
                $checkout['time'] = ptime($checkout['datetime']);

                $checkout['customer'] = json_encode($customer);
                $checkout['products'] = $checkout['products'];
                $response->data = json_encode($checkout);
            } else {
                $result = $conn->query("SELECT checkout.id,customer.name as customer_name,customer as mobile,checkout.* FROM checkout INNER JOIN customer ON checkout.customer = customer.mobile");
                if (isset($_GET['desc'])) {
                    $result = $conn->query("SELECT checkout.id,customer.name as customer_name,customer as mobile,checkout.* FROM checkout INNER JOIN customer ON checkout.customer = customer.mobile ORDER BY checkout.id DESC");
                }
                $list = array();

                if ($result == TRUE) {
                    while ($row = $result->fetch_assoc()) {

                        // print_r($row);
                        $customer = json_decode($row['customer'], true);
                        $row['customer'] = $customer['fullname'];

                        $products = json_decode($row['products'], true);
                        $count = count($products);

                        $row['products'] = '<p class="m-0 text-center"><span class="badge badge-primary px-3 py-2">' . $count . '</span></p>';
                        if ($count == 0)
                            $row['products'] = '<p class="m-0 text-center"><span class="badge badge-dark px-3 py-2">' . $count . '</span></p>';
                        $row['sgst_amount'] = '<p class="m-0 text-right">' . $row['sgst_amount'] . '</p>';
                        $row['cgst_amount'] = '<p class="m-0 text-right">' . $row['cgst_amount'] . '</p>';
                        $row['sub_total'] = '<p class="m-0 text-right">' . $row['sub_total'] . '</p>';
                        $row['discount'] = '<p class="m-0 text-right">' . $row['discount'] . ' %</p>';
                        $row['net_total'] = '<p class="m-0 text-right">' . $row['net_total'] . '</p>';
                        $row['grand_total'] = '<p class="m-0 text-right">' . $row['grand_total'] . '</p>';

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
            $customer = json_encode($_POST['customer']);
            if (isset($_POST['products'])) $products = json_encode($_POST['products']);
            else $products = '[]';
            $datetime = date("Y-m-d H:i:s");
            $sgst_amount = $_POST['sgst_amount'];
            $cgst_amount = $_POST['cgst_amount'];
            $sub_total = $_POST['sub_total'];
            $discount = $_POST['discount'];
            $net_total = $_POST['net_total'];
            $grand_total = $_POST['grand_total'];

            $customer_mobile = $_POST['customer']['mobile'];
            $customer_fullname = $_POST['customer']['fullname'];
            $customer_email = $_POST['customer']['email'];
            $customer_address = $_POST['customer']['address'];

            if ($conn->query("SELECT * FROM customer WHERE mobile = '$customer_mobile'")->num_rows == 0) {
                $result == $conn->query("INSERT INTO `customer` (`mobile`, `name`, `email`, `address`) 
                                            VALUES ('$customer_mobile', '$customer_fullname', '$customer_email', '$customer_address')");
            }
            $row = $conn->query("SELECT * FROM checkout ORDER BY `id` DESC LIMIT 1")->fetch_assoc();
            if ($row['id'] == null) $id = 1;
            else $id = $row['id'] + 1;
            $result = $conn->query("INSERT INTO `checkout` (`id`, `customer`, `products`, `sgst_amount`, `cgst_amount`, `sub_total`, `discount`, `net_total`, `grand_total`, `datetime`) 
                                                VALUES ('$id', '$customer_mobile', '$products', '$sgst_amount', '$cgst_amount', '$sub_total', '$discount', '$net_total', '$grand_total', '$datetime')");

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
            $customer = json_encode($_POST['customer']);
            if (isset($_POST['products'])) $products = json_encode($_POST['products']);
            else $products = '[]';
            $datetime = date("Y-m-d H:i:s");
            $sgst_amount = $_POST['sgst_amount'];
            $cgst_amount = $_POST['cgst_amount'];
            $sub_total = $_POST['sub_total'];
            $discount = $_POST['discount'];
            $net_total = $_POST['net_total'];
            $grand_total = $_POST['grand_total'];


            $result = $conn->query("UPDATE `checkout` SET 
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
            $customer = json_encode($_POST['customer']);
            if (isset($_POST['products'])) $products = json_encode($_POST['products']);
            else $products = '[]';
            $datetime = date("Y-m-d H:i:s");
            $sgst_amount = $_POST['sgst_amount'];
            $cgst_amount = $_POST['cgst_amount'];
            $sub_total = $_POST['sub_total'];
            $discount = $_POST['discount'];
            $net_total = $_POST['net_total'];
            $grand_total = $_POST['grand_total'];

            if ($invoice_id == 'new') {
                $customer_mobile = $_POST['customer']['mobile'];
                $customer_fullname = $_POST['customer']['fullname'];
                $customer_email = $_POST['customer']['email'];
                $customer_address = $_POST['customer']['address'];

                if ($conn->query("SELECT * FROM customer WHERE mobile = '$customer_mobile'")->num_rows == 0) {
                    $conn->query("INSERT INTO `customer` (`mobile`, `name`, `email`, `address`) 
                                            VALUES ('$customer_mobile', '$customer_fullname', '$customer_email', '$customer_address')");
                }
                $row = $conn->query("SELECT * FROM checkout ORDER BY `id` DESC LIMIT 1")->fetch_assoc();
                if ($row['id'] == null) $id = 1;
                else $id = $row['id'] + 1;

                $conn->query("INSERT INTO `checkout` (`id`, `customer`, `products`, `sgst_amount`, `cgst_amount`, `sub_total`, `discount`, `net_total`, `grand_total`, `datetime`,`status`) 
                                                VALUES ('$id', '$customer_mobile', '$products', '$sgst_amount', '$cgst_amount', '$sub_total', '$discount', '$net_total', '$grand_total', '$datetime','1')");
            }

            foreach ($_POST['products'] as $product) {
                $product_res = $conn->query("SELECT * FROM product WHERE id='" . $product['id'] . "'")->fetch_assoc();
                $quantity = $product_res['quantity'] - $product['unit'];
                $product_up = $conn->query("UPDATE `product` SET `quantity` = '$quantity' WHERE id='" . $product['id'] . "'");
            }

            $result = $conn->query("UPDATE `checkout` SET 
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
                $result = $conn->query("UPDATE `checkout` SET `status`='1' WHERE `id` = '$invoice_id'");

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
