<?php

namespace App\Controllers;

use App\Models\User;

class AuthController extends Controller
{
    public static function logout() {
        session_destroy();
        header('Location: login.html');
        exit();
    }

}