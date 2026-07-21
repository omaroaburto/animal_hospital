<?php

namespace App\Domains\Clients\Actions;

use App\Domains\Clients\Models\Client;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class IndexClientAction
{
    public function __invoke(array $filters): Collection|LengthAwarePaginator
    {
        $query = Client::with(['user', 'commune.region']);

        // 1. Filtro condicional para is_active (buscando en la relación 'user')
        $query->when(array_key_exists('is_active', $filters) && $filters['is_active'] !== null, function ($query) use ($filters) {
            $query->whereHas('user', function ($subQuery) use ($filters) {
                $subQuery->where('is_active', $filters['is_active']);
            });
        });

        // 2. Retorno dinámico según el parámetro 'all'
        $users = !empty($filters['all'])
            ? $query->get()
            : $query->paginate(
                perPage: $filters['per_page'] ?? 10,
                page: $filters['page'] ?? 1
            )->getCollection();
        return $users;
    }
}
