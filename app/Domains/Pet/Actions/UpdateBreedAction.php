<?php

namespace App\Domains\Pet\Actions;

use App\Domains\Pet\Models\Breed;

class UpdateBreedAction
{
    public function __invoke(array $validatedData, Breed $breed): Breed
    {
        $breed->update($validatedData);
        $breed->refresh();
        return $breed->load(['species']);
    }
}
