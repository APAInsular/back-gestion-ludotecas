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
        // 1) Validar los datos de inicio de sesión
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        // 2) Intentar obtener el usuario
        //    Nota: Podrías usar Auth::attempt($credentials), pero
        //    en APIs a veces se busca manualmente al usuario.
        $user = User::where('email', $credentials['email'])->first();

        // 3) Verificar si existe y si la contraseña es correcta
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'message' => 'Credenciales inválidas',
            ], 401);
        }

        // 4) Generar el token con Sanctum
        $token = $user->createToken('api-token')->plainTextToken;

        // 5) Devolver el token y, si deseas, info básica del usuario
        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                // etc.
            ],
            'access_token' => $token,
            'token_type' => 'Bearer'
        ], 200);
    }
}
