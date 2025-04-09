<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConfiguracionStoreRequest;
use App\Http\Requests\ConfiguracionUpdateRequest;
use App\Http\Resources\ConfiguracionCollection;
use App\Http\Resources\ConfiguracionResource;
use App\Models\Configuracion;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ConfiguracionController extends Controller
{
    public function index(Request $request): ConfiguracionCollection
    {
        $configuracions = Configuracion::all();

        return new ConfiguracionCollection($configuracions);
    }

    public function store(ConfiguracionStoreRequest $request): ConfiguracionResource
    {
        $configuracion = Configuracion::create($request->validated());

        return new ConfiguracionResource($configuracion);
    }

    public function show(Request $request, Configuracion $configuracion): ConfiguracionResource
    {
        return new ConfiguracionResource($configuracion);
    }

    public function update(ConfiguracionUpdateRequest $request, Configuracion $configuracion): ConfiguracionResource
    {
        $configuracion->update($request->validated());

        return new ConfiguracionResource($configuracion);
    }

    public function destroy(Request $request, Configuracion $configuracion): Response
    {
        $configuracion->delete();

        return response()->noContent();
    }
}
