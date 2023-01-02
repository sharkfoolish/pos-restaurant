<?php

namespace App\Controllers;

use App\Models\User;
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
}
