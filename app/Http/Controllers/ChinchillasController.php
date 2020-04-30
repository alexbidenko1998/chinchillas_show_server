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
            'weight' => ['sometimes', 'string'],
            'brothers' => ['sometimes', 'string'],
            'awards' => ['sometimes', 'string'],
            'description' => ['sometimes', 'string'],
        ]);
        $chinchilla['owner_id'] = $request->user()->id;
        return Chinchilla::create($chinchilla);
    }

    function addColor($chinchilla_id, Request $request) {
        $color = $request->validate([
            'id' => ['numeric'],
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
        return Color::updateOrCreate($color);
    }

    function getUserChinchillas($user_id) {
        return Chinchilla::whereOwnerId($user_id)->get();
    }
}
