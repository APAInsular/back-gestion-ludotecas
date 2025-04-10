<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Administrator;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AdministratorController
 */
final class AdministratorControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $administrators = Administrator::factory()->count(3)->create();

        $response = $this->get(route('administrators.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdministratorController::class,
            'store',
            \App\Http\Requests\AdministratorStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('administrators.store'), [
            'user_id' => $user->id,
        ]);

        $administrators = Administrator::query()
            ->where('user_id', $user->id)
            ->get();
        $this->assertCount(1, $administrators);
        $administrator = $administrators->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $administrator = Administrator::factory()->create();

        $response = $this->get(route('administrators.show', $administrator));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdministratorController::class,
            'update',
            \App\Http\Requests\AdministratorUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $administrator = Administrator::factory()->create();
        $user = User::factory()->create();

        $response = $this->put(route('administrators.update', $administrator), [
            'user_id' => $user->id,
        ]);

        $administrator->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($user->id, $administrator->user_id);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $administrator = Administrator::factory()->create();

        $response = $this->delete(route('administrators.destroy', $administrator));

        $response->assertNoContent();

        $this->assertModelMissing($administrator);
    }
}
