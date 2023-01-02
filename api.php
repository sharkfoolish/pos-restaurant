<?php
include 'autoload.php';

use App\Controllers\AuthController;
use App\Controllers\DiningTableController;
use App\Controllers\DishController;
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
        case '/current-user':
            AuthController::getCurrentUser($request);
            break;
        case '/users/is-waiter':
            UserController::searchIsWaiter();
            break;
        case '/user/assigned-dining-table':
            UserController::retrieveAssignedDiningTable();
            break;
        case '/dining-tables':
            DiningTableController::search();
            break;
        case '/dining_tables/dining_table' :
            DiningTableController::retrieve();
            break;
        case '/dishes':
            DishController::search($request);
            break;
    }
} else if($_SERVER["REQUEST_METHOD"] == 'POST') {
    switch ($_GET['route']) {
        case '/logout':
            AuthController::logout();
            break;
        case '/dining-table/order':
            DiningTableController::addOrder($request);
            break;
    }
} else if($_SERVER["REQUEST_METHOD"] == 'PATCH') {
    switch ($_GET['route']) {
        case '/dining-table/assigned/waiter':
            DiningTableController::assignDesignee($request);
            break;
    }
} else {
    new HttpException(405, "Method Not Allowed");
}
