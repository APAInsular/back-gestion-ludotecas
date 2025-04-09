<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Administrador;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AdministradorController
 */
final class AdministradorControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $administradors = Administrador::factory()->count(3)->create();

        $response = $this->get(route('administradors.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdministradorController::class,
            'store',
            \App\Http\Requests\AdministradorStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('administradors.store'), [
            'user_id' => $user->id,
        ]);

        $administradors = Administrador::query()
            ->where('user_id', $user->id)
            ->get();
        $this->assertCount(1, $administradors);
        $administrador = $administradors->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $administrador = Administrador::factory()->create();

        $response = $this->get(route('administradors.show', $administrador));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdministradorController::class,
            'update',
            \App\Http\Requests\AdministradorUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $administrador = Administrador::factory()->create();
        $user = User::factory()->create();

        $response = $this->put(route('administradors.update', $administrador), [
            'user_id' => $user->id,
        ]);

        $administrador->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($user->id, $administrador->user_id);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $administrador = Administrador::factory()->create();

        $response = $this->delete(route('administradors.destroy', $administrador));

        $response->assertNoContent();

        $this->assertModelMissing($administrador);
    }
}
