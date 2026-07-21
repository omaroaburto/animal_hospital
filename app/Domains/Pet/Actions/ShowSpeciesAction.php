<?php

namespace App\Domains\Pet\Actions;

use App\Domains\Pet\Models\Species;

class ShowSpeciesAction
{
    public function __invoke(Species $species): Species
    {
        return $species;
    }
}
