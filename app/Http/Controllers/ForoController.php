<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForoStoreRequest;
use App\Http\Requests\ForoUpdateRequest;
use App\Http\Resources\ForoCollection;
use App\Http\Resources\ForoResource;
use App\Models\Foro;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ForoController extends Controller
{
    public function index(Request $request): ForoCollection
    {
        $foros = Foro::all();

        return new ForoCollection($foros);
    }

    public function store(ForoStoreRequest $request): ForoResource
    {
        $foro = Foro::create($request->validated());

        return new ForoResource($foro);
    }

    public function show(Request $request, Foro $foro): ForoResource
    {
        return new ForoResource($foro);
    }

    public function update(ForoUpdateRequest $request, Foro $foro): ForoResource
    {
        $foro->update($request->validated());

        return new ForoResource($foro);
    }

    public function destroy(Request $request, Foro $foro): Response
    {
        $foro->delete();

        return response()->noContent();
    }
}
