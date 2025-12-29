<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DniController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PlayroomController;
use App\Http\Controllers\RoleUserLudotecaController;
use App\Http\Controllers\UserController;
use App\Models\Bonus;
use App\Models\Playroom;
use App\Models\RoleUserLudoteca;
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

use App\Http\Controllers\BonusProductController;
use App\Http\Controllers\BonusController;


Route::post('/login', [AuthController::class, 'login']);

use App\Http\Controllers\KidController;

use App\Http\Controllers\SaleController;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/sales', [SaleController::class, 'store']);
});


Route::post('/dnis', [DniController::class, 'store']);
Route::get('/dnis/{dni}/kids', [DniController::class, 'kids']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/kids', [KidController::class, 'index']);
    Route::get('/kids/{kid}/bonus', [KidController::class, 'bonus']);
    Route::post('/attendances/entry', [AttendanceController::class, 'entry']);
    Route::post('/attendances/exit', [AttendanceController::class, 'exit']);
    Route::get('/attendances/current/{kidId}', [AttendanceController::class, 'current']);
});

Route::get('/kids/{kid}/bonus', function ($kidId) {
    return Bonus::where('kid_id', $kidId)
        ->sum('remaining_minutes');
})->middleware('auth:sanctum');

//----------------------------- RUTAS VERIFICADAS CON LOGIN -----------------------------//

Route::middleware(['auth:sanctum'])->group(function () {
    // rutas protegidas
    Route::apiResource('users', UserController::class);
    Route::middleware('auth:sanctum')->get('me/ludotecas', [UserController::class, 'myLudotecas']);
    Route::middleware('auth:sanctum')->get('playrooms', [PlayroomController::class, 'index']);
});

Route::middleware('auth:sanctum')->group(function () {

    // Catálogo de bonos por ludoteca
    Route::get('/playrooms/{playroom}/bonus-products', [BonusProductController::class, 'index']);

    // Comprar bono
    Route::post('/bonuses', [BonusController::class, 'store']);

    // Minutos restantes de un niño
    Route::get('/kids/{kid}/bonus', [BonusController::class, 'remaining']);
});

//----------------------------- RUTAS VERIFICADAS CON ADMIN -----------------------------//


Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {

    Route::post('/playrooms', [PlayroomController::class, 'store']);
    Route::apiResource('employees', EmployeeController::class)->only(['store']);
});


Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    // Asignar un rol a un usuario para una ludoteca
    Route::post(
        'ludotecas/{ludoteca}/users/{user}/roles/{role}',
        [RoleUserLudotecaController::class, 'attach']
    );
    // Quitar:
    Route::delete(
        'ludotecas/{ludoteca}/users/{user}/roles/{role}',
        [RoleUserLudotecaController::class, 'detach']
    );
});
