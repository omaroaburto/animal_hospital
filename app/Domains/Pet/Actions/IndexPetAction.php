<?php

namespace App\Domains\Pet\Actions;

use App\Domains\Pet\Models\Pet;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class IndexPetAction
{
    public function __invoke(array $filters): Collection|LengthAwarePaginator
    {
        $query = Pet::with(['breed.species', 'client']);

        // Si viene 'all' y es verdadero, retornamos la colección completa sin paginar
        if (!empty($filters['all'])) {
            return $query->get();
        }

        return $query
            // 1. Filtro condicional para is_active
            ->when(array_key_exists('is_active', $filters) && $filters['is_active'] !== null, function ($q) use ($filters) {
                return $q->where('is_active', $filters['is_active']);
            })
            // 2. Filtro condicional para client_id (si necesitas validarlo en un request específico)
            ->when(!empty($filters['client_id']), function ($q) use ($filters) {
                return $q->where('client_id', $filters['client_id']);
            })
            ->paginate(
                perPage: (int) ($filters['per_page'] ?? 10),
                page: (int) ($filters['page'] ?? 1)
            );
    }
}
