<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Assignment;
use App\Models\DiningTable;
use App\Models\Order;
use App\Policies\UserPolicy;

class UserController extends Controller {

    public static function searchIsWaiter() {
        UserPolicy::viewWaiter();
        $users = User::where('position', 'waiter');
        foreach ($users as $index => $user) {
            unset($users[$index]['account']);
            unset($users[$index]['password']);
        }
        UserController::response($users);
    }

    public static function retrieveAssignedDiningTable(){
        $assignmentTables = [];
        $assignments = Assignment::where('designee_id', $_SESSION['id'], 'is_finished', 0);
        foreach($assignments as $index => $assignment) {
            $assignmentTables[$index] = DiningTable::where('id', $assignment['dining_table_id'])[0];
            $assignmentTables[$index]['orders'] = Order::loadDish(Order::where('dining_table_id', $assignment['dining_table_id']));
        }
        UserController::response($assignmentTables);
    }
}
