<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Employee;
use App\Models\Incidence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\IncidenceController
 */
final class IncidenceControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $incidences = Incidence::factory()->count(3)->create();

        $response = $this->get(route('incidences.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\IncidenceController::class,
            'store',
            \App\Http\Requests\IncidenceStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $description = fake()->text();
        $date = Carbon::parse(fake()->dateTime());
        $employee = Employee::factory()->create();

        $response = $this->post(route('incidences.store'), [
            'description' => $description,
            'date' => $date->toDateTimeString(),
            'employee_id' => $employee->id,
        ]);

        $incidences = Incidence::query()
            ->where('description', $description)
            ->where('date', $date)
            ->where('employee_id', $employee->id)
            ->get();
        $this->assertCount(1, $incidences);
        $incidence = $incidences->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $incidence = Incidence::factory()->create();

        $response = $this->get(route('incidences.show', $incidence));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\IncidenceController::class,
            'update',
            \App\Http\Requests\IncidenceUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $incidence = Incidence::factory()->create();
        $description = fake()->text();
        $date = Carbon::parse(fake()->dateTime());
        $employee = Employee::factory()->create();

        $response = $this->put(route('incidences.update', $incidence), [
            'description' => $description,
            'date' => $date->toDateTimeString(),
            'employee_id' => $employee->id,
        ]);

        $incidence->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($description, $incidence->description);
        $this->assertEquals($date, $incidence->date);
        $this->assertEquals($employee->id, $incidence->employee_id);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $incidence = Incidence::factory()->create();

        $response = $this->delete(route('incidences.destroy', $incidence));

        $response->assertNoContent();

        $this->assertModelMissing($incidence);
    }
}
