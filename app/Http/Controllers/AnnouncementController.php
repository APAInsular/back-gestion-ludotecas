<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnnouncementStoreRequest;
use App\Http\Requests\AnnouncementUpdateRequest;
use App\Http\Resources\AnnouncementCollection;
use App\Http\Resources\AnnouncementResource;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AnnouncementController extends Controller
{
    public function index(Request $request): AnnouncementCollection
    {
        $announcements = Announcement::all();

        return new AnnouncementCollection($announcements);
    }

    public function store(AnnouncementStoreRequest $request): AnnouncementResource
    {
        $announcement = Announcement::create($request->validated());

        return new AnnouncementResource($announcement);
    }

    public function show(Request $request, Announcement $announcement): AnnouncementResource
    {
        return new AnnouncementResource($announcement);
    }

    public function update(AnnouncementUpdateRequest $request, Announcement $announcement): AnnouncementResource
    {
        $announcement->update($request->validated());

        return new AnnouncementResource($announcement);
    }

    public function destroy(Request $request, Announcement $announcement): Response
    {
        $announcement->delete();

        return response()->noContent();
    }
}
