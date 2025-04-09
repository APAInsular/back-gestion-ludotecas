<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::apiResource('ludotecas', App\Http\Controllers\LudotecaController::class);

Route::apiResource('usuarios', App\Http\Controllers\UsuarioController::class);

Route::apiResource('configuracions', App\Http\Controllers\ConfiguracionController::class);

Route::apiResource('rols', App\Http\Controllers\RolController::class);

Route::apiResource('foros', App\Http\Controllers\ForoController::class);

Route::apiResource('grupos', App\Http\Controllers\GrupoController::class);

Route::apiResource('empleados', App\Http\Controllers\EmpleadoController::class);

Route::apiResource('incidencias', App\Http\Controllers\IncidenciaController::class);

Route::apiResource('administradors', App\Http\Controllers\AdministradorController::class);

Route::apiResource('tutors', App\Http\Controllers\TutorController::class);

Route::apiResource('niños', App\Http\Controllers\NiñoController::class);

Route::apiResource('reservas', App\Http\Controllers\ReservaController::class);

Route::apiResource('servicios', App\Http\Controllers\ServicioController::class);

Route::apiResource('actividads', App\Http\Controllers\ActividadController::class);

Route::apiResource('comunicados', App\Http\Controllers\ComunicadoController::class);

Route::apiResource('menus', App\Http\Controllers\MenuController::class);

Route::apiResource('eventos', App\Http\Controllers\EventoController::class);


Route::apiResource('ludotecas', App\Http\Controllers\LudotecaController::class);

Route::apiResource('usuarios', App\Http\Controllers\UsuarioController::class);

Route::apiResource('configuracions', App\Http\Controllers\ConfiguracionController::class);

Route::apiResource('rols', App\Http\Controllers\RolController::class);

Route::apiResource('foros', App\Http\Controllers\ForoController::class);

Route::apiResource('grupos', App\Http\Controllers\GrupoController::class);

Route::apiResource('empleados', App\Http\Controllers\EmpleadoController::class);

Route::apiResource('incidencias', App\Http\Controllers\IncidenciaController::class);

Route::apiResource('administradors', App\Http\Controllers\AdministradorController::class);

Route::apiResource('tutors', App\Http\Controllers\TutorController::class);

Route::apiResource('niños', App\Http\Controllers\NiñoController::class);

Route::apiResource('reservas', App\Http\Controllers\ReservaController::class);

Route::apiResource('servicios', App\Http\Controllers\ServicioController::class);

Route::apiResource('actividads', App\Http\Controllers\ActividadController::class);

Route::apiResource('comunicados', App\Http\Controllers\ComunicadoController::class);

Route::apiResource('menus', App\Http\Controllers\MenuController::class);

Route::apiResource('eventos', App\Http\Controllers\EventoController::class);


Route::apiResource('ludotecas', App\Http\Controllers\LudotecaController::class);

Route::apiResource('usuarios', App\Http\Controllers\UsuarioController::class);

Route::apiResource('configuracions', App\Http\Controllers\ConfiguracionController::class);

Route::apiResource('rols', App\Http\Controllers\RolController::class);

Route::apiResource('foros', App\Http\Controllers\ForoController::class);

Route::apiResource('grupos', App\Http\Controllers\GrupoController::class);

Route::apiResource('empleados', App\Http\Controllers\EmpleadoController::class);

Route::apiResource('incidencias', App\Http\Controllers\IncidenciaController::class);

Route::apiResource('administradors', App\Http\Controllers\AdministradorController::class);

Route::apiResource('tutors', App\Http\Controllers\TutorController::class);

Route::apiResource('ninos', App\Http\Controllers\NinoController::class);

Route::apiResource('reservas', App\Http\Controllers\ReservaController::class);

Route::apiResource('servicios', App\Http\Controllers\ServicioController::class);

Route::apiResource('actividads', App\Http\Controllers\ActividadController::class);

Route::apiResource('comunicados', App\Http\Controllers\ComunicadoController::class);

Route::apiResource('menus', App\Http\Controllers\MenuController::class);

Route::apiResource('eventos', App\Http\Controllers\EventoController::class);


Route::apiResource('ludotecas', App\Http\Controllers\LudotecaController::class);

Route::apiResource('usuarios', App\Http\Controllers\UsuarioController::class);

Route::apiResource('configuracions', App\Http\Controllers\ConfiguracionController::class);

Route::apiResource('rols', App\Http\Controllers\RolController::class);

Route::apiResource('foros', App\Http\Controllers\ForoController::class);

Route::apiResource('grupos', App\Http\Controllers\GrupoController::class);

Route::apiResource('empleados', App\Http\Controllers\EmpleadoController::class);

Route::apiResource('incidencias', App\Http\Controllers\IncidenciaController::class);

Route::apiResource('administradors', App\Http\Controllers\AdministradorController::class);

Route::apiResource('tutors', App\Http\Controllers\TutorController::class);

Route::apiResource('ninos', App\Http\Controllers\NinoController::class);

Route::apiResource('reservas', App\Http\Controllers\ReservaController::class);

Route::apiResource('servicios', App\Http\Controllers\ServicioController::class);

Route::apiResource('actividads', App\Http\Controllers\ActividadController::class);

Route::apiResource('comunicados', App\Http\Controllers\ComunicadoController::class);

Route::apiResource('menus', App\Http\Controllers\MenuController::class);

Route::apiResource('eventos', App\Http\Controllers\EventoController::class);
