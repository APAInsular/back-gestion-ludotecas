<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Booking;
use App\Models\Kid;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\BookingController
 */
final class BookingControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $bookings = Booking::factory()->count(3)->create();

        $response = $this->get(route('bookings.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\BookingController::class,
            'store',
            \App\Http\Requests\BookingStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $date = Carbon::parse(fake()->dateTime());
        $status = fake()->word();
        $kid = Kid::factory()->create();

        $response = $this->post(route('bookings.store'), [
            'date' => $date->toDateTimeString(),
            'status' => $status,
            'kid_id' => $kid->id,
        ]);

        $bookings = Booking::query()
            ->where('date', $date)
            ->where('status', $status)
            ->where('kid_id', $kid->id)
            ->get();
        $this->assertCount(1, $bookings);
        $booking = $bookings->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $booking = Booking::factory()->create();

        $response = $this->get(route('bookings.show', $booking));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\BookingController::class,
            'update',
            \App\Http\Requests\BookingUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $booking = Booking::factory()->create();
        $date = Carbon::parse(fake()->dateTime());
        $status = fake()->word();
        $kid = Kid::factory()->create();

        $response = $this->put(route('bookings.update', $booking), [
            'date' => $date->toDateTimeString(),
            'status' => $status,
            'kid_id' => $kid->id,
        ]);

        $booking->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($date, $booking->date);
        $this->assertEquals($status, $booking->status);
        $this->assertEquals($kid->id, $booking->kid_id);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $booking = Booking::factory()->create();

        $response = $this->delete(route('bookings.destroy', $booking));

        $response->assertNoContent();

        $this->assertModelMissing($booking);
    }
}
