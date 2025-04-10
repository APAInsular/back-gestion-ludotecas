<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Announcement;
use App\Models\Playroom;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AnnouncementController
 */
final class AnnouncementControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $announcements = Announcement::factory()->count(3)->create();

        $response = $this->get(route('announcements.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AnnouncementController::class,
            'store',
            \App\Http\Requests\AnnouncementStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $title = fake()->sentence(4);
        $description = fake()->text();
        $playroom = Playroom::factory()->create();

        $response = $this->post(route('announcements.store'), [
            'title' => $title,
            'description' => $description,
            'playroom_id' => $playroom->id,
        ]);

        $announcements = Announcement::query()
            ->where('title', $title)
            ->where('description', $description)
            ->where('playroom_id', $playroom->id)
            ->get();
        $this->assertCount(1, $announcements);
        $announcement = $announcements->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $announcement = Announcement::factory()->create();

        $response = $this->get(route('announcements.show', $announcement));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AnnouncementController::class,
            'update',
            \App\Http\Requests\AnnouncementUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $announcement = Announcement::factory()->create();
        $title = fake()->sentence(4);
        $description = fake()->text();
        $playroom = Playroom::factory()->create();

        $response = $this->put(route('announcements.update', $announcement), [
            'title' => $title,
            'description' => $description,
            'playroom_id' => $playroom->id,
        ]);

        $announcement->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($title, $announcement->title);
        $this->assertEquals($description, $announcement->description);
        $this->assertEquals($playroom->id, $announcement->playroom_id);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $announcement = Announcement::factory()->create();

        $response = $this->delete(route('announcements.destroy', $announcement));

        $response->assertNoContent();

        $this->assertModelMissing($announcement);
    }
}
