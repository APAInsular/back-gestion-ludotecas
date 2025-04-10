<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Kid;
use App\Models\Playroom;
use App\Models\Tutor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\KidController
 */
final class KidControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $kids = Kid::factory()->count(3)->create();

        $response = $this->get(route('kids.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\KidController::class,
            'store',
            \App\Http\Requests\KidStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $name = fake()->name();
        $birthdate = Carbon::parse(fake()->date());
        $playroom = Playroom::factory()->create();
        $tutor = Tutor::factory()->create();

        $response = $this->post(route('kids.store'), [
            'name' => $name,
            'birthdate' => $birthdate->toDateString(),
            'playroom_id' => $playroom->id,
            'tutor_id' => $tutor->id,
        ]);

        $kids = Kid::query()
            ->where('name', $name)
            ->where('birthdate', $birthdate)
            ->where('playroom_id', $playroom->id)
            ->where('tutor_id', $tutor->id)
            ->get();
        $this->assertCount(1, $kids);
        $kid = $kids->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $kid = Kid::factory()->create();

        $response = $this->get(route('kids.show', $kid));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\KidController::class,
            'update',
            \App\Http\Requests\KidUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $kid = Kid::factory()->create();
        $name = fake()->name();
        $birthdate = Carbon::parse(fake()->date());
        $playroom = Playroom::factory()->create();
        $tutor = Tutor::factory()->create();

        $response = $this->put(route('kids.update', $kid), [
            'name' => $name,
            'birthdate' => $birthdate->toDateString(),
            'playroom_id' => $playroom->id,
            'tutor_id' => $tutor->id,
        ]);

        $kid->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name, $kid->name);
        $this->assertEquals($birthdate, $kid->birthdate);
        $this->assertEquals($playroom->id, $kid->playroom_id);
        $this->assertEquals($tutor->id, $kid->tutor_id);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $kid = Kid::factory()->create();

        $response = $this->delete(route('kids.destroy', $kid));

        $response->assertNoContent();

        $this->assertModelMissing($kid);
    }
}
