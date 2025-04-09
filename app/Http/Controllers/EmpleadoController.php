<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmpleadoStoreRequest;
use App\Http\Requests\EmpleadoUpdateRequest;
use App\Http\Resources\EmpleadoCollection;
use App\Http\Resources\EmpleadoResource;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmpleadoController extends Controller
{
    public function index(Request $request): EmpleadoCollection
    {
        $empleados = Empleado::all();

        return new EmpleadoCollection($empleados);
    }

    public function store(EmpleadoStoreRequest $request): EmpleadoResource
    {
        $empleado = Empleado::create($request->validated());

        return new EmpleadoResource($empleado);
    }

    public function show(Request $request, Empleado $empleado): EmpleadoResource
    {
        return new EmpleadoResource($empleado);
    }

    public function update(EmpleadoUpdateRequest $request, Empleado $empleado): EmpleadoResource
    {
        $empleado->update($request->validated());

        return new EmpleadoResource($empleado);
    }

    public function destroy(Request $request, Empleado $empleado): Response
    {
        $empleado->delete();

        return response()->noContent();
    }
}
