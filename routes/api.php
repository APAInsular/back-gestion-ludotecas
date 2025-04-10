<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
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


Route::post('/login', [AuthController::class, 'login']);

//----------------------------- RUTAS VERIFICADAS CON LOGIN -----------------------------//

Route::middleware(['auth:sanctum'])->group(function () {
    // rutas protegidas
    Route::apiResource('users', UserController::class);

});

//----------------------------- RUTAS VERIFICADAS CON ADMIN -----------------------------//


Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
   
   Route::get('/admin', function (Request $request) {
        return response()->json([
            'message' => '¡Bienvenido, Admin!'
        ], 200);
    });
});