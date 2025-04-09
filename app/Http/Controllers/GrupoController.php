<?php

namespace App\Http\Controllers;

use App\Http\Requests\GrupoStoreRequest;
use App\Http\Requests\GrupoUpdateRequest;
use App\Http\Resources\GrupoCollection;
use App\Http\Resources\GrupoResource;
use App\Models\Grupo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GrupoController extends Controller
{
    public function index(Request $request): GrupoCollection
    {
        $grupos = Grupo::all();

        return new GrupoCollection($grupos);
    }

    public function store(GrupoStoreRequest $request): GrupoResource
    {
        $grupo = Grupo::create($request->validated());

        return new GrupoResource($grupo);
    }

    public function show(Request $request, Grupo $grupo): GrupoResource
    {
        return new GrupoResource($grupo);
    }

    public function update(GrupoUpdateRequest $request, Grupo $grupo): GrupoResource
    {
        $grupo->update($request->validated());

        return new GrupoResource($grupo);
    }

    public function destroy(Request $request, Grupo $grupo): Response
    {
        $grupo->delete();

        return response()->noContent();
    }
}
