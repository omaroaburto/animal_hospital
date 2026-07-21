<?php

namespace App\Domains\Pet\Actions;

use App\Domains\Pet\Contracts\ClientPetRepositoryInterface;
use App\Domains\Pet\Models\Pet;
use Illuminate\Pagination\LengthAwarePaginator;

class GetPetsByClientAction implements ClientPetRepositoryInterface
{
    public function __invoke(int $clientId, array $filters): LengthAwarePaginator
    {
        $perPage  = $filters['per_page'] ?? 10;
        $page     = $filters['page'] ?? 1;

        return Pet::query()
            ->with(['breed.species'])
            ->where('client_id', $clientId) // Usamos el ID recibido del cliente
            ->when(array_key_exists('is_active', $filters), function ($query) use ($filters) {
                return $query->where('is_active', $filters['is_active']);
            })
            ->paginate(perPage: $perPage, page: $page);
    }
}
