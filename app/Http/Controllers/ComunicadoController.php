<?php

namespace App\Http\Controllers;

use App\Http\Requests\ComunicadoStoreRequest;
use App\Http\Requests\ComunicadoUpdateRequest;
use App\Http\Resources\ComunicadoCollection;
use App\Http\Resources\ComunicadoResource;
use App\Models\Comunicado;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ComunicadoController extends Controller
{
    public function index(Request $request): ComunicadoCollection
    {
        $comunicados = Comunicado::all();

        return new ComunicadoCollection($comunicados);
    }

    public function store(ComunicadoStoreRequest $request): ComunicadoResource
    {
        $comunicado = Comunicado::create($request->validated());

        return new ComunicadoResource($comunicado);
    }

    public function show(Request $request, Comunicado $comunicado): ComunicadoResource
    {
        return new ComunicadoResource($comunicado);
    }

    public function update(ComunicadoUpdateRequest $request, Comunicado $comunicado): ComunicadoResource
    {
        $comunicado->update($request->validated());

        return new ComunicadoResource($comunicado);
    }

    public function destroy(Request $request, Comunicado $comunicado): Response
    {
        $comunicado->delete();

        return response()->noContent();
    }
}
