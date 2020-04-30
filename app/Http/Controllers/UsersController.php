<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    function searchUsers($page, $perPage, Request $request) {
        $searcher = User::query();
        if ($request->query('login')) $searcher->where('login', $request->query('login'));
        return $searcher->forPage($page, $perPage);
    }
}
