<?php

namespace App\Domains\Auth\Controllers;

use App\Domains\Auth\Actions\IndexRoleAction;
use App\Domains\Auth\Actions\ShowRoleAction;
use App\Domains\Auth\Actions\StoreRoleAction;
use App\Domains\Auth\Actions\UpdateRoleAction;
use App\Domains\Auth\Models\Role;
use App\Domains\Auth\Requests\StoreRoleRequest;
use App\Domains\Auth\Requests\UpdateRoleRequest;
use App\Domains\Auth\Resources\RoleCollection;
use App\Domains\Auth\Resources\RoleResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    //listar roles
    public function index(IndexRoleAction $indexRoleAction)
    {
        Gate::authorize('viewRole', Role::class);
        return new RoleCollection($indexRoleAction());
    }

    //buscar rol por id o por name
    public function show(
        string $identifier,
        ShowRoleAction $showRole
    ): RoleResource
    {
        $role = $showRole($identifier);
        Gate::authorize('viewAny', $role);
        return new RoleResource($role);
    }

    //crear rol
    public function store(StoreRoleRequest $request,
                          StoreRoleAction $storeRoleAction
    ): RoleResource
    {
        Gate::authorize('create', Role::class);
        $role = $storeRoleAction($request->validated());
        return new RoleResource($role);
    }

    //actualizar rol
    public function update(
        UpdateRoleRequest $request,
        UpdateRoleAction $updateRoleAction,
        Role $role
    ): RoleResource
    {
        Gate::authorize('update', $role);
        return new RoleResource($updateRoleAction($request->validated(), $role));
    }
}
