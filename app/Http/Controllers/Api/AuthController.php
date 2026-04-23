<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
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

            return response()->json([
                'user' => $result['user']->toArray(),
                'token' => $result['token']
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
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

            return response()->json([
                'user' => $result['user']->toArray(),
                'token' => $result['token']
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 401);
        }
    }

    public function logout(Request $request)
    {
        try {
            $success = $this->authService->logout($request->user());

            if ($success) {
                return response()->json(['message' => 'Logged out successfully'], 200);
            }

            return response()->json(['message' => 'Failed to logout'], 400);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
