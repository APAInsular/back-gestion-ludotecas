<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\EmployeeController
 */
final class EmployeeControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $employees = Employee::factory()->count(3)->create();

        $response = $this->get(route('employees.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\EmployeeController::class,
            'store',
            \App\Http\Requests\EmployeeStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $user = User::factory()->create();
        $position = fake()->word();

        $response = $this->post(route('employees.store'), [
            'user_id' => $user->id,
            'position' => $position,
        ]);

        $employees = Employee::query()
            ->where('user_id', $user->id)
            ->where('position', $position)
            ->get();
        $this->assertCount(1, $employees);
        $employee = $employees->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $employee = Employee::factory()->create();

        $response = $this->get(route('employees.show', $employee));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\EmployeeController::class,
            'update',
            \App\Http\Requests\EmployeeUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $employee = Employee::factory()->create();
        $user = User::factory()->create();
        $position = fake()->word();

        $response = $this->put(route('employees.update', $employee), [
            'user_id' => $user->id,
            'position' => $position,
        ]);

        $employee->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($user->id, $employee->user_id);
        $this->assertEquals($position, $employee->position);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $employee = Employee::factory()->create();

        $response = $this->delete(route('employees.destroy', $employee));

        $response->assertNoContent();

        $this->assertModelMissing($employee);
    }
}
