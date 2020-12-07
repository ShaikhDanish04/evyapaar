<?php

header('Access-Control-Allow-Origin: *');
header("Content-type: application/json; charset=utf-8");

require('connect.php');

foreach ($_GET as $key => $value) {
    $_GET[$key] = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $value);
}
if (isset($_GET['select'])) {

    $table_name = $_GET['select'];
    $where = '';
    $orderby = '';
    $limit = '';
    $response->query['query'] = $_REQUEST;

    if (isset($_POST['desc'])) {
        $orderby = ' ORDER BY `' . $_POST['desc'] . '` DESC ';
    }
    if (isset($_POST['where'])) {
        $length = count($_POST['where']);
        $i = 0;
        foreach ($_POST['where'] as $key => $val) {
            if ($i == 0) $where .= ' WHERE';

            $where .= ' `' . $key . '`=\'' . $val . '\' ';
            $i++;
            if ($i < $length) $where .= ' AND';
        }
    }
    if (isset($_POST['limit'])) {
        $limit = ' LIMIT ' . $_POST['limit'];
    }

    $result = $conn->query("SELECT * FROM $table_name $where $orderby $limit");

    $list = array();
    if ($result == TRUE) {
        $response->query['status'] = true;
        while ($row = $result->fetch_assoc()) {
            foreach ($row as $a => $b) {
                if (strpos($b, '{')) {
                    $row[$a] = json_decode($b, true);
                }
            }
            array_push($list,  $row);
        }
        $response->query['data'] = $list;
    } else {
        $response->query['status'] = false;
        $response->query['error'] = $conn->error;
    }
}


if (isset($_GET['update'])) {
    $response->query['query'] = $_REQUEST;

    $table_name = $_GET['update'];
    $set = '';
    $where = '';

    if (isset($_POST['column'])) {
        $length = count($_POST['column']);
        $i = 0;
        foreach ($_POST['column'] as $key => $val) {
            $set .= ' `' . $key . '`=\'' . $val . '\' ';
            $i++;
            if ($i < $length) $set .= ',';
        }
    }

    if (isset($_POST['where'])) {
        $length = count($_POST['where']);
        $i = 0;
        foreach ($_POST['where'] as $key => $val) {
            if ($i == 0) $where .= ' WHERE';

            $where .= ' `' . $key . '`=\'' . $val . '\' ';
            $i++;
            if ($i < $length) $where .= ' AND';
        }
    }

    $result = $conn->query("UPDATE $table_name SET $set $where");

    if ($result == TRUE) {
        $response->query['status'] = true;
        if (isset($_GET['response'])) {
            $cols = '*';
            if ($_GET['response'] == 'selected') {
                $cols = '';
                $length = count($_POST['column']);
                $i = 0;
                foreach ($_POST['column'] as $key => $val) {
                    $cols .= ' `' . $key . '` ';
                    $i++;
                    if ($i < $length) $cols .= ',';
                }
            }
            $response->query['data'] = $conn->query("SELECT $cols FROM $table_name $where")->fetch_assoc();
        }
    } else {
        $response->query['status'] = false;
        $response->query['error'] = $conn->error;
    }
}
echo json_encode($response);
