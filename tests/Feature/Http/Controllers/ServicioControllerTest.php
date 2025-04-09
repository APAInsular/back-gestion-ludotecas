<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Ludoteca;
use App\Models\Servicio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ServicioController
 */
final class ServicioControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $servicios = Servicio::factory()->count(3)->create();

        $response = $this->get(route('servicios.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ServicioController::class,
            'store',
            \App\Http\Requests\ServicioStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $name = fake()->name();
        $description = fake()->text();
        $ludoteca = Ludoteca::factory()->create();

        $response = $this->post(route('servicios.store'), [
            'name' => $name,
            'description' => $description,
            'ludoteca_id' => $ludoteca->id,
        ]);

        $servicios = Servicio::query()
            ->where('name', $name)
            ->where('description', $description)
            ->where('ludoteca_id', $ludoteca->id)
            ->get();
        $this->assertCount(1, $servicios);
        $servicio = $servicios->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $servicio = Servicio::factory()->create();

        $response = $this->get(route('servicios.show', $servicio));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ServicioController::class,
            'update',
            \App\Http\Requests\ServicioUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $servicio = Servicio::factory()->create();
        $name = fake()->name();
        $description = fake()->text();
        $ludoteca = Ludoteca::factory()->create();

        $response = $this->put(route('servicios.update', $servicio), [
            'name' => $name,
            'description' => $description,
            'ludoteca_id' => $ludoteca->id,
        ]);

        $servicio->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name, $servicio->name);
        $this->assertEquals($description, $servicio->description);
        $this->assertEquals($ludoteca->id, $servicio->ludoteca_id);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $servicio = Servicio::factory()->create();

        $response = $this->delete(route('servicios.destroy', $servicio));

        $response->assertNoContent();

        $this->assertModelMissing($servicio);
    }
}
