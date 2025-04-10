<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Playroom;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ServiceController
 */
final class ServiceControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $services = Service::factory()->count(3)->create();

        $response = $this->get(route('services.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ServiceController::class,
            'store',
            \App\Http\Requests\ServiceStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $name = fake()->name();
        $description = fake()->text();
        $playroom = Playroom::factory()->create();

        $response = $this->post(route('services.store'), [
            'name' => $name,
            'description' => $description,
            'playroom_id' => $playroom->id,
        ]);

        $services = Service::query()
            ->where('name', $name)
            ->where('description', $description)
            ->where('playroom_id', $playroom->id)
            ->get();
        $this->assertCount(1, $services);
        $service = $services->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $service = Service::factory()->create();

        $response = $this->get(route('services.show', $service));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ServiceController::class,
            'update',
            \App\Http\Requests\ServiceUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $service = Service::factory()->create();
        $name = fake()->name();
        $description = fake()->text();
        $playroom = Playroom::factory()->create();

        $response = $this->put(route('services.update', $service), [
            'name' => $name,
            'description' => $description,
            'playroom_id' => $playroom->id,
        ]);

        $service->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name, $service->name);
        $this->assertEquals($description, $service->description);
        $this->assertEquals($playroom->id, $service->playroom_id);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $service = Service::factory()->create();

        $response = $this->delete(route('services.destroy', $service));

        $response->assertNoContent();

        $this->assertModelMissing($service);
    }
}
