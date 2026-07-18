<?php

namespace App\Domains\Pets\Actions;

use App\Domains\Pets\Models\Breed;

class StoreBreedAction
{
    public function __invoke(array $validatedData): Breed 
    {
        $breed = Breed::create($validatedData);
        return $breed->load(['species']);
    }
}