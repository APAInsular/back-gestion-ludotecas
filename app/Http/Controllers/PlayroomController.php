<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlayroomStoreRequest;
use App\Http\Requests\PlayroomUpdateRequest;
use App\Http\Resources\PlayroomCollection;
use App\Http\Resources\PlayroomResource;
use App\Models\Playroom;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PlayroomController extends Controller
{
    public function index(Request $request): PlayroomCollection
    {
        $playrooms = Playroom::all();

        return new PlayroomCollection($playrooms);
    }

    public function store(PlayroomStoreRequest $request): PlayroomResource
    {
        $playroom = Playroom::create($request->validated());

        return new PlayroomResource($playroom);
    }

    public function show(Request $request, Playroom $playroom): PlayroomResource
    {
        return new PlayroomResource($playroom);
    }

    public function update(PlayroomUpdateRequest $request, Playroom $playroom): PlayroomResource
    {
        $playroom->update($request->validated());

        return new PlayroomResource($playroom);
    }

    public function destroy(Request $request, Playroom $playroom): Response
    {
        $playroom->delete();

        return response()->noContent();
    }
}
