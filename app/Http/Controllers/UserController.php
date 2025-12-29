<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest; // opcional, si lo deseas
use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\PlayroomResource;
use App\Http\Resources\PlayroomWithRoleResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request; // para métodos que no usan form requests

class UserController extends Controller
{
    /**
     * Mostrar la lista de usuarios.
     * GET /users
     */
    public function index()
    {
        // Cargamos usuario con address y phones (hasOne, hasMany)
        $users = User::with(['address', 'phones'])->paginate(10);

        // Devolvemos una colección de recursos
        return UserResource::collection($users);
    }

    /**
     * Crear un nuevo usuario (y su dirección y teléfono).
     * POST /users
     */
    public function store(UserStoreRequest $request)
    {
        // Usamos transacción para garantizar consistencia
        return DB::transaction(function () use ($request) {
            // 1) Creamos usuario
            $user = User::create([
                'name' => $request->input('name'),
                'firstSurname' => $request->input('firstSurname'),
                'secondSurname' => $request->input('secondSurname'),
                'email' => $request->input('email'),
                'DNI' => $request->input('DNI'),
                // Si guardas el teléfono principal en la tabla users
                // 'phone'       => $request->input('phone'),
                'password' => Hash::make($request->input('password')),
            ]);

            // 2) Crear Address en addresses
            $user->address()->create([
                'municipality' => $request->input('municipality'),
                'locality' => $request->input('locality'),
                'zip_code' => $request->input('zip_code'),
            ]);

            // 3) Crear teléfono(s) en phones
            $phonesData = $request->input('phones'); // array de arrays

            $user->phones()->createMany($phonesData);


            $token = $user->createToken('api-token')->plainTextToken;

            // Retornamos el usuario recién creado, cargando address y phones
            return response()->json([
                'user' => new UserResource($user->load(['address', 'phones'])),
                'access_token' => $token,
                'token_type' => 'Bearer',
            ], 201);
        });
    }

    public function myLudotecas(Request $request)
    {
        $user = Auth::user();

        // Eager‑load las ludotecas (belongsToMany) con pivot->role_id
        $ludotecas = $user
            ->ludotecas()
            ->withPivot('role_id')
            ->get()
            ->map(function ($l) {
                // añadimos dinámicamente el nombre del rol
                $l->pivot->role_name = $l->pivot->role->name;
                return $l;
            });

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'firstSurname' => $user->firstSurname,
                'secondSurname' => $user->secondSurname,
                'email' => $user->email,
                'DNI' => $user->DNI,
            ],
            'ludotecas' => PlayroomWithRoleResource::collection($ludotecas),
        ]);
    }

    /**
     * Mostrar un usuario en particular.
     * GET /users/{user}
     */
    public function show($id)
    {
        $user = User::with(['address', 'phones'])->findOrFail($id);
        return new UserResource($user);
    }

    /**
     * Actualizar usuario (y opcionalmente su dirección y teléfonos).
     * PUT/PATCH /users/{user}
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::findOrFail($id);

        // Usamos transacción otra vez
        return DB::transaction(function () use ($request, $user) {
            // Actualizar datos de usuario
            $dataUser = [
                'name' => $request->input('name', $user->name),
                'firstSurname' => $request->input('firstSurname', $user->firstSurname),
                'secondSurname' => $request->input('secondSurname', $user->secondSurname),
                'email' => $request->input('email', $user->email),
                'DNI' => $request->input('DNI', $user->DNI),
            ];

            // Si quieres actualizar la contraseña solo si llega en la request:
            if ($request->filled('password')) {
                $dataUser['password'] = Hash::make($request->input('password'));
            }

            $user->update($dataUser);

            // Actualizar address (si se envían datos)
            if ($user->address) {
                $user->address->update([
                    'municipality' => $request->input('municipality', $user->address->municipality),
                    'locality' => $request->input('locality', $user->address->locality),
                    'zip_code' => $request->input('zip_code', $user->address->zip_code),
                ]);
            } else {
                // En caso de no tener address y quieras crearla ahora
                $user->address()->create([
                    'municipality' => $request->input('municipality'),
                    'locality' => $request->input('locality'),
                    'zip_code' => $request->input('zip_code'),
                ]);
            }

            // Actualizar phone(s)
            // Supongamos que solo tienes uno y lo actualizas
            $phone = $user->phones->first();
            if ($phone) {
                $phone->update([
                    'primary_phone' => $request->input('primary_phone', $phone->primary_phone),
                    'backup_phone' => $request->input('backup_phone', $phone->backup_phone),
                ]);
            } else {
                // Si no existe, lo creas
                $user->phones()->create([
                    'primary_phone' => $request->input('primary_phone'),
                    'backup_phone' => $request->input('backup_phone'),
                ]);
            }

            return new UserResource($user->load(['address', 'phones']));
        });
    }

    /**
     * Eliminar usuario.
     * DELETE /users/{user}
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}
