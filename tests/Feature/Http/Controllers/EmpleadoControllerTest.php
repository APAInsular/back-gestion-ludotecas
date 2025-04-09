<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Empleado;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\EmpleadoController
 */
final class EmpleadoControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $empleados = Empleado::factory()->count(3)->create();

        $response = $this->get(route('empleados.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\EmpleadoController::class,
            'store',
            \App\Http\Requests\EmpleadoStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $user = User::factory()->create();
        $puesto = fake()->word();

        $response = $this->post(route('empleados.store'), [
            'user_id' => $user->id,
            'puesto' => $puesto,
        ]);

        $empleados = Empleado::query()
            ->where('user_id', $user->id)
            ->where('puesto', $puesto)
            ->get();
        $this->assertCount(1, $empleados);
        $empleado = $empleados->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $empleado = Empleado::factory()->create();

        $response = $this->get(route('empleados.show', $empleado));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\EmpleadoController::class,
            'update',
            \App\Http\Requests\EmpleadoUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $empleado = Empleado::factory()->create();
        $user = User::factory()->create();
        $puesto = fake()->word();

        $response = $this->put(route('empleados.update', $empleado), [
            'user_id' => $user->id,
            'puesto' => $puesto,
        ]);

        $empleado->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($user->id, $empleado->user_id);
        $this->assertEquals($puesto, $empleado->puesto);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $empleado = Empleado::factory()->create();

        $response = $this->delete(route('empleados.destroy', $empleado));

        $response->assertNoContent();

        $this->assertModelMissing($empleado);
    }
}
