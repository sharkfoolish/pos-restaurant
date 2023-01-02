<?php

namespace App\Models;

class Order extends Model
{
    static string $name = 'orders';

    public static function loadDish($orders): array
    {
        foreach ($orders as $index => $order) {
            $dish = Dish::where('id', $order['dish_id'])[0];
            $dish['status'] = $order['status'];
            $dish['order_id'] = $order['id'];
            $orders[$dish['class']][] = $dish;
            unset($orders[$index]);
        }
        return $orders;
    }
}