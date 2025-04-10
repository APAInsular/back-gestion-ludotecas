<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Forum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ForumController
 */
final class ForumControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $forums = Forum::factory()->count(3)->create();

        $response = $this->get(route('forums.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ForumController::class,
            'store',
            \App\Http\Requests\ForumStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $title = fake()->sentence(4);
        $description = fake()->text();

        $response = $this->post(route('forums.store'), [
            'title' => $title,
            'description' => $description,
        ]);

        $forums = Forum::query()
            ->where('title', $title)
            ->where('description', $description)
            ->get();
        $this->assertCount(1, $forums);
        $forum = $forums->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $forum = Forum::factory()->create();

        $response = $this->get(route('forums.show', $forum));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ForumController::class,
            'update',
            \App\Http\Requests\ForumUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $forum = Forum::factory()->create();
        $title = fake()->sentence(4);
        $description = fake()->text();

        $response = $this->put(route('forums.update', $forum), [
            'title' => $title,
            'description' => $description,
        ]);

        $forum->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($title, $forum->title);
        $this->assertEquals($description, $forum->description);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $forum = Forum::factory()->create();

        $response = $this->delete(route('forums.destroy', $forum));

        $response->assertNoContent();

        $this->assertModelMissing($forum);
    }
}
