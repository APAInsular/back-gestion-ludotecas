<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Activity;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ActivityController
 */
final class ActivityControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $activities = Activity::factory()->count(3)->create();

        $response = $this->get(route('activities.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ActivityController::class,
            'store',
            \App\Http\Requests\ActivityStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $name = fake()->name();
        $date = Carbon::parse(fake()->dateTime());
        $hour = fake()->time();
        $description = fake()->text();
        $service = Service::factory()->create();

        $response = $this->post(route('activities.store'), [
            'name' => $name,
            'date' => $date->toDateTimeString(),
            'hour' => $hour,
            'description' => $description,
            'service_id' => $service->id,
        ]);

        $activities = Activity::query()
            ->where('name', $name)
            ->where('date', $date)
            ->where('hour', $hour)
            ->where('description', $description)
            ->where('service_id', $service->id)
            ->get();
        $this->assertCount(1, $activities);
        $activity = $activities->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $activity = Activity::factory()->create();

        $response = $this->get(route('activities.show', $activity));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ActivityController::class,
            'update',
            \App\Http\Requests\ActivityUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $activity = Activity::factory()->create();
        $name = fake()->name();
        $date = Carbon::parse(fake()->dateTime());
        $hour = fake()->time();
        $description = fake()->text();
        $service = Service::factory()->create();

        $response = $this->put(route('activities.update', $activity), [
            'name' => $name,
            'date' => $date->toDateTimeString(),
            'hour' => $hour,
            'description' => $description,
            'service_id' => $service->id,
        ]);

        $activity->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name, $activity->name);
        $this->assertEquals($date, $activity->date);
        $this->assertEquals($hour, $activity->hour);
        $this->assertEquals($description, $activity->description);
        $this->assertEquals($service->id, $activity->service_id);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $activity = Activity::factory()->create();

        $response = $this->delete(route('activities.destroy', $activity));

        $response->assertNoContent();

        $this->assertModelMissing($activity);
    }
}
