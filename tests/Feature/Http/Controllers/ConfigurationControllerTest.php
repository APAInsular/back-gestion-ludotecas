<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Configuration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ConfigurationController
 */
final class ConfigurationControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $configurations = Configuration::factory()->count(3)->create();

        $response = $this->get(route('configurations.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ConfigurationController::class,
            'store',
            \App\Http\Requests\ConfigurationStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $language = fake()->word();
        $notifications = fake()->boolean();
        $user = User::factory()->create();

        $response = $this->post(route('configurations.store'), [
            'language' => $language,
            'notifications' => $notifications,
            'user_id' => $user->id,
        ]);

        $configurations = Configuration::query()
            ->where('language', $language)
            ->where('notifications', $notifications)
            ->where('user_id', $user->id)
            ->get();
        $this->assertCount(1, $configurations);
        $configuration = $configurations->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $configuration = Configuration::factory()->create();

        $response = $this->get(route('configurations.show', $configuration));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ConfigurationController::class,
            'update',
            \App\Http\Requests\ConfigurationUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $configuration = Configuration::factory()->create();
        $language = fake()->word();
        $notifications = fake()->boolean();
        $user = User::factory()->create();

        $response = $this->put(route('configurations.update', $configuration), [
            'language' => $language,
            'notifications' => $notifications,
            'user_id' => $user->id,
        ]);

        $configuration->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($language, $configuration->language);
        $this->assertEquals($notifications, $configuration->notifications);
        $this->assertEquals($user->id, $configuration->user_id);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $configuration = Configuration::factory()->create();

        $response = $this->delete(route('configurations.destroy', $configuration));

        $response->assertNoContent();

        $this->assertModelMissing($configuration);
    }
}
