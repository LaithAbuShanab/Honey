<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Repositories\AuthRepository;

class AuthController extends Controller
{
    public function __construct(protected AuthRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(UserRegisterRequest $request)
    {
        try {
            $user = $this->userRepository->register($request->validated());
            return ApiResponse::sendResponse(200, __('app.userSuccessfully'), $user);
        } catch (\Exception $e) {
            return ApiResponse::sendResponseError(401, $e->getMessage());
        }
    }

    public function login(UserLoginRequest $request)
    {
        try {
            $user = $this->userRepository->login($request->validated());
            return ApiResponse::sendResponse(200, __('app.loginSuccessfully'), $user);
        } catch (\Exception $e) {
            return ApiResponse::sendResponseError(401, $e->getMessage());
        }
    }

    public function logout()
    {
        try {
            auth()->user()->tokens()->delete();
            return ApiResponse::sendResponse(200, __('app.logoutSuccessfully'));
        } catch (\Exception $e) {
            return ApiResponse::sendResponseError(401, $e->getMessage());
        }
    }
}
