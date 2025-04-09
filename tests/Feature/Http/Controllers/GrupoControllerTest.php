<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Grupo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\GrupoController
 */
final class GrupoControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $grupos = Grupo::factory()->count(3)->create();

        $response = $this->get(route('grupos.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\GrupoController::class,
            'store',
            \App\Http\Requests\GrupoStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $name = fake()->name();
        $descripcion = fake()->text();

        $response = $this->post(route('grupos.store'), [
            'name' => $name,
            'descripcion' => $descripcion,
        ]);

        $grupos = Grupo::query()
            ->where('name', $name)
            ->where('descripcion', $descripcion)
            ->get();
        $this->assertCount(1, $grupos);
        $grupo = $grupos->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $grupo = Grupo::factory()->create();

        $response = $this->get(route('grupos.show', $grupo));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\GrupoController::class,
            'update',
            \App\Http\Requests\GrupoUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $grupo = Grupo::factory()->create();
        $name = fake()->name();
        $descripcion = fake()->text();

        $response = $this->put(route('grupos.update', $grupo), [
            'name' => $name,
            'descripcion' => $descripcion,
        ]);

        $grupo->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name, $grupo->name);
        $this->assertEquals($descripcion, $grupo->descripcion);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $grupo = Grupo::factory()->create();

        $response = $this->delete(route('grupos.destroy', $grupo));

        $response->assertNoContent();

        $this->assertModelMissing($grupo);
    }
}
