<?php

namespace App\Domains\Pets\Actions;

use App\Domains\Pets\Contracts\ClientPetRepositoryInterface;
use App\Domains\Pets\Models\Pet;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetPetsByClientAction implements ClientPetRepositoryInterface
{
    public function __invoke(int $clientId, array $filters) : LengthAwarePaginator
    {
        $perPage  = $filters['per_page'] ?? 10;
        $page     = $filters['page'] ?? 1;

        return Pet::query()
            ->with(['breed.species', 'client'])
            ->where('client_id', $clientId) // Usamos el ID recibido del cliente
            ->when(array_key_exists('is_active', $filters), function ($query) use ($filters) {
                return $query->where('is_active', $filters['is_active']);
            })
            ->paginate(perPage: $perPage, page: $page);
    }
}
