<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActivityStoreRequest;
use App\Http\Requests\ActivityUpdateRequest;
use App\Http\Resources\ActivityCollection;
use App\Http\Resources\ActivityResource;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ActivityController extends Controller
{
    public function index(Request $request): ActivityCollection
    {
        $activities = Activity::all();

        return new ActivityCollection($activities);
    }

    public function store(ActivityStoreRequest $request): ActivityResource
    {
        $activity = Activity::create($request->validated());

        return new ActivityResource($activity);
    }

    public function show(Request $request, Activity $activity): ActivityResource
    {
        return new ActivityResource($activity);
    }

    public function update(ActivityUpdateRequest $request, Activity $activity): ActivityResource
    {
        $activity->update($request->validated());

        return new ActivityResource($activity);
    }

    public function destroy(Request $request, Activity $activity): Response
    {
        $activity->delete();

        return response()->noContent();
    }
}
