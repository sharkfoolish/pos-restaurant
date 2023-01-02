<?php
include 'autoload.php';

use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Extensions\HttpException;

session_start();
$_request_body = file_get_contents('php://input');
$request = json_decode($_request_body, true);

if ($_SERVER["REQUEST_METHOD"] == 'GET') {
    switch ($_GET['route']) {
        case '/login':
            AuthController::login($request);
            break;
        case '/users/is-waiter':
            UserController::searchIsWaiter();
            break;
    }
} else if($_SERVER["REQUEST_METHOD"] == 'POST') {
    switch ($_GET['route']) {
        case '/logout':
            AuthController::logout();
            break;
    }
} else if($_SERVER["REQUEST_METHOD"] == 'PATCH') {
    switch ($_GET['route']) {

    }
} else {
    new HttpException(405, "Method Not Allowed");
}
