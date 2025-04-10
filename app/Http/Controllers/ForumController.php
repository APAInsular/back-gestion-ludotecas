<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForumStoreRequest;
use App\Http\Requests\ForumUpdateRequest;
use App\Http\Resources\ForumCollection;
use App\Http\Resources\ForumResource;
use App\Models\Forum;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ForumController extends Controller
{
    public function index(Request $request): ForumCollection
    {
        $forums = Forum::all();

        return new ForumCollection($forums);
    }

    public function store(ForumStoreRequest $request): ForumResource
    {
        $forum = Forum::create($request->validated());

        return new ForumResource($forum);
    }

    public function show(Request $request, Forum $forum): ForumResource
    {
        return new ForumResource($forum);
    }

    public function update(ForumUpdateRequest $request, Forum $forum): ForumResource
    {
        $forum->update($request->validated());

        return new ForumResource($forum);
    }

    public function destroy(Request $request, Forum $forum): Response
    {
        $forum->delete();

        return response()->noContent();
    }
}
