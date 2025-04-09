<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Evento;
use App\Models\Ludoteca;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\EventoController
 */
final class EventoControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $eventos = Evento::factory()->count(3)->create();

        $response = $this->get(route('eventos.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\EventoController::class,
            'store',
            \App\Http\Requests\EventoStoreRequest::class
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
        $ludoteca = Ludoteca::factory()->create();

        $response = $this->post(route('eventos.store'), [
            'title' => $title,
            'date' => $date->toDateTimeString(),
            'hour' => $hour,
            'description' => $description,
            'location' => $location,
            'ludoteca_id' => $ludoteca->id,
        ]);

        $eventos = Evento::query()
            ->where('title', $title)
            ->where('date', $date)
            ->where('hour', $hour)
            ->where('description', $description)
            ->where('location', $location)
            ->where('ludoteca_id', $ludoteca->id)
            ->get();
        $this->assertCount(1, $eventos);
        $evento = $eventos->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $evento = Evento::factory()->create();

        $response = $this->get(route('eventos.show', $evento));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\EventoController::class,
            'update',
            \App\Http\Requests\EventoUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $evento = Evento::factory()->create();
        $title = fake()->sentence(4);
        $date = Carbon::parse(fake()->dateTime());
        $hour = fake()->time();
        $description = fake()->text();
        $location = fake()->word();
        $ludoteca = Ludoteca::factory()->create();

        $response = $this->put(route('eventos.update', $evento), [
            'title' => $title,
            'date' => $date->toDateTimeString(),
            'hour' => $hour,
            'description' => $description,
            'location' => $location,
            'ludoteca_id' => $ludoteca->id,
        ]);

        $evento->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($title, $evento->title);
        $this->assertEquals($date, $evento->date);
        $this->assertEquals($hour, $evento->hour);
        $this->assertEquals($description, $evento->description);
        $this->assertEquals($location, $evento->location);
        $this->assertEquals($ludoteca->id, $evento->ludoteca_id);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $evento = Evento::factory()->create();

        $response = $this->delete(route('eventos.destroy', $evento));

        $response->assertNoContent();

        $this->assertModelMissing($evento);
    }
}
