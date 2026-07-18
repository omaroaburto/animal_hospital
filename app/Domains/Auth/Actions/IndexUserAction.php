<?php

namespace App\Domains\Auth\Actions;

use App\Domains\Auth\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class IndexUserAction
{
    public function __invoke(array $filters): Collection|LengthAwarePaginator
    {
        $query = User::whereHas('role', function ($q) {
            $q->where('name', 'admin');
        })
        ->with('role')
        // Filtro condicional para is_active usando el array sanitizado
        ->when(array_key_exists('is_active', $filters) && $filters['is_active'] !== null, function ($q) use ($filters) {
            $q->where('is_active', $filters['is_active']);
        });

        // Retorno dinámico consistente (all vs pagination)
        return !empty($filters['all'])
            ? $query->get()
            : $query->paginate(
                perPage: $filters['per_page'] ?? 10,
                page: $filters['page'] ?? 1
            );
    }
}
