<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Foro;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ForoController
 */
final class ForoControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $foros = Foro::factory()->count(3)->create();

        $response = $this->get(route('foros.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ForoController::class,
            'store',
            \App\Http\Requests\ForoStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $titulo = fake()->word();
        $descripcion = fake()->text();

        $response = $this->post(route('foros.store'), [
            'titulo' => $titulo,
            'descripcion' => $descripcion,
        ]);

        $foros = Foro::query()
            ->where('titulo', $titulo)
            ->where('descripcion', $descripcion)
            ->get();
        $this->assertCount(1, $foros);
        $foro = $foros->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $foro = Foro::factory()->create();

        $response = $this->get(route('foros.show', $foro));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ForoController::class,
            'update',
            \App\Http\Requests\ForoUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $foro = Foro::factory()->create();
        $titulo = fake()->word();
        $descripcion = fake()->text();

        $response = $this->put(route('foros.update', $foro), [
            'titulo' => $titulo,
            'descripcion' => $descripcion,
        ]);

        $foro->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($titulo, $foro->titulo);
        $this->assertEquals($descripcion, $foro->descripcion);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $foro = Foro::factory()->create();

        $response = $this->delete(route('foros.destroy', $foro));

        $response->assertNoContent();

        $this->assertModelMissing($foro);
    }
}
