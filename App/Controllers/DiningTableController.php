<?php

namespace App\Controllers;

use App\Models\Assignment;
use App\Models\DiningTable;
use App\Models\Order;
use App\Models\User;
use App\Policies\AssignmentPolicy;
use App\Policies\DiningTablePolicy;
use App\Policies\OrderPolicy;

class DiningTableController extends Controller
{

    public static function search()
    {
        DiningTablePolicy::viewAny();
        $dining_tables = DiningTable::where(1);
        foreach ($dining_tables as $index => $dining_table) {
            if ($_GET['load'] == 'designee') {
                $assignments = Assignment::where('dining_table_id', $dining_table['id']);
                if ($assignments) {
                    $dining_tables[$index]['designee'] = User::where('id', $assignments[0]['designee_id'])[0];
                    unset($dining_tables[$index]['designee']['account']);
                    unset($dining_tables[$index]['designee']['password']);
                }
            } else if ($_GET['load'] == 'orders') {
                $dining_tables[$index]['orders'] = Order::loadDish(Order::where('dining_table_id', $dining_table['id']));
            }
        }
        DiningTableController::response($dining_tables);
    }

    public static function assignDesignee($request)
    {
        DiningTablePolicy::update();
        DiningTable::update(
            ['status' => 'on-seat'],
            ['id' => $request['id']]
        );
        AssignmentPolicy::create();
        Assignment::save([
            'dining_table_id' => $request['id'],
            'designee_id' => $request['designee_id']
        ]);
    }

    public static function retrieve()
    {
        DiningTablePolicy::view();
        DiningTableController::response(DiningTable::where('id', $_GET['dining_table_id'])[0]);
    }

    public static function addOrder($request) {
        OrderPolicy::create();
        $classes = ['appetizer', 'soup', 'main_course', 'dessert', 'beverage'];
        foreach ($classes as $class) {
            foreach ($request[$class] as $dish_id) {
                Order::save([
                    'dining_table_id' => $_GET['dining_table_id'],
                    'dish_id' => $dish_id
                ]);
            }
        }
    }

    public static function update($request) {
        DiningTablePolicy::update();
        DiningTable::update(
            ['status' => $request['status']],
            ['id' => $request['dining_table_id']]
        );
    }
}
