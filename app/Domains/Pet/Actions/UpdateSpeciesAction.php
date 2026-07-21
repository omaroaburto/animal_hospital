<?php

namespace App\Domains\Pet\Actions;

use App\Domains\Pet\Models\Species;

class UpdateSpeciesAction
{
    public function __invoke(array $validatedData, Species $species): Species
    {
        $species->update($validatedData);
        return $species->refresh();
    }
}
