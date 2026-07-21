<?php

namespace App\Domains\Pets\Actions;

use App\Domains\Pets\Models\Breed;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetBreedBySpeciesAction
{
    public function __invoke(array $filters, int $speciesId): LengthAwarePaginator
    {
        $perPage  = $filters['per_page'] ?? 10;
        $page     = $filters['page'] ?? 1;

        return Breed::query()
            ->where('species_id', $speciesId)
            ->paginate(perPage: $perPage, page: $page);
    }
}
