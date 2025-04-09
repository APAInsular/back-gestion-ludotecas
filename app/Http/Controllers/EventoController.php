<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventoStoreRequest;
use App\Http\Requests\EventoUpdateRequest;
use App\Http\Resources\EventoCollection;
use App\Http\Resources\EventoResource;
use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EventoController extends Controller
{
    public function index(Request $request): EventoCollection
    {
        $eventos = Evento::all();

        return new EventoCollection($eventos);
    }

    public function store(EventoStoreRequest $request): EventoResource
    {
        $evento = Evento::create($request->validated());

        return new EventoResource($evento);
    }

    public function show(Request $request, Evento $evento): EventoResource
    {
        return new EventoResource($evento);
    }

    public function update(EventoUpdateRequest $request, Evento $evento): EventoResource
    {
        $evento->update($request->validated());

        return new EventoResource($evento);
    }

    public function destroy(Request $request, Evento $evento): Response
    {
        $evento->delete();

        return response()->noContent();
    }
}
