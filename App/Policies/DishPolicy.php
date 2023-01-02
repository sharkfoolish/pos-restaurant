<?php

namespace App\Policies;

use App\Extensions\HttpException;

class DishPolicy
{
    public static function viewAny() {
        if ($_SESSION['position'] != 'waiter') {
            new HttpException('403', '您尚無權限閱覽此資料');
        }
    }
}