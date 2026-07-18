<?php

namespace App\Domains\Pets\Actions;

use App\Domains\Pets\Models\Pet;

class ShowPetAction
{
    public function __invoke(Pet $pet): Pet
    {
        return $pet->loadMissing(['breed.species', 'client']);
    }
}
