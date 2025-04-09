<?php

namespace App\Http\Controllers;

use App\Http\Requests\IncidenciumStoreRequest;
use App\Http\Requests\IncidenciumUpdateRequest;
use App\Http\Resources\IncidenciumCollection;
use App\Http\Resources\IncidenciumResource;
use App\Models\Incidencia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class IncidenciaController extends Controller
{
    public function index(Request $request): IncidenciumCollection
    {
        $incidencia = Incidencium::all();

        return new IncidenciumCollection($incidencia);
    }

    public function store(IncidenciumStoreRequest $request): IncidenciumResource
    {
        $incidencium = Incidencium::create($request->validated());

        return new IncidenciumResource($incidencium);
    }

    public function show(Request $request, Incidencium $incidencium): IncidenciumResource
    {
        return new IncidenciumResource($incidencium);
    }

    public function update(IncidenciumUpdateRequest $request, Incidencium $incidencium): IncidenciumResource
    {
        $incidencium->update($request->validated());

        return new IncidenciumResource($incidencium);
    }

    public function destroy(Request $request, Incidencium $incidencium): Response
    {
        $incidencium->delete();

        return response()->noContent();
    }
}
