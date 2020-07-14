<?php

namespace App\Http\Controllers;

use App\Chinchilla;
use App\Color;
use Illuminate\Http\Request;

class ChinchillasController extends Controller
{

    function addChinchilla(Request $request) {
        $chinchilla = $request->validate([
            'name' => ['required', 'string'],
            'status' => ['required', 'string'],
            'is_ready' => ['required', 'boolean'],
            'birthday' => ['required', 'numeric'],
            'sex' => ['required', 'string'],
            'breeder_id' => ['sometimes', 'numeric', 'exists:users,id'],
            'weight' => ['sometimes', 'nullable', 'string'],
            'brothers' => ['sometimes', 'nullable', 'string'],
            'awards' => ['sometimes', 'nullable', 'string'],
            'description' => ['sometimes', 'nullable', 'string'],
        ]);
        $chinchilla['owner_id'] = $request->user()->id;
        return Chinchilla::create($chinchilla);
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
        return Chinchilla::with('color')->with('avatar')->with('photos')->find($chinchilla_id);
    }

    function getUserChinchillas($user_id) {
        return Chinchilla::whereOwnerId($user_id)->with('avatar')->get();
    }

    function searchChinchillas() {
        return Chinchilla::with('avatar')->get();
    }
}
