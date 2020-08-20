<?php

namespace App\Http\Controllers;

use App\Chinchilla;
use App\ChinchillaPhoto;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PhotosController extends Controller
{
    function upload($chinchilla_id, Request $request) {
        $chinchilla = Chinchilla::where(['id' => $chinchilla_id, 'owner_id' => $request->user()->id])->firstOr(function () {
            abort(Response::HTTP_FORBIDDEN);
        });

        $request->validate([
            'photo' => ['required', 'file', 'dimensions:max_width=4096,max_height=4096', 'mimetypes:image/*'],
        ]);

        $filename = time() . '_' . Str::random() . '.' . $request->file('photo')->getClientOriginalExtension();
        $request->file('photo')->storeAs('chinchillas/' . $chinchilla->owner_id . '/' . $chinchilla_id . '/', $filename, 'public_photos');

        return ChinchillaPhoto::create([
            'chinchilla_id' => $chinchilla_id,
            'name' => $filename,
        ]);
    }

    function delete($photo_id, Request $request) {
        $photo = ChinchillaPhoto::findOrFail($photo_id);
        $chinchilla = Chinchilla::where(['id' => $photo->chinchilla_id, 'owner_id' => $request->user()->id])->firstOr(function () {
            abort(Response::HTTP_FORBIDDEN);
        });

        Storage::disk('public_photos')->delete('chinchillas/' . $chinchilla->owner_id . '/' . $chinchilla->id . '/' . $photo->name);
        $photo->forceDelete();

        if ($chinchilla->avatar_id == $photo_id) {
            $chinchilla->avatar_id = null;
            $chinchilla->save();
        }

        return Response::HTTP_OK;
    }
}
