<?php

namespace App\Controllers;

use App\Extensions\HttpException;
use App\Extensions\Validation;
use App\Models\User;

class AuthController extends Controller
{
    public static function login($request)
    {
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

}