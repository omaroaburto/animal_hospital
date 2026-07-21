<?php

namespace App\Domains\Pet\Actions;

use App\Domains\Pet\Models\Breed;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class IndexBreedAction
{
    public function __invoke(array $filters): Collection|LengthAwarePaginator
    {
        $query = Breed::query();

        return !empty($filters['all'])
            ? $query->get()
            : $query->paginate(
                perPage: (int) ($filters['per_page'] ?? 10),
                page: (int) ($filters['page'] ?? 1)
            );
    }
}
