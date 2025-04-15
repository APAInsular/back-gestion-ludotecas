<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlayroomStoreRequest;
use App\Http\Requests\PlayroomUpdateRequest;
use App\Http\Resources\PlayroomCollection;
use App\Http\Resources\PlayroomResource;
use App\Models\Playroom;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PlayroomController extends Controller
{
    public function index(Request $request): PlayroomCollection
    {
        $playrooms = Playroom::all();

        return new PlayroomCollection($playrooms);
    }
    public function store(PlayroomStoreRequest $request)
    {
        return DB::transaction(function () use ($request) {
            // 1) Crear la playroom en la tabla 'playrooms'
            $playroom = Playroom::create([
                'name' => $request->input('name'),
                'address' => $request->input('address'),  // si se usa, aunque ahora la dirección detallada se guarda en otra tabla
                'email' => $request->input('email'),
                'description' => $request->input('description'),
            ]);

            // 2) Crear la dirección en 'addresses_playroom'
            $playroom->address()->create([
                'street' => $request->input('street'),
                'locality' => $request->input('locality'),   // Opcional
                'municipality' => $request->input('municipality'),
                'province' => $request->input('province'), // Opcional
                'zip_code' => $request->input('zip_code'),
                'country' => $request->input('country'), // Opcional
            ]);

            // 3) Si también tienes teléfonos asociados, se pueden crear aquí (como antes)
            if ($request->filled('phones')) {
                $phones = $request->input('phones'); // Array de teléfonos
                $playroom->phones()->createMany($phones);
            }

            // Retornar la playroom creada, opcionalmente cargando las relaciones
            return new PlayroomResource($playroom->load('address', 'phones'));
        });
    }

    public function show(Request $request, Playroom $playroom): PlayroomResource
    {
        return new PlayroomResource($playroom);
    }

    public function update(PlayroomUpdateRequest $request, Playroom $playroom): PlayroomResource
    {
        $playroom->update($request->validated());

        return new PlayroomResource($playroom);
    }

    public function destroy(Request $request, Playroom $playroom): Response
    {
        $playroom->delete();

        return response()->noContent();
    }
}
