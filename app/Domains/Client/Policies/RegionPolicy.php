<?php

namespace App\Domains\Client\Policies;

use App\Domains\Auth\Models\User;
use App\Domains\Client\Models\Client;
use Illuminate\Auth\Access\HandlesAuthorization;

class RegionPolicy
{
    use HandlesAuthorization;
    public function viewAny(User $user): bool
    {
        return false;
    }
    public function view(User $user, Client $client): bool
    {
        return false;
    }
    public function create(User $user): bool
    {
        return false;
    }
    public function update(User $user, Client $client): bool
    {
        return false;
    }
    public function delete(User $user, Client $client): bool
    {
        return false;
    }
    public function restore(User $user, Client $client): bool
    {
        return false;
    }
    public function forceDelete(User $user, Client $client): bool
    {
        return false;
    }
}
