<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponse;

    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ]);

            $result = $this->authService->register(
                $validatedData['name'],
                $validatedData['email'],
                $validatedData['password']
            );

            return $this->successResponse([
                'user' => $result['user']->toArray(),
                'token' => $result['token']
            ], 'User registered successfully', 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }

    public function login(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            $result = $this->authService->login(
                $validatedData['email'],
                $validatedData['password']
            );

            return $this->successResponse([
                'user' => $result['user']->toArray(),
                'token' => $result['token']
            ], 'Logged in successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 401);
        }
    }

    public function logout(Request $request)
    {
        try {
            $user = $request->user();

            if (!$user) {
                return $this->errorResponse('User not authenticated', 401);
            }

            $success = $this->authService->logout($user);

            if ($success) {
                return $this->successResponse(null, 'Logged out successfully');
            }

            return $this->errorResponse('Failed to logout', 400);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }
}
