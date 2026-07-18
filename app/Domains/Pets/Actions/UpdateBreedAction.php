<?php

namespace App\Domains\Pets\Actions;

use App\Domains\Pets\Models\Breed;

class UpdateBreedAction
{
    public function __invoke(array $validatedData, Breed $breed): Breed 
    {
        $breed->update($validatedData);
        $breed->refresh();
        return $breed->load(['species']);
    }
}