<?php

namespace App\Controllers;

use App\Models\Dish;
use App\Policies\DishPolicy;

class DishController extends Controller
{
    public static function search() {
        DishPolicy::viewAny();
        $data = [];
        $dishes = Dish::where(1);
        foreach ($dishes as $dish) {
            $data[$dish['class']][] = $dish;
        }
        DishController::response($data);
    }
}