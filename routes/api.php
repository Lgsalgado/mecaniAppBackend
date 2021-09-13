<?php

use App\Http\Controllers\Api\PromocionController;
use App\Http\Controllers\Api\SolicitudController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\MecanicaController;
use App\Http\Controllers\Api\ComplainController;
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
    Route::put('/auth/user', [UserController::class, 'updateUserProfile']);

    // Rutas para solicitudes
    // Obtener solicitud por ID
    Route::get('/user/request/{id}', [SolicitudController::class, 'findById']);
    //Obtener solicitudes pendientes
    Route::get('/requests/pending', [SolicitudController::class, 'pending']);
    // Obtener solicitudes aprobadas
    Route::get('/requests/approved', [SolicitudController::class, 'approved']);
    // Obtener solicitudes rechazadas
    Route::get('/requests/rejected', [SolicitudController::class, 'rejected']);
    // Obtener registros completados
    Route::get('/requests/completed', [SolicitudController::class, 'completed']);
    Route::get('/requests/approveds', [SolicitudController::class, 'completedA']);
   // Insertar solicitud
    Route::post('/request', [SolicitudController::class, 'saveRequest']);
    Route::post('/requesta', [SolicitudController::class, 'saveRequestA']);
    // Aprobar solicitud
    Route::put('/request/approve/{id}', [SolicitudController::class, 'approveRequest']);
    // Rechazar solicitud
    Route::put('/request/reject/{id}', [SolicitudController::class, 'rejectRequest']);
    // Inactivar taller
    Route::put('/request/inactive/{id}', [SolicitudController::class, 'inactiveRequest']);
    // Obtener registros inactivos
    Route::get('/requests/inactived', [SolicitudController::class, 'inactived']);
    // Rechazar solicitud
    Route::put('/request/complete/{id}', [SolicitudController::class, 'completeRequest']);
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
    // Obtener taller
    Route::get('/taller/{id}', [MecanicaController::class, 'getById']);
    // Actualizar taller
    Route::put('/taller/{id}', [MecanicaController::class, 'updateWorkshop']);

    // Crear promocion
    Route::post('/promocion', [PromocionController::class, 'savePromocion']);
    // Obtener promociones activas
    Route::get('/promocions/actived/{id}', [PromocionController::class, 'actived']);
    // Obtener promociones inactivas
    Route::get('/promocions/inactived/{id}', [PromocionController::class, 'inactived']);
    // Inactivar promocion
    Route::put('/promocion/inactive/{id}', [PromocionController::class, 'inactivePromocion']);
    // Activar promocion
    Route::put('/promocion/active/{id}', [PromocionController::class, 'activePromocion']);

    //Obtener queja pendientes
    Route::get('/quejas/{id}/pending', [ComplainController::class, 'pending']);
    //Obtener queja aprobadas
    Route::get('/quejas/{id}/approved', [ComplainController::class, 'approved']);
    //Obtener queja rechazadas
    Route::get('/quejas/{id}/rejected', [ComplainController::class, 'rejected']);
    //Rechazar queja
    Route::put('/queja/reject/{id}', [ComplainController::class, 'reject']);
    //Aprobar queja
    Route::put('/queja/approve/{id}', [ComplainController::class, 'approve']);
    //Responder queja
    Route::put('/queja/answer/{id}', [ComplainController::class, 'answer']);



});
