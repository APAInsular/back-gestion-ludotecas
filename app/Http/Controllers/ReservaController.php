<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservaStoreRequest;
use App\Http\Requests\ReservaUpdateRequest;
use App\Http\Resources\ReservaCollection;
use App\Http\Resources\ReservaResource;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReservaController extends Controller
{
    public function index(Request $request): ReservaCollection
    {
        $reservas = Reserva::all();

        return new ReservaCollection($reservas);
    }

    public function store(ReservaStoreRequest $request): ReservaResource
    {
        $reserva = Reserva::create($request->validated());

        return new ReservaResource($reserva);
    }

    public function show(Request $request, Reserva $reserva): ReservaResource
    {
        return new ReservaResource($reserva);
    }

    public function update(ReservaUpdateRequest $request, Reserva $reserva): ReservaResource
    {
        $reserva->update($request->validated());

        return new ReservaResource($reserva);
    }

    public function destroy(Request $request, Reserva $reserva): Response
    {
        $reserva->delete();

        return response()->noContent();
    }
}
