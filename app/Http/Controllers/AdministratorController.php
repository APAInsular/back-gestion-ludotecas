<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdministratorStoreRequest;
use App\Http\Requests\AdministratorUpdateRequest;
use App\Http\Resources\AdministratorCollection;
use App\Http\Resources\AdministratorResource;
use App\Models\Administrator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdministratorController extends Controller
{
    public function index(Request $request): AdministratorCollection
    {
        $administrators = Administrator::all();

        return new AdministratorCollection($administrators);
    }

    public function store(AdministratorStoreRequest $request): AdministratorResource
    {
        $administrator = Administrator::create($request->validated());

        return new AdministratorResource($administrator);
    }

    public function show(Request $request, Administrator $administrator): AdministratorResource
    {
        return new AdministratorResource($administrator);
    }

    public function update(AdministratorUpdateRequest $request, Administrator $administrator): AdministratorResource
    {
        $administrator->update($request->validated());

        return new AdministratorResource($administrator);
    }

    public function destroy(Request $request, Administrator $administrator): Response
    {
        $administrator->delete();

        return response()->noContent();
    }
}
