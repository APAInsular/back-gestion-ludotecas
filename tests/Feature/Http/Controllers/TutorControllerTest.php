<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Tutor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\TutorController
 */
final class TutorControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $tutors = Tutor::factory()->count(3)->create();

        $response = $this->get(route('tutors.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TutorController::class,
            'store',
            \App\Http\Requests\TutorStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('tutors.store'), [
            'user_id' => $user->id,
        ]);

        $tutors = Tutor::query()
            ->where('user_id', $user->id)
            ->get();
        $this->assertCount(1, $tutors);
        $tutor = $tutors->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $tutor = Tutor::factory()->create();

        $response = $this->get(route('tutors.show', $tutor));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TutorController::class,
            'update',
            \App\Http\Requests\TutorUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $tutor = Tutor::factory()->create();
        $user = User::factory()->create();

        $response = $this->put(route('tutors.update', $tutor), [
            'user_id' => $user->id,
        ]);

        $tutor->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($user->id, $tutor->user_id);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $tutor = Tutor::factory()->create();

        $response = $this->delete(route('tutors.destroy', $tutor));

        $response->assertNoContent();

        $this->assertModelMissing($tutor);
    }
}
