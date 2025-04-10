<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConfigurationStoreRequest;
use App\Http\Requests\ConfigurationUpdateRequest;
use App\Http\Resources\ConfigurationCollection;
use App\Http\Resources\ConfigurationResource;
use App\Models\Configuration;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ConfigurationController extends Controller
{
    public function index(Request $request): ConfigurationCollection
    {
        $configurations = Configuration::all();

        return new ConfigurationCollection($configurations);
    }

    public function store(ConfigurationStoreRequest $request): ConfigurationResource
    {
        $configuration = Configuration::create($request->validated());

        return new ConfigurationResource($configuration);
    }

    public function show(Request $request, Configuration $configuration): ConfigurationResource
    {
        return new ConfigurationResource($configuration);
    }

    public function update(ConfigurationUpdateRequest $request, Configuration $configuration): ConfigurationResource
    {
        $configuration->update($request->validated());

        return new ConfigurationResource($configuration);
    }

    public function destroy(Request $request, Configuration $configuration): Response
    {
        $configuration->delete();

        return response()->noContent();
    }
}
