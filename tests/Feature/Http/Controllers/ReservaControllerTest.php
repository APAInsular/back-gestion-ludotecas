<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Nino;
use App\Models\Reserva;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ReservaController
 */
final class ReservaControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $reservas = Reserva::factory()->count(3)->create();

        $response = $this->get(route('reservas.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ReservaController::class,
            'store',
            \App\Http\Requests\ReservaStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $fecha = Carbon::parse(fake()->dateTime());
        $estado = fake()->word();
        $nino = Nino::factory()->create();

        $response = $this->post(route('reservas.store'), [
            'fecha' => $fecha->toDateTimeString(),
            'estado' => $estado,
            'nino_id' => $nino->id,
        ]);

        $reservas = Reserva::query()
            ->where('fecha', $fecha)
            ->where('estado', $estado)
            ->where('nino_id', $nino->id)
            ->get();
        $this->assertCount(1, $reservas);
        $reserva = $reservas->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $reserva = Reserva::factory()->create();

        $response = $this->get(route('reservas.show', $reserva));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ReservaController::class,
            'update',
            \App\Http\Requests\ReservaUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $reserva = Reserva::factory()->create();
        $fecha = Carbon::parse(fake()->dateTime());
        $estado = fake()->word();
        $nino = Nino::factory()->create();

        $response = $this->put(route('reservas.update', $reserva), [
            'fecha' => $fecha->toDateTimeString(),
            'estado' => $estado,
            'nino_id' => $nino->id,
        ]);

        $reserva->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($fecha, $reserva->fecha);
        $this->assertEquals($estado, $reserva->estado);
        $this->assertEquals($nino->id, $reserva->nino_id);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $reserva = Reserva::factory()->create();

        $response = $this->delete(route('reservas.destroy', $reserva));

        $response->assertNoContent();

        $this->assertModelMissing($reserva);
    }
}
