<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Empleado;
use App\Models\Incidencia;
use App\Models\Incidencium;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\IncidenciaController
 */
final class IncidenciaControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $incidencia = Incidencia::factory()->count(3)->create();

        $response = $this->get(route('incidencia.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\IncidenciaController::class,
            'store',
            \App\Http\Requests\IncidenciaStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $descripcion = fake()->text();
        $fecha = Carbon::parse(fake()->dateTime());
        $empleado = Empleado::factory()->create();

        $response = $this->post(route('incidencia.store'), [
            'descripcion' => $descripcion,
            'fecha' => $fecha->toDateTimeString(),
            'empleado_id' => $empleado->id,
        ]);

        $incidencia = Incidencium::query()
            ->where('descripcion', $descripcion)
            ->where('fecha', $fecha)
            ->where('empleado_id', $empleado->id)
            ->get();
        $this->assertCount(1, $incidencia);
        $incidencium = $incidencia->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $incidencium = Incidencia::factory()->create();

        $response = $this->get(route('incidencia.show', $incidencium));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\IncidenciaController::class,
            'update',
            \App\Http\Requests\IncidenciaUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $incidencium = Incidencia::factory()->create();
        $descripcion = fake()->text();
        $fecha = Carbon::parse(fake()->dateTime());
        $empleado = Empleado::factory()->create();

        $response = $this->put(route('incidencia.update', $incidencium), [
            'descripcion' => $descripcion,
            'fecha' => $fecha->toDateTimeString(),
            'empleado_id' => $empleado->id,
        ]);

        $incidencium->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($descripcion, $incidencium->descripcion);
        $this->assertEquals($fecha, $incidencium->fecha);
        $this->assertEquals($empleado->id, $incidencium->empleado_id);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $incidencium = Incidencia::factory()->create();
        $incidencium = Incidencium::factory()->create();

        $response = $this->delete(route('incidencia.destroy', $incidencium));

        $response->assertNoContent();

        $this->assertModelMissing($incidencium);
    }
}
