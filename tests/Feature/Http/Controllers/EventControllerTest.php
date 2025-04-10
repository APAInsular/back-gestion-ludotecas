<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Event;
use App\Models\Playroom;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\EventController
 */
final class EventControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $events = Event::factory()->count(3)->create();

        $response = $this->get(route('events.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\EventController::class,
            'store',
            \App\Http\Requests\EventStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $title = fake()->sentence(4);
        $date = Carbon::parse(fake()->dateTime());
        $hour = fake()->time();
        $description = fake()->text();
        $location = fake()->word();
        $playroom = Playroom::factory()->create();

        $response = $this->post(route('events.store'), [
            'title' => $title,
            'date' => $date->toDateTimeString(),
            'hour' => $hour,
            'description' => $description,
            'location' => $location,
            'playroom_id' => $playroom->id,
        ]);

        $events = Event::query()
            ->where('title', $title)
            ->where('date', $date)
            ->where('hour', $hour)
            ->where('description', $description)
            ->where('location', $location)
            ->where('playroom_id', $playroom->id)
            ->get();
        $this->assertCount(1, $events);
        $event = $events->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $event = Event::factory()->create();

        $response = $this->get(route('events.show', $event));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\EventController::class,
            'update',
            \App\Http\Requests\EventUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $event = Event::factory()->create();
        $title = fake()->sentence(4);
        $date = Carbon::parse(fake()->dateTime());
        $hour = fake()->time();
        $description = fake()->text();
        $location = fake()->word();
        $playroom = Playroom::factory()->create();

        $response = $this->put(route('events.update', $event), [
            'title' => $title,
            'date' => $date->toDateTimeString(),
            'hour' => $hour,
            'description' => $description,
            'location' => $location,
            'playroom_id' => $playroom->id,
        ]);

        $event->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($title, $event->title);
        $this->assertEquals($date, $event->date);
        $this->assertEquals($hour, $event->hour);
        $this->assertEquals($description, $event->description);
        $this->assertEquals($location, $event->location);
        $this->assertEquals($playroom->id, $event->playroom_id);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $event = Event::factory()->create();

        $response = $this->delete(route('events.destroy', $event));

        $response->assertNoContent();

        $this->assertModelMissing($event);
    }
}
