<?php

namespace App\Http\Controllers;

use App\Chinchilla;
use App\Color;
use App\Price;
use App\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class ChinchillasController extends Controller
{

    public function addChinchilla(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'status' => ['required', 'string'],
            'is_ready' => ['required', 'boolean'],
            'birthday' => ['required', 'numeric'],
            'sex' => ['required', 'string'],
            'breeder_id' => ['sometimes', 'nullable', 'numeric', 'exists:users,id'],
            'breeder_type' => ['sometimes', 'nullable', 'string'],
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

    public function updateChinchilla($chinchilla_id, Request $request)
    {
        $data = $request->validate([
            'name' => ['sometimes', 'nullable', 'string'],
            'is_ready' => ['sometimes', 'nullable', 'boolean'],
            'birthday' => ['sometimes', 'nullable', 'numeric'],
            'sex' => ['sometimes', 'nullable', 'string'],
            'breeder_id' => ['sometimes', 'nullable',  'numeric', 'exists:users,id'],
            'breeder_type' => ['sometimes', 'nullable', 'string'],
            'mother_id' => ['sometimes', 'nullable', 'numeric', 'exists:chinchillas,id'],
            'father_id' => ['sometimes', 'nullable', 'numeric', 'exists:chinchillas,id'],
            'avatar_id' => ['sometimes', 'nullable', 'numeric', 'exists:chinchilla_photos,id'],
            'weight' => ['sometimes', 'nullable', 'string'],
            'brothers' => ['sometimes', 'nullable', 'string'],
            'awards' => ['sometimes', 'nullable', 'string'],
            'description' => ['sometimes', 'nullable', 'string'],
        ]);
        $chinchilla = Chinchilla::whereId($chinchilla_id);
        $chinchilla->update($data);
        return $chinchilla->toJson();
    }

    public function addColor($chinchilla_id, Request $request)
    {
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

    public function getChinchillaDetails($chinchilla_id, Request $request)
    {
        $chinchilla = Chinchilla::with('color')
            ->with('avatar')
            ->with('photos')
            ->with('statuses')
            ->with('colorComments')
            ->with('breeder')
            ->with('priceRub')
            ->with('priceEur')
            ->with(request()->header('Country-Code') === 'RU' ? 'owner' : 'owner:id')
            ->findOrFail($chinchilla_id)
            ->append('children')
            ->append('relatives')
            ->withParents();
        if (!is_null($chinchilla->breeder)) {
            $chinchilla->breeder->makeHidden(['email', 'phone']);
        }
        $chinchilla->statuses->each(function (Status $status) use ($request) {
            $status->append('prices');
            $status->prices->filter(function ($item) use ($request) {
                return !is_null($request->user('api'))
                    && (
                        in_array($request->user('api')->type, ['admin', 'moderator'])
                        || $item->user_id === $request->user('api')->id
                    );
            });
        });
        return $chinchilla;
    }

    public function getUserChinchillas($user_id, Request $request)
    {
        $query = Chinchilla::whereOwnerId($user_id)->with('color')->with('avatar')->with('status');
        if ((int) $user_id !== $request->user()->id) {
            $query = $query->where('conclusion', '<>', 'not_check');
        }
        return $query->get();
    }

    public function searchChinchillas(Request $request)
    {
        $params = $request->all();
        $search = Chinchilla::with('color')->with('avatar')->with('status')->with(['statuses' => function ($query) {
            return $query->limit(1);
        }]);
        if (isset($params['page'])) {
            $page = $params['page'];
        }
        if (isset($params['perPage'])) {
            $perPage = $params['perPage'];
        }
        if (isset($params['is_owner'])) {
            $isOwner = $params['is_owner'];
        }
        unset($params['page'], $params['perPage'], $params['is_owner']);
        foreach ($params as $key => $value) {
            if (in_array($key, ['sex'])) {
                $search = $search->where($key, 'like', "%$value%");
            }
            if ($key === 'status') {
                $search = $search->whereHas('statuses', function ($query) use ($value) {
                    return $query->where('name', $value)->limit(1);
                });
            }
        }
        if (isset($isOwner) && $request->user('api') !== null) {
            $search = $search->where('owner_id', $request->user('api')->id);
        } else {
            $search = $search->where('conclusion', '<>', 'not_check');
        }
        if ($request->user('api') === null) {
            $search = $search->whereHas('statuses', function ($query) {
                $query->where('statuses.name', 'sale');
            });
        }
        if (isset($page, $perPage)) {
            $search = $search->forPage($params['page'], $params['perPage']);
        }
        return response()->json([
            'data' => $search->get(),
            'total' => $search->count(),
        ]);
    }

    public function createStatus(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'chinchillaId' => ['required', 'exists:chinchillas,id'],
            'prices' => [Rule::requiredIf($request->name === 'sale')],
            'prices.*.currency' => ['required', Rule::in('RUB', 'EUR', 'USD')],
            'prices.*.value' => ['required', 'numeric'],
        ]);

        $status = Status::create([
            'name' => $request->name,
            'timestamp' => time() * 1000,
            'chinchilla_id' => $request->chinchillaId,
        ]);
        if ($request->__isset('prices')) {
            foreach ($request->prices as $price) {
                Price::create([
                    'currency' => $price['currency'],
                    'value' => $price['value'],
                    'status_id' => $status->id,
                    'chinchilla_id' => $request->chinchillaId,
                    'timestamp' => $status->timestamp,
                    'user_id' => $request->user()->id,
                ]);
            }
        }
        $status->append('prices');
        return $status;
    }

    public function colorForOvervalue($id, Request $request)
    {
        $chinchilla = Chinchilla::findOrFail($id);
        if ($chinchilla->owner_id !== $request->user()->id) {
            abort(Response::HTTP_FORBIDDEN);
        }
        $chinchilla->conclusion = 'overvalue';
        $chinchilla->save();
        return $chinchilla;
    }
}
