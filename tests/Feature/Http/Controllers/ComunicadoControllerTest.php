<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Comunicado;
use App\Models\Ludoteca;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ComunicadoController
 */
final class ComunicadoControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $comunicados = Comunicado::factory()->count(3)->create();

        $response = $this->get(route('comunicados.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ComunicadoController::class,
            'store',
            \App\Http\Requests\ComunicadoStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $title = fake()->sentence(4);
        $description = fake()->text();
        $ludoteca = Ludoteca::factory()->create();

        $response = $this->post(route('comunicados.store'), [
            'title' => $title,
            'description' => $description,
            'ludoteca_id' => $ludoteca->id,
        ]);

        $comunicados = Comunicado::query()
            ->where('title', $title)
            ->where('description', $description)
            ->where('ludoteca_id', $ludoteca->id)
            ->get();
        $this->assertCount(1, $comunicados);
        $comunicado = $comunicados->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $comunicado = Comunicado::factory()->create();

        $response = $this->get(route('comunicados.show', $comunicado));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ComunicadoController::class,
            'update',
            \App\Http\Requests\ComunicadoUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $comunicado = Comunicado::factory()->create();
        $title = fake()->sentence(4);
        $description = fake()->text();
        $ludoteca = Ludoteca::factory()->create();

        $response = $this->put(route('comunicados.update', $comunicado), [
            'title' => $title,
            'description' => $description,
            'ludoteca_id' => $ludoteca->id,
        ]);

        $comunicado->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($title, $comunicado->title);
        $this->assertEquals($description, $comunicado->description);
        $this->assertEquals($ludoteca->id, $comunicado->ludoteca_id);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $comunicado = Comunicado::factory()->create();

        $response = $this->delete(route('comunicados.destroy', $comunicado));

        $response->assertNoContent();

        $this->assertModelMissing($comunicado);
    }
}
