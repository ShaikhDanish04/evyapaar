<?php
$addr_space = '';
require_once('connect.php');

// parse url and repair request
if (isset($_GET['url'])) {
    $url_request = $_GET['url'];
} else {
    $url_request = '';
}
// if ($url_request == '') {
//     $url_request = 'index';
// }
$url_break = explode('/', $url_request);

$space = count($url_break) + substr_count($_SERVER['REQUEST_URI'], "//");
for ($i = 0; $i < $space; $i++) {
    if ($i > 0) {
        $addr_space .= '../';
    }
}
if (substr($url_request, -1) == '/') {
    // $url_request = substr($url_request, 0, -1);
    $url_request = $url_request . 'index';
}


// if ($employee_login) {
//     unset($_GET['auth']);
// } else {
//     if (!isset($_GET['auth'])) {
//         $_GET['auth'] = 'login';
//     }
// }

// if (isset($_GET['auth'])) {
//     switch ($_GET['auth']) {
//         case "login":
//             require_once('views/pages/login.php');

//             break;

//         case "register":

//             require_once('views/pages/register.php');
//             break;

//         case "forgot-password":
//             require_once('views/pages/forgot-password.php');

//             break;

//         default:
//     }
// } else {
//     $session_id = $_SESSION['employee_session']['id'];
//     $user_in = $conn->query("SELECT * FROM `employee` WHERE employee_id = '$session_id'")->fetch_assoc();
// }
if (isset($_POST['logout'])) {
    unset($_SESSION['admin_session']);
}
if (isset($_SESSION['admin_session'])) {
    require_once('template.php');
} else {
    require_once('views/pages/login.php');
}
