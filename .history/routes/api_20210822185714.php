<?php

use App\Http\Controllers\Api\SolicitudController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JwtAuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/register', [JwtAuthController::class, 'register']);
    Route::post('/login', [JwtAuthController::class, 'login']);
    Route::get('/user', [JwtAuthController::class, 'user']);
    Route::post('/token-refresh', [JwtAuthController::class, 'refresh']);
    Route::post('/logout', [JwtAuthController::class, 'signout']);
});

Route::group([
    'middleware' => 'jwt.auth'
], function () {
    // Ruta de usuario
    Route::put('/auth/user', UserController::class, 'updateUserProfile');

    // Rutas para solicitudes
    //Obtener solicitudes pendientes
    Route::get('/requests/pending', [SolicitudController::class, 'pending']);
    // Obtener solicitudes aprobadas
    Route::get('/requests/approved', [SolicitudController::class, 'approved']);
    // Obtener solicitudes rechazadas
    Route::get('/requests/rejected', [SolicitudController::class, 'rejected']);
    // Insertar solicitud
    Route::post('/request', [SolicitudController::class, 'saveRequest']);
    // Aprobar solicitud
    Route::put('/request/approve/{id}', [SolicitudController::class, 'approveRequest']);
    // Rechazar solicitud
    Route::put('/request/reject/{id}', [SolicitudController::class, 'rejectRequest']);
    // Obtener solicitud por usuario autenticado
    Route::get('/user/request', [SolicitudController::class, 'userRequest']);
    // Actualizar solicitud
    Route::post('/request/{id}', [SolicitudController::class, 'updateRequest']);
    // Eliminar solicitud
    Route::delete('/request/{id}', [SolicitudController::class, 'deleteRequest']);

    // Rutas para mecanica
    // Crear mecanica
    Route::post('/workshop', [MecanicaController::class, 'saveWorkshop']);
    // Actualizar mecanica
    Route::post('/workshop/{id}', [MecanicaController::class, 'updateWorkshop']);
    // Obtener mecanicas
    Route::get('/workshop', [MecanicaController::class, 'listAll']);
    // Obtener mecanicas por usuario
    Route::get('/user/workshop', [MecanicaController::class, 'userWorkshop']);
    // Eliminar mecanica
    Route::delete('/workshop', [MecanicaController::class, 'deleteWorkshop']);
});
