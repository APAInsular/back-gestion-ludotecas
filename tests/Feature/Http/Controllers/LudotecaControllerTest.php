<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Ludoteca;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\LudotecaController
 */
final class LudotecaControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $ludotecas = Ludoteca::factory()->count(3)->create();

        $response = $this->get(route('ludotecas.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\LudotecaController::class,
            'store',
            \App\Http\Requests\LudotecaStoreRequest::class
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

        $response = $this->post(route('ludotecas.store'), [
            'name' => $name,
            'address' => $address,
            'phone' => $phone,
            'email' => $email,
            'password' => $password,
        ]);

        $ludotecas = Ludoteca::query()
            ->where('name', $name)
            ->where('address', $address)
            ->where('phone', $phone)
            ->where('email', $email)
            ->where('password', $password)
            ->get();
        $this->assertCount(1, $ludotecas);
        $ludoteca = $ludotecas->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $ludoteca = Ludoteca::factory()->create();

        $response = $this->get(route('ludotecas.show', $ludoteca));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\LudotecaController::class,
            'update',
            \App\Http\Requests\LudotecaUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $ludoteca = Ludoteca::factory()->create();
        $name = fake()->name();
        $address = fake()->word();
        $phone = fake()->phoneNumber();
        $email = fake()->safeEmail();
        $password = fake()->password();

        $response = $this->put(route('ludotecas.update', $ludoteca), [
            'name' => $name,
            'address' => $address,
            'phone' => $phone,
            'email' => $email,
            'password' => $password,
        ]);

        $ludoteca->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name, $ludoteca->name);
        $this->assertEquals($address, $ludoteca->address);
        $this->assertEquals($phone, $ludoteca->phone);
        $this->assertEquals($email, $ludoteca->email);
        $this->assertEquals($password, $ludoteca->password);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $ludoteca = Ludoteca::factory()->create();

        $response = $this->delete(route('ludotecas.destroy', $ludoteca));

        $response->assertNoContent();

        $this->assertModelMissing($ludoteca);
    }
}
