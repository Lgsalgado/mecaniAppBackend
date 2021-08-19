<?php

use App\Http\Controllers\Api\SolicitudController;
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
    // Rutas para solicitudes
    //Obtener solicitudes pendientes
    Route::get('/requests/pending', [SolicitudController::class, 'pending']);
    // Obtener solicitudes aprobadas
    Route::get('/requests/approved', [SolicitudController::class, 'approved']);
    Route::get('/requests/rejected', [SolicitudController::class, 'rejected']);
    Route::post('/request', [SolicitudController::class, 'saveRequest']);
    Route::put('/request/approve/{id}', [SolicitudController::class, 'approveRequest']);
    Route::put('/request/reject/{id}', [SolicitudController::class, 'rejectRequest']);
    Route::get('/user/request', [SolicitudController::class, 'userRequest']);
    Route::post('/request/{id}', [SolicitudController::class, 'updateRequest']);
});
