<?php

namespace App\Policies;

use App\Extensions\HttpException;

class OrderPolicy
{
    public static function create() {
        if ($_SESSION['position'] != 'waiter') {
            new HttpException('403', '您尚無權限更改此資料');
        }
    }
}