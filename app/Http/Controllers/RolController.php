<?php

namespace App\Http\Controllers;

use App\Http\Requests\RolStoreRequest;
use App\Http\Requests\RolUpdateRequest;
use App\Http\Resources\RolCollection;
use App\Http\Resources\RolResource;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RolController extends Controller
{
    public function index(Request $request): RolCollection
    {
        $rols = Rol::all();

        return new RolCollection($rols);
    }

    public function store(RolStoreRequest $request): RolResource
    {
        $rol = Rol::create($request->validated());

        return new RolResource($rol);
    }

    public function show(Request $request, Rol $rol): RolResource
    {
        return new RolResource($rol);
    }

    public function update(RolUpdateRequest $request, Rol $rol): RolResource
    {
        $rol->update($request->validated());

        return new RolResource($rol);
    }

    public function destroy(Request $request, Rol $rol): Response
    {
        $rol->delete();

        return response()->noContent();
    }
}
