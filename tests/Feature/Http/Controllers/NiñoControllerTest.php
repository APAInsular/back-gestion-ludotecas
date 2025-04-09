<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Niño;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\NiñoController
 */
final class NiñoControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $niños = Niño::factory()->count(3)->create();

        $response = $this->get(route('niños.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\NiñoController::class,
            'store',
            \App\Http\Requests\NiñoStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $response = $this->post(route('niños.store'));

        $response->assertCreated();
        $response->assertJsonStructure([]);

        $this->assertDatabaseHas(niños, [ /* ... */ ]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $niño = Niño::factory()->create();

        $response = $this->get(route('niños.show', $niño));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\NiñoController::class,
            'update',
            \App\Http\Requests\NiñoUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $niño = Niño::factory()->create();

        $response = $this->put(route('niños.update', $niño));

        $niño->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $niño = Niño::factory()->create();

        $response = $this->delete(route('niños.destroy', $niño));

        $response->assertNoContent();

        $this->assertModelMissing($niño);
    }
}
