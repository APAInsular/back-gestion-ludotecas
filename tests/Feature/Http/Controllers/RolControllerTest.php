<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Rol;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\RolController
 */
final class RolControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $rols = Rol::factory()->count(3)->create();

        $response = $this->get(route('rols.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\RolController::class,
            'store',
            \App\Http\Requests\RolStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $name = fake()->name();

        $response = $this->post(route('rols.store'), [
            'name' => $name,
        ]);

        $rols = Rol::query()
            ->where('name', $name)
            ->get();
        $this->assertCount(1, $rols);
        $rol = $rols->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $rol = Rol::factory()->create();

        $response = $this->get(route('rols.show', $rol));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\RolController::class,
            'update',
            \App\Http\Requests\RolUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $rol = Rol::factory()->create();
        $name = fake()->name();

        $response = $this->put(route('rols.update', $rol), [
            'name' => $name,
        ]);

        $rol->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name, $rol->name);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $rol = Rol::factory()->create();

        $response = $this->delete(route('rols.destroy', $rol));

        $response->assertNoContent();

        $this->assertModelMissing($rol);
    }
}
