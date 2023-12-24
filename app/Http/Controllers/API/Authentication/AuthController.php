<?php

namespace App\Http\Controllers\API\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginAuthRequest;
use App\Http\Requests\RegisterAuthRequest;
use App\Services\AuthService;
use App\Services\UserService;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['login', 'register']]);
    }

    public function login(LoginAuthRequest $request, AuthService $authService)
    {
        return $authService->login($request);
    }

    public function register(RegisterAuthRequest $request, UserService $userService)
    {
        return $userService->register($request);
    }

    public function logout(AuthService $authService)
    {
        return $authService->logout();
    }
}
