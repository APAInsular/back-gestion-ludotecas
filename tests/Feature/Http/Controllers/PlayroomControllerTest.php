<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Playroom;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PlayroomController
 */
final class PlayroomControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $playrooms = Playroom::factory()->count(3)->create();

        $response = $this->get(route('playrooms.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PlayroomController::class,
            'store',
            \App\Http\Requests\PlayroomStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $name = fake()->name();
        $address = fake()->word();
        $phone = fake()->phoneNumber();
        $email = fake()->safeEmail();
        $password = fake()->password();

        $response = $this->post(route('playrooms.store'), [
            'name' => $name,
            'address' => $address,
            'phone' => $phone,
            'email' => $email,
            'password' => $password,
        ]);

        $playrooms = Playroom::query()
            ->where('name', $name)
            ->where('address', $address)
            ->where('phone', $phone)
            ->where('email', $email)
            ->where('password', $password)
            ->get();
        $this->assertCount(1, $playrooms);
        $playroom = $playrooms->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $playroom = Playroom::factory()->create();

        $response = $this->get(route('playrooms.show', $playroom));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PlayroomController::class,
            'update',
            \App\Http\Requests\PlayroomUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $playroom = Playroom::factory()->create();
        $name = fake()->name();
        $address = fake()->word();
        $phone = fake()->phoneNumber();
        $email = fake()->safeEmail();
        $password = fake()->password();

        $response = $this->put(route('playrooms.update', $playroom), [
            'name' => $name,
            'address' => $address,
            'phone' => $phone,
            'email' => $email,
            'password' => $password,
        ]);

        $playroom->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name, $playroom->name);
        $this->assertEquals($address, $playroom->address);
        $this->assertEquals($phone, $playroom->phone);
        $this->assertEquals($email, $playroom->email);
        $this->assertEquals($password, $playroom->password);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $playroom = Playroom::factory()->create();

        $response = $this->delete(route('playrooms.destroy', $playroom));

        $response->assertNoContent();

        $this->assertModelMissing($playroom);
    }
}
