<?php

namespace App\Policies;

use App\Extensions\HttpException;

class DiningTablePolicy
{
    public static function view() {
        if ($_SESSION['position'] != 'waiter') {
            new HttpException('403', '您尚無權限閱覽此資料');
        }
    }

    public static function viewAny() {
        if ($_SESSION['position'] != 'reception') {
            new HttpException('403', '您尚無權限閱覽此資料');
        }
    }

    public static function update() {
        if ($_SESSION['position'] != 'reception') {
            new HttpException('403', '您尚無權限更改此資料');
        }
    }
}