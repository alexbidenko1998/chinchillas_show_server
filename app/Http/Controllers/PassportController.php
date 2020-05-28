<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Lcobucci\JWT\Parser;

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
            'phone' => $request->login,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'patronymic' => $request->email,
            'country' => $request->login,
            'city' => $request->email,
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
}
