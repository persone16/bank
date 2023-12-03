<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Вывести всех пользователя
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function users()
    {
        return User::all();
    }
}
