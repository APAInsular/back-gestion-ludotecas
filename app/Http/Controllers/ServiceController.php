<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceStoreRequest;
use App\Http\Requests\ServiceUpdateRequest;
use App\Http\Resources\ServiceCollection;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ServiceController extends Controller
{
    public function index(Request $request): ServiceCollection
    {
        $services = Service::all();

        return new ServiceCollection($services);
    }

    public function store(ServiceStoreRequest $request): ServiceResource
    {
        $service = Service::create($request->validated());

        return new ServiceResource($service);
    }

    public function show(Request $request, Service $service): ServiceResource
    {
        return new ServiceResource($service);
    }

    public function update(ServiceUpdateRequest $request, Service $service): ServiceResource
    {
        $service->update($request->validated());

        return new ServiceResource($service);
    }

    public function destroy(Request $request, Service $service): Response
    {
        $service->delete();

        return response()->noContent();
    }
}
