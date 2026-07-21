<?php

use App\domains\Auth\Controllers\AdminController;
use App\domains\Auth\Controllers\AuthController;
use App\domains\Auth\Controllers\RoleController;
use App\Domains\Client\Controllers\ClientController;
use App\Domains\Client\Controllers\ClientPetIndexController;
use App\Domains\Client\Controllers\RegionController;
use App\Domains\Pet\Controllers\BreedController;
use App\Domains\Pet\Controllers\PetController;
use App\Domains\Pet\Controllers\SpeciesController;
use Illuminate\Support\Facades\Route;


/*************************************************************
 ***                   RUTAS PÚBLICAS                      ***
 *************************************************************/
Route::post('v1/auth/register', [ClientController::class, 'store']);
Route::post('v1/auth/login', [AuthController::class, 'login']);
Route::post('v1/auth/refresh', [AuthController::class, 'refresh']);
Route::post('v1/auth/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('v1/auth/reset-password', [AuthController::class, 'resetPassword'])
    ->name('password.update');
//Route::get('v1/reset-password', [PasswordResetController::class, 'create'])
//->name('password.reset');
//Verificación de email (API)
Route::get('v1/email/verify', [AuthController::class, 'verifyEmail']);
//regiones y comunas
Route::get('v1/regions', [RegionController::class, 'index']);
Route::get('v1/regions/{region}', [RegionController::class, 'show']);
Route::get('v1/regions/{region}/communes', [RegionController::class, 'showWithCommunes']);


/*************************************************************
 ***      RUTAS CON JWT Y CUENTAS VERIFICADAS (email)      ***
 *************************************************************/

Route::middleware(['jwt.auth', 'verified:api'])->prefix('v1/')->group(function () {
    /****************************************
     *           rutas para admin           *
     ****************************************/

    //ROLES
    Route::get('roles', [RoleController::class, 'index']);
    Route::get('roles/{role}', [RoleController::class, 'show']);
    Route::post('roles', [RoleController::class, 'store']);
    Route::match(['put', 'patch'], 'roles/{role}', [RoleController::class, 'update']);

    //USUARIOS

    Route::apiResource('admins', AdminController::class);
    Route::post('/admins/{admin}/restore', [AdminController::class, 'restore'])
        ->name('admins.restore');
    Route::post('logout', [AuthController::class, 'logout']);

    //CLIENTES
    Route::get('clients', [ClientController::class, 'index']);
    Route::get('clients/{client}', [ClientController::class, 'show']);
    Route::get('clients/{client}/pets', [ClientPetIndexController::class, 'clientPetIndex']);
    Route::match(['put', 'patch'], 'clients/{client}', [ClientController::class, 'update']);
    Route::delete('clients/{client}', [ClientController::class, 'destroy']);
    Route::post('clients/restore/{client}', [ClientController::class, 'restore']);

    //MASCOTAS
    Route::apiResource('species', SpeciesController::class);
    Route::get('species/{species}/breeds', [SpeciesController::class, 'indexSpeciesBreed']);
    Route::apiResource('breeds', BreedController::class);
    Route::get('breeds/{breed}/pets', [BreedController::class, 'indexBreedPet']);
    Route::apiResource('pets', PetController::class);
    Route::post('pets/{pet}/restore', [PetController::class, 'restore']);
});
