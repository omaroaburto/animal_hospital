<?php

namespace App\Domains\Pet\Actions;

use App\Domains\Pet\Models\Pet;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetPetsByBreedAction
{
    public function __invoke(array $filters, int $breedId): LengthAwarePaginator
    {
        $perPage  = $filters['per_page'] ?? 10;
        $page     = $filters['page'] ?? 1;

        return Pet::query()
            ->where('breed_id', $breedId)
            ->paginate(perPage: $perPage, page: $page);
    }
}
