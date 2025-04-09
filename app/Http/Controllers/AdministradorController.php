<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdministradorStoreRequest;
use App\Http\Requests\AdministradorUpdateRequest;
use App\Http\Resources\AdministradorCollection;
use App\Http\Resources\AdministradorResource;
use App\Models\Administrador;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdministradorController extends Controller
{
    public function index(Request $request): AdministradorCollection
    {
        $administradors = Administrador::all();

        return new AdministradorCollection($administradors);
    }

    public function store(AdministradorStoreRequest $request): AdministradorResource
    {
        $administrador = Administrador::create($request->validated());

        return new AdministradorResource($administrador);
    }

    public function show(Request $request, Administrador $administrador): AdministradorResource
    {
        return new AdministradorResource($administrador);
    }

    public function update(AdministradorUpdateRequest $request, Administrador $administrador): AdministradorResource
    {
        $administrador->update($request->validated());

        return new AdministradorResource($administrador);
    }

    public function destroy(Request $request, Administrador $administrador): Response
    {
        $administrador->delete();

        return response()->noContent();
    }
}
