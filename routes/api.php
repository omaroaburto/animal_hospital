<?php

use App\domains\Auth\Controllers\AdminController;
use App\domains\Auth\Controllers\AuthController;
use App\domains\Auth\Controllers\RoleController;
use Illuminate\Support\Facades\Route;


/*************************************************************
 ***                   RUTAS PÚBLICAS                      ***
 *************************************************************/

Route::post('v1/login',[AuthController::class,'login']);
Route::post('refresh',[AuthController::class,'refresh']);
//Verificación de email (API)
Route::get('v1/email/verify', [AuthController::class, 'verifyEmail']);

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
