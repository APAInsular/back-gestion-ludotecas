<?php

namespace App\Http\Controllers;

use App\Http\Requests\NinoStoreRequest;
use App\Http\Requests\NinoUpdateRequest;
use App\Http\Resources\NinoCollection;
use App\Http\Resources\NinoResource;
use App\Models\Nino;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NinoController extends Controller
{
    public function index(Request $request): NinoCollection
    {
        $ninos = Nino::all();

        return new NinoCollection($ninos);
    }

    public function store(NinoStoreRequest $request): NinoResource
    {
        $nino = Nino::create($request->validated());

        return new NinoResource($nino);
    }

    public function show(Request $request, Nino $nino): NinoResource
    {
        return new NinoResource($nino);
    }

    public function update(NinoUpdateRequest $request, Nino $nino): NinoResource
    {
        $nino->update($request->validated());

        return new NinoResource($nino);
    }

    public function destroy(Request $request, Nino $nino): Response
    {
        $nino->delete();

        return response()->noContent();
    }
}
