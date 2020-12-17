<?php

header('Access-Control-Allow-Origin: *');
header("Content-type: application/json; charset=utf-8");

require('connect.php');
// $domain = 'admin';

foreach ($_GET as $key => $value) {
    $_GET[$key] = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $value);
}

if ($_SERVER['HTTP_HOST'] != $_ENV['HTTP_HOST']) {
    $response->status = false;
    $response->request = 'failed';
    $response->reason = 'Access Not allowed for : ' . $_SERVER['HTTP_HOST'];
    echo json_encode($response);
    exit;
}

$response->dump = $_SERVER;

if (isset($_GET['select'])) {

    $table_name = $_GET['select'];
    // $where = '';
    if (isset($_GET['common'])) {
        $where = ' WHERE 1=1 ';
    } else {
        $where = ' WHERE domain = \'' . $domain . '\'';
    }
    $orderby = '';
    $limit = '';
    $response->query['query'] = $_REQUEST;


    if (isset($_POST['desc'])) {
        $orderby = ' ORDER BY ' . $_POST['desc'] . ' DESC ';
    }
    if (isset($_POST['where'])) {
        $length = count($_POST['where']);
        $i = 0;
        foreach ($_POST['where'] as $key => $val) {
            if ($i == 0) $where .= ' AND';
            // if ($i == 0) $where .= ' WHERE';

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

if (isset($_POST['join'])) {
    $table1 = $_POST['join']['table1'];
    $table2 = $_POST['join']['table2'];
    $id1 = $_POST['join']['id1'];
    $id2 = $_POST['join']['id2'];
    $order = (isset($_POST['join']['order'])) ? ' ORDER BY ' . $_POST['join']['order'] : '';
    $seq = '*';

    // $where = '';
    if (isset($_GET['common'])) {
        $where = ' WHERE ' . $table1 . '.domain = \'' . $domain . '\'';
    } else {
        $where = ' WHERE ' . $table1 . '.domain = \'' . $domain . '\' AND '  . $table2 . '.domain = \'' . $domain . '\'';
    }

    if (isset($_POST['join']['seq'])) {
        $seq = $_POST['join']['seq'];
    }

    if (isset($_POST['where'])) {
        $length = count($_POST['where']);
        $i = 0;
        foreach ($_POST['where'] as $key => $val) {
            // if ($i == 0) $where .= ' WHERE';
            if ($i == 0) $where .= ' AND';

            $where .= ' ' . $key . '=\'' . $val . '\' ';
            $i++;
            if ($i < $length) $where .= ' AND';
        }
    }

    $result = $conn->query("SELECT $seq FROM $table1 INNER JOIN $table2 ON $table1.$id1 = $table2.$id2 $where $order ");
    // $result = $conn->query("SELECT $seq FROM $table1 INNER JOIN $table2 ON $table1.$id1 = $table2.$id2 WHERE $where_in = '2' $order ");

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
    // $where = '';
    $where = ' WHERE domain = \'' . $domain . '\'';


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
            // if ($i == 0) $where .= ' WHERE';
            if ($i == 0) $where .= ' AND';

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

if (isset($_GET['getMax'])) {
    $column_name = $_GET['getMax'];
    $table_name = $_GET['from'];

    $row = $conn->query("SELECT * FROM $table_name WHERE domain = '$domain' ORDER BY $column_name DESC LIMIT 1")->fetch_assoc();
    if ($row[$column_name] == null) $data = 1;
    else $data = $row[$column_name];

    if ($row == TRUE) {
        $response->query['data'] = $data;
        $response->query['status'] = true;
    } else {
        $response->query['status'] = false;
        $response->query['error'] = $conn->error;
    }
}

if (isset($_GET['insert'])) {
    $response->query['query'] = $_REQUEST;

    $table_name = $_GET['insert'];
    $col = '';
    $value = '';

    if (isset($_POST['column'])) {
        $length = count($_POST['column']);
        $i = 0;
        foreach ($_POST['column'] as $key => $val) {
            if ($i == 0) {
                $col .= ' (domain,';
                $value .= ' (\'' . $domain . '\',';
            }
            $col .= $key;
            $i++;
            if ($i < $length) {
                $col .= ',';
                $value .= '\'' . $val . '\',';
            } else {
                $value .= '\'' . $val . '\')';
                $col .= ')';
            }
        }
    }

    $response->query['sample'] = "INSERT INTO $table_name $col VALUES $value";
    // $response->query['sample'] = "INSERT INTO $table_name $col VALUES ('2', '3', '2', '1', '4', '1', '2')";

    $result = $conn->query("INSERT INTO $table_name $col VALUES $value");
    if ($result == TRUE) {
        $response->query['status'] = true;
    } else {
        $response->query['status'] = false;
        $response->query['error'] = $conn->error;
    }
}

if (isset($_GET['session'])) {
    $response->session = $_SESSION;
}
echo json_encode($response);
