<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Storage;
use Lcobucci\JWT\Parser;
use Str;

class PassportController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'login' => 'required|min:6',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'phone' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'patronymic' => 'required|string',
            'country' => 'required|string',
            'city' => 'required|string',
        ]);

        $user = User::create([
            'login' => $request->login,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'patronymic' => $request->patronymic,
            'country' => $request->country,
            'city' => $request->city,
            'registration_date' => time() * 1000,
        ]);

        $token = $user->createToken('Chinchillas-Show')->accessToken;

        return response()->json([
            'token' => $token,
            'user' => $user
        ], 200);
    }

    public function login(Request $request)
    {
        $credentials = [
            'login' => $request->login,
            'password' => $request->password
        ];

        if (auth()->attempt($credentials)) {
            $token = auth()->user()->createToken('Chinchillas-Show')->accessToken;

            return response()->json([
                'token' => $token,
                'user' => auth()->user()
            ], 200);
        } else {
            return response()->json(['error' => 'UnAuthorised'], 401);
        }
    }

    public function details()
    {
        return response()->json(['user' => auth()->user()], 200);
    }

    public function logout(Request $request)
    {
        $value = $request->bearerToken();
        $id = (new Parser())->parse($value)->getHeader('jti');
        $token = $request->user()->tokens->find($id);
        $token->revoke();
        return response('You have been successfully logged out!', 200);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'avatar' => ['sometimes', 'nullable', 'file', 'mimetypes:image/*'],
            'first_name' => ['sometimes', 'nullable', 'string'],
            'last_name' => ['sometimes', 'nullable', 'string'],
            'patronymic' => ['sometimes', 'nullable', 'string'],
            'country' => ['sometimes', 'nullable', 'string'],
            'city' => ['sometimes', 'nullable', 'string'],
        ]);

        if (isset($data['avatar'])) {
            $filename = time() . '_' . Str::random() . '.' . $request->file('avatar')->getClientOriginalExtension();
            $request->file('avatar')->storeAs('users/' . auth()->user()->id . '/', $filename, 'public_photos');
            $data['avatar'] = $filename;
        }

        $user = User::find(auth()->user()->id);
        if ($user->avatar)
            Storage::disk('public_photos')->delete('users/' . auth()->user()->id . '/' . $user->avatar);
        foreach ($data as $key => $value) {
            $user->{$key} = $value;
        }
        $user->save();
        return $user;
    }

    function resetPassword($email, Request $request) {
        User::whereEmail($email)->update([
            'password' => bcrypt($request->password),
        ]);
        return true;
    }
}
