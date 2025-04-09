<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioStoreRequest;
use App\Http\Requests\UsuarioUpdateRequest;
use App\Http\Resources\UsuarioCollection;
use App\Http\Resources\UsuarioResource;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UsuarioController extends Controller
{
    public function index(Request $request): UsuarioCollection
    {
        $usuarios = Usuario::all();

        return new UsuarioCollection($usuarios);
    }

    public function store(UsuarioStoreRequest $request): UsuarioResource
    {
        $usuario = Usuario::create($request->validated());

        return new UsuarioResource($usuario);
    }

    public function show(Request $request, Usuario $usuario): UsuarioResource
    {
        return new UsuarioResource($usuario);
    }

    public function update(UsuarioUpdateRequest $request, Usuario $usuario): UsuarioResource
    {
        $usuario->update($request->validated());

        return new UsuarioResource($usuario);
    }

    public function destroy(Request $request, Usuario $usuario): Response
    {
        $usuario->delete();

        return response()->noContent();
    }
}
