<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{

  function searchUsers(Request $request) {
    return $this->searchUsersPaginate(0, 0, $request);
  }

  function searchUsersPaginate($page, $perPage, Request $request) {
    $searcher = User::query();
    if ($request->query('login')) $searcher->where('login', 'like', $request->query('login'));
    if ($perPage == 0) return $searcher->get();
    return $searcher->forPage($page, $perPage);
  }

  public function details($userId)
  {
    return response()->json(User::find($userId), 200);
  }
}
