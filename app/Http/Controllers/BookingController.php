<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingStoreRequest;
use App\Http\Requests\BookingUpdateRequest;
use App\Http\Resources\BookingCollection;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookingController extends Controller
{
    public function index(Request $request): BookingCollection
    {
        $bookings = Booking::all();

        return new BookingCollection($bookings);
    }

    public function store(BookingStoreRequest $request): BookingResource
    {
        $booking = Booking::create($request->validated());

        return new BookingResource($booking);
    }

    public function show(Request $request, Booking $booking): BookingResource
    {
        return new BookingResource($booking);
    }

    public function update(BookingUpdateRequest $request, Booking $booking): BookingResource
    {
        $booking->update($request->validated());

        return new BookingResource($booking);
    }

    public function destroy(Request $request, Booking $booking): Response
    {
        $booking->delete();

        return response()->noContent();
    }
}
