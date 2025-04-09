<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServicioStoreRequest;
use App\Http\Requests\ServicioUpdateRequest;
use App\Http\Resources\ServicioCollection;
use App\Http\Resources\ServicioResource;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ServicioController extends Controller
{
    public function index(Request $request): ServicioCollection
    {
        $servicios = Servicio::all();

        return new ServicioCollection($servicios);
    }

    public function store(ServicioStoreRequest $request): ServicioResource
    {
        $servicio = Servicio::create($request->validated());

        return new ServicioResource($servicio);
    }

    public function show(Request $request, Servicio $servicio): ServicioResource
    {
        return new ServicioResource($servicio);
    }

    public function update(ServicioUpdateRequest $request, Servicio $servicio): ServicioResource
    {
        $servicio->update($request->validated());

        return new ServicioResource($servicio);
    }

    public function destroy(Request $request, Servicio $servicio): Response
    {
        $servicio->delete();

        return response()->noContent();
    }
}
