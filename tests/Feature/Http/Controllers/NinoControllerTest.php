<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Ludoteca;
use App\Models\Nino;
use App\Models\Tutor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\NinoController
 */
final class NinoControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $ninos = Nino::factory()->count(3)->create();

        $response = $this->get(route('ninos.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\NinoController::class,
            'store',
            \App\Http\Requests\NinoStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $name = fake()->name();
        $birthdate = Carbon::parse(fake()->date());
        $ludoteca = Ludoteca::factory()->create();
        $tutor = Tutor::factory()->create();

        $response = $this->post(route('ninos.store'), [
            'name' => $name,
            'birthdate' => $birthdate->toDateString(),
            'ludoteca_id' => $ludoteca->id,
            'tutor_id' => $tutor->id,
        ]);

        $ninos = Nino::query()
            ->where('name', $name)
            ->where('birthdate', $birthdate)
            ->where('ludoteca_id', $ludoteca->id)
            ->where('tutor_id', $tutor->id)
            ->get();
        $this->assertCount(1, $ninos);
        $nino = $ninos->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $nino = Nino::factory()->create();

        $response = $this->get(route('ninos.show', $nino));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\NinoController::class,
            'update',
            \App\Http\Requests\NinoUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $nino = Nino::factory()->create();
        $name = fake()->name();
        $birthdate = Carbon::parse(fake()->date());
        $ludoteca = Ludoteca::factory()->create();
        $tutor = Tutor::factory()->create();

        $response = $this->put(route('ninos.update', $nino), [
            'name' => $name,
            'birthdate' => $birthdate->toDateString(),
            'ludoteca_id' => $ludoteca->id,
            'tutor_id' => $tutor->id,
        ]);

        $nino->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name, $nino->name);
        $this->assertEquals($birthdate, $nino->birthdate);
        $this->assertEquals($ludoteca->id, $nino->ludoteca_id);
        $this->assertEquals($tutor->id, $nino->tutor_id);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $nino = Nino::factory()->create();

        $response = $this->delete(route('ninos.destroy', $nino));

        $response->assertNoContent();

        $this->assertModelMissing($nino);
    }
}
