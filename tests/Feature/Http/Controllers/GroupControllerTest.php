<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Group;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\GroupController
 */
final class GroupControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $groups = Group::factory()->count(3)->create();

        $response = $this->get(route('groups.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\GroupController::class,
            'store',
            \App\Http\Requests\GroupStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $name = fake()->name();
        $description = fake()->text();

        $response = $this->post(route('groups.store'), [
            'name' => $name,
            'description' => $description,
        ]);

        $groups = Group::query()
            ->where('name', $name)
            ->where('description', $description)
            ->get();
        $this->assertCount(1, $groups);
        $group = $groups->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $group = Group::factory()->create();

        $response = $this->get(route('groups.show', $group));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\GroupController::class,
            'update',
            \App\Http\Requests\GroupUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $group = Group::factory()->create();
        $name = fake()->name();
        $description = fake()->text();

        $response = $this->put(route('groups.update', $group), [
            'name' => $name,
            'description' => $description,
        ]);

        $group->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name, $group->name);
        $this->assertEquals($description, $group->description);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $group = Group::factory()->create();

        $response = $this->delete(route('groups.destroy', $group));

        $response->assertNoContent();

        $this->assertModelMissing($group);
    }
}
