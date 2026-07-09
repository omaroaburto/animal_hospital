<?php

namespace App\Domains\Auth\Controllers;

use App\Domains\Auth\Actions\DeactivateUserAction;
use App\Domains\Auth\Actions\IndexUserAction;
use App\Domains\Auth\Actions\RestoreUserAction;
use App\Domains\Auth\Actions\SendVerificationEmailAction;
use App\Domains\Auth\Actions\StoreUserAction;
use App\Domains\Auth\Actions\UpdateUserAction;
use App\Domains\Auth\DTOs\CreateUserDto;
use App\Domains\Auth\DTOs\UpdateUserDto;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Requests\StoreAdminRequest;
use App\Domains\Auth\Requests\UpdateAdminRequest;
use App\Domains\Auth\Resources\AdminCollection;
use App\Domains\Auth\Resources\AdminResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    public function index(Request $request, IndexUserAction $indexAdmin): AdminCollection
    {
        Gate::authorize('viewAny', User::class);
        $admins = $indexAdmin($request);
        return new AdminCollection($admins);
    }

    public function store(
        StoreAdminRequest $request,
        StoreUserAction $storeAdmin,
        SendVerificationEmailAction $sendVerification,
    )//: AdminResource
    {
        Gate::authorize('createAdmin', User::class);
        $validatedData = CreateUserDto::fromRequest($request);
        //crea usuario
        $admin = $storeAdmin($validatedData, 'admin', $request->file('avatar'));
        //envia correo de verificación
        $sendVerification($admin);
        return new AdminResource($admin);
    }


    public function show(
        User $admin
    ): AdminResource
    {
        Gate::authorize('view',$admin);
        return new AdminResource($admin);
    }


    public function update(
        UpdateAdminRequest $request,
        User $admin,
        UpdateUserAction $updateAdmin
    ): AdminResource
    {
        Gate::authorize('update',$admin);
        // 1. Construimos el DTO abstrayendo el mapeo del controlador
        $validatedData = UpdateUserDto::fromRequest($request);

        //Ejecutamos el Action pasándole el DTO, el modelo y el archivo físico
        $result = $updateAdmin($validatedData, $admin, $request->file('avatar'));

        return new AdminResource($result);
    }


    public function destroy(
        User $admin,
        DeactivateUserAction $deactivateAdmin
    ): JsonResponse
    {
        Gate::authorize('delete', $admin);
        $deactivateAdmin($admin);
        return response()->json([
            'success' => true,
            'message' => "El administrador {$admin->email} se ha desactivado."
        ], Response::HTTP_OK);
    }

    public function restore(
        User $admin,
        RestoreUserAction $restoreUser
    ): JsonResponse
    {
        Gate::authorize('restore', $admin);
        $restoreUser($admin);
        return response()->json([
            'success' => true,
            'message' => "El administrador {$admin->email} se ha restaurado."
        ], Response::HTTP_OK);
    }
}
