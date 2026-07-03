<?php

namespace App\domains\Auth\Controllers;

use App\domains\Auth\Actions\IndexRoleAction;
use App\domains\Auth\Actions\StoreRoleAction;
use App\domains\Auth\Actions\UpdateRoleAction;
use App\domains\Auth\Models\Role;
use App\domains\Auth\Models\User;
use App\domains\Auth\Requests\StoreRoleRequest;
use App\domains\Auth\Requests\UpdateRoleRequest;
use App\domains\Auth\Resources\RoleCollection;
use App\domains\Auth\Resources\RoleResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    public function index(IndexRoleAction $indexRoleAction)
    {
        Gate::authorize('view', Role::class);
        return new RoleCollection($indexRoleAction());
    }

    public function show(Role $role): RoleResource
    {
        Gate::authorize('viewAny', $role);
        return new RoleResource($role);
    }

    public function store(StoreRoleRequest $request,
                          StoreRoleAction $storeRoleAction
    ): RoleResource
    {

        $role = $storeRoleAction($request->validated());
        return new RoleResource($role);
    }
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
