<?php

use App\domains\Auth\Controllers\AdminController;
use App\domains\Auth\Controllers\AuthController;
use App\domains\Auth\Controllers\RoleController;
use App\Domains\Clients\Controllers\ClientController;
use App\Domains\Clients\Controllers\RegionController;
use Illuminate\Support\Facades\Route;


/*************************************************************
 ***                   RUTAS PÚBLICAS                      ***
 *************************************************************/

Route::post('v1/login',[AuthController::class,'login']);
Route::post('refresh',[AuthController::class,'refresh']);
//Verificación de email (API)
Route::get('v1/email/verify', [AuthController::class, 'verifyEmail']);
Route::get('v1/regions', [RegionController::class, 'index']);
Route::get('v1/regions/{region}', [RegionController::class, 'show']);
Route::get('v1/regions/{region}/communes', [RegionController::class, 'showWithCommunes']);
Route::post('v1/register',[ClientController::class, 'store']);
Route::get('v1/clients',[ClientController::class, 'index']);
Route::get('v1/clients/{client}',[ClientController::class, 'show']);
Route::match(['put','patch'],'v1/clients/{client}',[ClientController::class, 'update']);
Route::delete('v1/clients/{client}',[ClientController::class, 'destroy']);
Route::post('v1/clients/restore/{client}',[ClientController::class, 'restore']);
/*************************************************************
 ***      RUTAS CON JWT Y CUENTAS VERIFICADAS (email)      ***
 *************************************************************/

Route::middleware(['jwt.auth', 'verified:api'])->prefix('v1/')->group(function () {
    /****************************************
     *           rutas para admin           *
     ****************************************/

    //ROLES
    Route::get('roles',[RoleController::class, 'index']);
    Route::get('roles/{role}',[RoleController::class, 'show']);
    Route::post('roles',[RoleController::class, 'store']);
    Route::match(['put','patch'],'roles/{role}',[RoleController::class, 'update']);

    //USUARIOS

    Route::apiResource('admins',AdminController::class);
    Route::post('/admins/{admin}/restore', [AdminController::class, 'restore'])
    ->name('admins.restore');
    Route::post('logout',[AuthController::class,'logout']);
});
