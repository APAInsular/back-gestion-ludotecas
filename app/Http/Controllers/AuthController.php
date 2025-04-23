<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Inicia sesión y devuelve un token.
     */
    public function login(Request $request)
    {
        // 1) Validar credenciales
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        // 2) Buscar usuario
        $user = User::where('email', $credentials['email'])->first();

        // 3) Verificar contraseña
        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'message' => 'Credenciales inválidas',
            ], 401);
        }

        // 4) Generar token Sanctum
        $token = $user->createToken('api-token')->plainTextToken;

        // 5) Comprobar si existe registro en employees y en tutors
        $isEmployee = $user->employee()->exists();
        $isTutor    = $user->tutor()->exists();

        // 6) Respuesta
        return response()->json([
            'user' => [
                'id'             => $user->id,
                'name'           => $user->name,
                'firstSurname'   => $user->firstSurname,
                'secondSurname'  => $user->secondSurname,
                'email'          => $user->email,
                'DNI'            => $user->DNI,
                'is_employee'    => $isEmployee,
                'is_tutor'       => $isTutor,
            ],
            'access_token'  => $token,
            'token_type'    => 'Bearer',
        ], 200);
    }
}
