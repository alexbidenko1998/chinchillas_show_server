<?php

namespace App\Http\Controllers;

use App\Chinchilla;
use App\Color;
use App\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ChinchillasController extends Controller
{

    function addChinchilla(Request $request) {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'status' => ['required', 'string'],
            'is_ready' => ['required', 'boolean'],
            'birthday' => ['required', 'numeric'],
            'sex' => ['required', 'string'],
            'breeder_id' => ['sometimes', 'nullable', 'numeric', 'exists:users,id'],
            'mother_id' => ['sometimes', 'nullable', 'numeric', 'exists:chinchillas,id'],
            'father_id' => ['sometimes', 'nullable', 'numeric', 'exists:chinchillas,id'],
            'weight' => ['sometimes', 'nullable', 'string'],
            'brothers' => ['sometimes', 'nullable', 'string'],
            'awards' => ['sometimes', 'nullable', 'string'],
            'description' => ['sometimes', 'nullable', 'string'],
        ]);
        $data['owner_id'] = $request->user()->id;
        $status = $data['status'];
        unset($data['status']);
        $chinchilla = Chinchilla::create($data);
        Status::create([
            'name' => $status,
            'timestamp' => time() * 1000,
            'chinchilla_id' => $chinchilla->id,
        ]);
        Color::create([
            'chinchilla_id' => $chinchilla->id,
        ]);
        return $chinchilla;
    }

    function updateChinchilla($chinchilla_id, Request $request) {
        $data = $request->validate([
            'name' => ['sometimes', 'nullable', 'string'],
            'is_ready' => ['sometimes', 'nullable', 'boolean'],
            'birthday' => ['sometimes', 'nullable', 'numeric'],
            'sex' => ['sometimes', 'nullable', 'string'],
            'breeder_id' => ['sometimes', 'nullable',  'numeric', 'exists:users,id'],
            'mother_id' => ['sometimes', 'nullable', 'numeric', 'exists:chinchillas,id'],
            'father_id' => ['sometimes', 'nullable', 'numeric', 'exists:chinchillas,id'],
            'avatar_id' => ['sometimes', 'nullable', 'numeric', 'exists:chinchilla_photos,id'],
            'weight' => ['sometimes', 'nullable', 'string'],
            'brothers' => ['sometimes', 'nullable', 'string'],
            'awards' => ['sometimes', 'nullable', 'string'],
            'description' => ['sometimes', 'nullable', 'string'],
        ]);
        Chinchilla::whereId($chinchilla_id)->update($data);
    }

    function addColor($chinchilla_id, Request $request) {
        $color = $request->validate([
            'standard' => ['string'],
            'white' => ['string'],
            'mosaic' => ['string'],
            'beige' => ['string'],
            'violet' => ['string'],
            'sapphire' => ['string'],
            'angora' => ['string'],
            'ebony' => ['string'],
            'velvet' => ['string'],
            'pearl' => ['string'],
            'california' => ['string'],
            'rex' => ['string'],
            'lova' => ['string'],
            'german' => ['string'],
            'blue' => ['string'],
            'fur' => ['string'],
        ]);
        $color['chinchilla_id'] = $chinchilla_id;
        return Color::updateOrCreate(['chinchilla_id' => $chinchilla_id], $color);
    }

    function getChinchillaDetails($chinchilla_id) {
        return Chinchilla::with('color')
            ->with('avatar')
            ->with('photos')
            ->with('statuses')
            ->with('colorComments')
            ->with('owner')
            ->find($chinchilla_id)
            ->append('children')
            ->append('relatives')
            ->withParents();
    }

    function getUserChinchillas($user_id, Request $request) {
        $query = Chinchilla::whereOwnerId($user_id)->with('color')->with('avatar')->with('status');
        if ($user_id != $request->user()->id) $query = $query->where('conclusion', '<>', 'not_check');
        return $query->get();
    }

    function searchChinchillas(Request $request) {
        $search = Chinchilla::with('color')->with('avatar');
        $params = $request->all();
        if (isset($params['page'])) $page = $params['page'];
        if (isset($params['perPage'])) $perPage = $params['perPage'];
        unset($params['page']);
        unset($params['perPage']);
        foreach ($params as $key => $value) {
            $search = $search->where($key, 'like', "%{$value}%");
        }
        $search = $search->where(function ($query) use ($request) {
            $query->orWhere('conclusion', '<>', 'not_check')->orWhere('owner_id', $request->user()->id);
        });
        if (isset($page) && isset($perPage)) {
            $search = $search->forPage($params['page'], $params['perPage']);
        }
        return response()->json([
            'data' => $search->get(),
            'total' => $search->count(),
        ]);
    }

    function createStatus(Request $request) {
        $request->validate([
            'name' => ['required', 'string'],
            'chinchillaId' => ['required', 'exists:chinchillas,id'],
        ]);
        return Status::create([
            'name' => $request->name,
            'timestamp' => time() * 1000,
            'chinchilla_id' => $request->chinchillaId,
        ]);
    }

    function colorForOvervalue($id, Request $request) {
        $chinchilla = Chinchilla::findOrFail($id);
        if ($chinchilla->owner_id != $request->user()->id) abort(Response::HTTP_FORBIDDEN);
        $chinchilla->conclusion = 'overvalue';
        $chinchilla->save();
        return $chinchilla;
    }
}
