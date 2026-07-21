<?php

namespace App\Domains\Pet\Actions; // Ajusta el namespace según tu estructura

use App\Domains\Pet\Models\Species; // Ajusta el namespace de tu modelo
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class IndexSpeciesAction
{
    public function __invoke(array $filters): Collection|LengthAwarePaginator
    {
        $query = Species::query();

        return !empty($filters['all'])
            ? $query->get()
            : $query->paginate(
                perPage: (int) ($filters['per_page'] ?? 10),
                page: (int) ($filters['page'] ?? 1)
            );
    }
}
