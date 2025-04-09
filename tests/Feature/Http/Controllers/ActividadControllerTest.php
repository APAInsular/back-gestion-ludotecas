<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Actividad;
use App\Models\Servicio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ActividadController
 */
final class ActividadControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $actividads = Actividad::factory()->count(3)->create();

        $response = $this->get(route('actividads.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ActividadController::class,
            'store',
            \App\Http\Requests\ActividadStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $name = fake()->name();
        $date = Carbon::parse(fake()->dateTime());
        $hour = fake()->time();
        $description = fake()->text();
        $servicio = Servicio::factory()->create();

        $response = $this->post(route('actividads.store'), [
            'name' => $name,
            'date' => $date->toDateTimeString(),
            'hour' => $hour,
            'description' => $description,
            'servicio_id' => $servicio->id,
        ]);

        $actividads = Actividad::query()
            ->where('name', $name)
            ->where('date', $date)
            ->where('hour', $hour)
            ->where('description', $description)
            ->where('servicio_id', $servicio->id)
            ->get();
        $this->assertCount(1, $actividads);
        $actividad = $actividads->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $actividad = Actividad::factory()->create();

        $response = $this->get(route('actividads.show', $actividad));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ActividadController::class,
            'update',
            \App\Http\Requests\ActividadUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $actividad = Actividad::factory()->create();
        $name = fake()->name();
        $date = Carbon::parse(fake()->dateTime());
        $hour = fake()->time();
        $description = fake()->text();
        $servicio = Servicio::factory()->create();

        $response = $this->put(route('actividads.update', $actividad), [
            'name' => $name,
            'date' => $date->toDateTimeString(),
            'hour' => $hour,
            'description' => $description,
            'servicio_id' => $servicio->id,
        ]);

        $actividad->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name, $actividad->name);
        $this->assertEquals($date, $actividad->date);
        $this->assertEquals($hour, $actividad->hour);
        $this->assertEquals($description, $actividad->description);
        $this->assertEquals($servicio->id, $actividad->servicio_id);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $actividad = Actividad::factory()->create();

        $response = $this->delete(route('actividads.destroy', $actividad));

        $response->assertNoContent();

        $this->assertModelMissing($actividad);
    }
}
