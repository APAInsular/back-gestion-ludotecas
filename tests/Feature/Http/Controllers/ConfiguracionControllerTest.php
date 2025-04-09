<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Configuracion;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ConfiguracionController
 */
final class ConfiguracionControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $configuracions = Configuracion::factory()->count(3)->create();

        $response = $this->get(route('configuracions.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ConfiguracionController::class,
            'store',
            \App\Http\Requests\ConfiguracionStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $idioma = fake()->word();
        $notificaciones = fake()->boolean();
        $usuario = Usuario::factory()->create();

        $response = $this->post(route('configuracions.store'), [
            'idioma' => $idioma,
            'notificaciones' => $notificaciones,
            'usuario_id' => $usuario->id,
        ]);

        $configuracions = Configuracion::query()
            ->where('idioma', $idioma)
            ->where('notificaciones', $notificaciones)
            ->where('usuario_id', $usuario->id)
            ->get();
        $this->assertCount(1, $configuracions);
        $configuracion = $configuracions->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $configuracion = Configuracion::factory()->create();

        $response = $this->get(route('configuracions.show', $configuracion));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ConfiguracionController::class,
            'update',
            \App\Http\Requests\ConfiguracionUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $configuracion = Configuracion::factory()->create();
        $idioma = fake()->word();
        $notificaciones = fake()->boolean();
        $usuario = Usuario::factory()->create();

        $response = $this->put(route('configuracions.update', $configuracion), [
            'idioma' => $idioma,
            'notificaciones' => $notificaciones,
            'usuario_id' => $usuario->id,
        ]);

        $configuracion->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($idioma, $configuracion->idioma);
        $this->assertEquals($notificaciones, $configuracion->notificaciones);
        $this->assertEquals($usuario->id, $configuracion->usuario_id);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $configuracion = Configuracion::factory()->create();

        $response = $this->delete(route('configuracions.destroy', $configuracion));

        $response->assertNoContent();

        $this->assertModelMissing($configuracion);
    }
}
