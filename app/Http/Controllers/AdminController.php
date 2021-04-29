<?php

namespace App\Http\Controllers;

use App\Chinchilla;
use App\ChinchillaColorComment;
use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function getUsers(Request $request)
    {
        $page = $request->page ?? 1;

        return response()->json([
            'total' => User::count(),
            'page' => $page,
            'data' => User::forPage($page, $request->perPage ?? 10)->get(),
        ]);
    }

    public function updateUser($id, Request $request)
    {
        $request->validate([
            'type' => ['sometimes', 'nullable', 'string'],
            'admitted' => ['sometimes', 'nullable', 'boolean'],
        ]);
        $user = User::find($id);
        $user->update($request->all());
        return $user;
    }

    public function getChinchillas($page, $perPage)
    {
        $search = Chinchilla::with('color')->with('avatar')->with('photos')->with('colorComments')->with('owner');
        $search = $search->where('conclusion', 'not_check')->where('is_ready', true)->forPage($page, $perPage);
        return response()->json([
            'data' => $search->get()->map(function (Chinchilla $chinchilla) {
                return $chinchilla->append('children');
            }),
            'total' => $search->count(),
        ]);
    }

    public function updateChinchilla($id, Request $request)
    {
        $request->validate([
            'conclusion' => ['sometimes', 'nullable', 'string'],
        ]);
        $chinchilla = Chinchilla::find($id);
        $chinchilla->update($request->all());
        return $chinchilla;
    }

    public function createColorComment(Request $request)
    {
        $request->validate([
            'content' => ['required', 'string'],
            'chinchillaId' => ['required', 'exists:chinchillas,id']
        ]);
        return ChinchillaColorComment::create([
            'content' => $request->get('content'),
            'chinchilla_id' => $request->chinchillaId,
            'timestamp' => time() * 1000,
        ]);
    }
}
