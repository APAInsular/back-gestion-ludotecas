<?php

namespace App\Http\Controllers;

use App\Http\Requests\LudotecaStoreRequest;
use App\Http\Requests\LudotecaUpdateRequest;
use App\Http\Resources\LudotecaCollection;
use App\Http\Resources\LudotecaResource;
use App\Models\Ludoteca;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LudotecaController extends Controller
{
    public function index(Request $request): LudotecaCollection
    {
        $ludotecas = Ludoteca::all();

        return new LudotecaCollection($ludotecas);
    }

    public function store(LudotecaStoreRequest $request): LudotecaResource
    {
        $ludoteca = Ludoteca::create($request->validated());

        return new LudotecaResource($ludoteca);
    }

    public function show(Request $request, Ludoteca $ludoteca): LudotecaResource
    {
        return new LudotecaResource($ludoteca);
    }

    public function update(LudotecaUpdateRequest $request, Ludoteca $ludoteca): LudotecaResource
    {
        $ludoteca->update($request->validated());

        return new LudotecaResource($ludoteca);
    }

    public function destroy(Request $request, Ludoteca $ludoteca): Response
    {
        $ludoteca->delete();

        return response()->noContent();
    }
}
