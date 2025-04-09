<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\UsuarioController
 */
final class UsuarioControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $usuarios = Usuario::factory()->count(3)->create();

        $response = $this->get(route('usuarios.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\UsuarioController::class,
            'store',
            \App\Http\Requests\UsuarioStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $name = fake()->name();
        $email = fake()->safeEmail();
        $password = fake()->password();

        $response = $this->post(route('usuarios.store'), [
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);

        $usuarios = Usuario::query()
            ->where('name', $name)
            ->where('email', $email)
            ->where('password', $password)
            ->get();
        $this->assertCount(1, $usuarios);
        $usuario = $usuarios->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $usuario = Usuario::factory()->create();

        $response = $this->get(route('usuarios.show', $usuario));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\UsuarioController::class,
            'update',
            \App\Http\Requests\UsuarioUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $usuario = Usuario::factory()->create();
        $name = fake()->name();
        $email = fake()->safeEmail();
        $password = fake()->password();

        $response = $this->put(route('usuarios.update', $usuario), [
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);

        $usuario->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name, $usuario->name);
        $this->assertEquals($email, $usuario->email);
        $this->assertEquals($password, $usuario->password);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $usuario = Usuario::factory()->create();

        $response = $this->delete(route('usuarios.destroy', $usuario));

        $response->assertNoContent();

        $this->assertModelMissing($usuario);
    }
}
