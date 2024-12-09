<?php

namespace App\Repositories;

use App\Http\Resources\LoginResource;
use App\Http\Resources\RegisterResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthRepository
{
    public function register($data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        return (new RegisterResource($user));
    }

    public function login($data)
    {
        $credentials = [];

        if (isset($data['usernameOrEmail']) && isset($data['password'])) {
            $usernameOrEmail = $data['usernameOrEmail'];
            $field = filter_var($usernameOrEmail, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
            $credentials = [
                $field => $usernameOrEmail,
                'password' => $data['password']
            ];
        }

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('auth')->accessToken;
            $user->token = $token;
            return new LoginResource($user);
        } else {
            throw new \Exception('app.InvalidCredentials');
        }
    }
}
