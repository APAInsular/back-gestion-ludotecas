<?php

namespace App\Http\Controllers;

use App\Http\Requests\KidStoreRequest;
use App\Http\Requests\KidUpdateRequest;
use App\Http\Resources\KidCollection;
use App\Http\Resources\KidResource;
use App\Models\Kid;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class KidController extends Controller
{
    public function index(Request $request): KidCollection
    {
        $kids = Kid::all();

        return new KidCollection($kids);
    }

    public function store(KidStoreRequest $request): KidResource
    {
        $kid = Kid::create($request->validated());

        return new KidResource($kid);
    }

    public function show(Request $request, Kid $kid): KidResource
    {
        return new KidResource($kid);
    }

    public function update(KidUpdateRequest $request, Kid $kid): KidResource
    {
        $kid->update($request->validated());

        return new KidResource($kid);
    }

    public function destroy(Request $request, Kid $kid): Response
    {
        $kid->delete();

        return response()->noContent();
    }
}
