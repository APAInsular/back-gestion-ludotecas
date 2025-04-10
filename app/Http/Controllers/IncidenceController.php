<?php

namespace App\Http\Controllers;

use App\Http\Requests\IncidenceStoreRequest;
use App\Http\Requests\IncidenceUpdateRequest;
use App\Http\Resources\IncidenceCollection;
use App\Http\Resources\IncidenceResource;
use App\Models\Incidence;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class IncidenceController extends Controller
{
    public function index(Request $request): IncidenceCollection
    {
        $incidences = Incidence::all();

        return new IncidenceCollection($incidences);
    }

    public function store(IncidenceStoreRequest $request): IncidenceResource
    {
        $incidence = Incidence::create($request->validated());

        return new IncidenceResource($incidence);
    }

    public function show(Request $request, Incidence $incidence): IncidenceResource
    {
        return new IncidenceResource($incidence);
    }

    public function update(IncidenceUpdateRequest $request, Incidence $incidence): IncidenceResource
    {
        $incidence->update($request->validated());

        return new IncidenceResource($incidence);
    }

    public function destroy(Request $request, Incidence $incidence): Response
    {
        $incidence->delete();

        return response()->noContent();
    }
}
