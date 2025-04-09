<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActividadStoreRequest;
use App\Http\Requests\ActividadUpdateRequest;
use App\Http\Resources\ActividadCollection;
use App\Http\Resources\ActividadResource;
use App\Models\Actividad;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ActividadController extends Controller
{
    public function index(Request $request): ActividadCollection
    {
        $actividads = Actividad::all();

        return new ActividadCollection($actividads);
    }

    public function store(ActividadStoreRequest $request): ActividadResource
    {
        $actividad = Actividad::create($request->validated());

        return new ActividadResource($actividad);
    }

    public function show(Request $request, Actividad $actividad): ActividadResource
    {
        return new ActividadResource($actividad);
    }

    public function update(ActividadUpdateRequest $request, Actividad $actividad): ActividadResource
    {
        $actividad->update($request->validated());

        return new ActividadResource($actividad);
    }

    public function destroy(Request $request, Actividad $actividad): Response
    {
        $actividad->delete();

        return response()->noContent();
    }
}
