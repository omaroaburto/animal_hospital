<?php

namespace App\Domains\Pet\Actions;

use App\Domains\Pet\Models\Pet;

class ShowPetAction
{
    public function __invoke(Pet $pet): Pet
    {
        return $pet->loadMissing(['breed.species', 'client']);
    }
}
