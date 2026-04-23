<?php

namespace App\Services;

use App\Dtos\UserDTO;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    /**
     * Registrar un nuevo usuario
     *
     * @param string $name
     * @param string $email
     * @param string $password
     * @return array ['user' => UserDTO, 'token' => string]
     * @throws Exception
     */
    public function register(string $name, string $email, string $password): array
    {
        // Validar que el email no exista
        if (User::query()->where('email', $email)->exists()) {
            throw new Exception('Email already exists');
        }

        // Crear usuario
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
        ]);

        // Generar token
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => UserDTO::fromModel($user),
            'token' => $token,
        ];
    }

    /**
     * Autenticar usuario y generar token
     *
     * @param string $email
     * @param string $password
     * @return array ['user' => UserDTO, 'token' => string]
     * @throws Exception
     */
    public function login(string $email, string $password): array
    {
        // Intentar autenticar
        if (!Auth::attempt(['email' => $email, 'password' => $password])) {
            throw new Exception('Invalid login credentials');
        }

        $user = User::query()->where('email', $email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => UserDTO::fromModel($user),
            'token' => $token,
        ];
    }

    /**
     * Logout: eliminar todos los tokens del usuario
     *
     * @param User $user
     * @return bool
     */
    public function logout(User $user): bool
    {
        return $user->tokens()->delete() > 0;
    }
}
