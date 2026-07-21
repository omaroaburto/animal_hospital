<?php

namespace App\Domains\Pet\Actions;

use App\Domains\Pet\Models\Breed;

class StoreBreedAction
{
    public function __invoke(array $validatedData): Breed
    {
        $breed = Breed::create($validatedData);
        return $breed->load(['species']);
    }
}
