<?php

namespace App\Domains\Pets\Actions;

use App\Domains\Pets\Models\Species;

class StoreSpeciesAction
{
    public function __invoke(array $validatedData): Species
    {
        return Species::create($validatedData);
    }
}
