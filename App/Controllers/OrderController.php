<?php

namespace App\Controllers;

use App\Models\Order;
use App\Policies\OrderPolicy;

class OrderController extends Controller
{
    public static function update($request) {
        OrderPolicy::update();
        Order::update(
            ['status' => $request['status']],
            ['id' => $request['id']]
        );
    }
}