<?php

namespace App\Controllers;

use App\Extensions\HttpException;
use App\Extensions\Validation;
use App\Models\User;

class AuthController extends Controller
{
    public static function login($request) {
        AuthController::validateLoginRequest($request);
        $user = User::where('account', $request['account'])[0];
        if (isset($user['password']) && $user['password'] == $request['password']) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['position'] = $user['position'];
            Controller::response($user);
        } else {
            new HttpException(409, '您輸入的帳號密碼有誤，請確認無誤後再次送出!');
        }
    }

    private static function validateLoginRequest($request) {
        $list = [
            'account' => ['string'],
            'password' => ['string']
        ];
        Validation::validate($list, $request);
    }
    
    public static function logout() {
        session_destroy();
        header('Location: login.html');
        exit();
    }

    public static function getCurrentUser() {
        if ($_SESSION) {
            if (User::where('id', $_SESSION['id'], 'position', $_GET['position'])) {
                UserController::response($_SESSION);
            } else {
                new HttpException(401, '您尚未登入成功');
            }
        } else {
            new HttpException(401, '您尚未登入成功');
        }
    }
}