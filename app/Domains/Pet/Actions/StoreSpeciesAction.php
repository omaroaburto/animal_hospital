<?php

namespace App\Domains\Pet\Actions;

use App\Domains\Pet\Models\Species;

class StoreSpeciesAction
{
    public function __invoke(array $validatedData): Species
    {
        return Species::create($validatedData);
    }
}
