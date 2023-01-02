<?php

namespace App\Policies;

use App\Extensions\HttpException;

class AssignmentPolicy
{
    public static function create() {
        if ($_SESSION['position'] != 'reception') {
            new HttpException('403', '您尚無權限更改此資料');
        }
    }
}