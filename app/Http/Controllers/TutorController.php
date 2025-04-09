<?php

namespace App\Http\Controllers;

use App\Http\Requests\TutorStoreRequest;
use App\Http\Requests\TutorUpdateRequest;
use App\Http\Resources\TutorCollection;
use App\Http\Resources\TutorResource;
use App\Models\Tutor;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TutorController extends Controller
{
    public function index(Request $request): TutorCollection
    {
        $tutors = Tutor::all();

        return new TutorCollection($tutors);
    }

    public function store(TutorStoreRequest $request): TutorResource
    {
        $tutor = Tutor::create($request->validated());

        return new TutorResource($tutor);
    }

    public function show(Request $request, Tutor $tutor): TutorResource
    {
        return new TutorResource($tutor);
    }

    public function update(TutorUpdateRequest $request, Tutor $tutor): TutorResource
    {
        $tutor->update($request->validated());

        return new TutorResource($tutor);
    }

    public function destroy(Request $request, Tutor $tutor): Response
    {
        $tutor->delete();

        return response()->noContent();
    }
}
