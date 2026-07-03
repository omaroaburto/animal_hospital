<?php

use App\domains\Auth\Controllers\AuthController;
use App\domains\Auth\Controllers\RoleController;
use Illuminate\Support\Facades\Route;


/*************************************************************
 ***                   RUTAS PÚBLICAS                      ***
 *************************************************************/

Route::post('v1/login',[AuthController::class,'login']);

/*************************************************************
 ***      RUTAS CON JWT Y CUENTAS VERIFICADAS (email)      ***
 *************************************************************/

Route::middleware(['jwt.auth', 'verified'])->prefix('v1/')->group(function () {
    /****************************************
     *           rutas para admin           *
     ****************************************/

    //ROLES
    Route::get('roles',[RoleController::class, 'index']);
    Route::get('roles/{role}',[RoleController::class, 'show']);
    Route::post('roles',[RoleController::class, 'store']);
    Route::match(['put','patch'],'roles/{role}',[RoleController::class, 'update']);
    //USUARIOS
    Route::post('logout',[AuthController::class,'logout']);
    Route::post('refresh',[AuthController::class,'refresh']);

});
