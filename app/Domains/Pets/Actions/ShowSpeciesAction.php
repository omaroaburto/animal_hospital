<?php

namespace App\Domains\Pets\Actions;

use App\Domains\Pets\Models\Species;

class ShowSpeciesAction
{
    public function __invoke(Species $species): Species
    {
        return $species;
    }
}
