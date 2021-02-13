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
    if ($request->query('q')) {
        $searcher->where(function ($query) use ($request) {
            $query->orWhere('login', 'like', $request->query('q'))
                ->orWhere('first_name', 'like', $request->query('q'))
                ->orWhere('last_name', 'like', $request->query('q'))
                ->orWhere('patronymic', 'like', $request->query('q'));
        });
    }
    if ($perPage == 0) return $searcher->get()->makeHidden(['email', 'phone']);
    return $searcher->forPage($page, $perPage)->get()->makeHidden(['email', 'phone']);
  }

  public function details($userId)
  {
    return response()->json(User::find($userId), 200);
  }
}
