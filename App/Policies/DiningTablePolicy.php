<?php

namespace App\Policies;

use App\Extensions\HttpException;

class DiningTablePolicy
{
    public static function viewAny() {
        if ($_SESSION['position'] != 'reception') {
            new HttpException('403', '您尚無權限閱覽此資料');
        }
    }
}