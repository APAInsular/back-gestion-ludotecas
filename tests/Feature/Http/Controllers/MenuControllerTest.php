<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Ludoteca;
use App\Models\Menu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\MenuController
 */
final class MenuControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $menus = Menu::factory()->count(3)->create();

        $response = $this->get(route('menus.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\MenuController::class,
            'store',
            \App\Http\Requests\MenuStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $title = fake()->sentence(4);
        $description = fake()->text();
        $ludoteca = Ludoteca::factory()->create();

        $response = $this->post(route('menus.store'), [
            'title' => $title,
            'description' => $description,
            'ludoteca_id' => $ludoteca->id,
        ]);

        $menus = Menu::query()
            ->where('title', $title)
            ->where('description', $description)
            ->where('ludoteca_id', $ludoteca->id)
            ->get();
        $this->assertCount(1, $menus);
        $menu = $menus->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $menu = Menu::factory()->create();

        $response = $this->get(route('menus.show', $menu));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\MenuController::class,
            'update',
            \App\Http\Requests\MenuUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $menu = Menu::factory()->create();
        $title = fake()->sentence(4);
        $description = fake()->text();
        $ludoteca = Ludoteca::factory()->create();

        $response = $this->put(route('menus.update', $menu), [
            'title' => $title,
            'description' => $description,
            'ludoteca_id' => $ludoteca->id,
        ]);

        $menu->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($title, $menu->title);
        $this->assertEquals($description, $menu->description);
        $this->assertEquals($ludoteca->id, $menu->ludoteca_id);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $menu = Menu::factory()->create();

        $response = $this->delete(route('menus.destroy', $menu));

        $response->assertNoContent();

        $this->assertModelMissing($menu);
    }
}
