<?php

namespace App\Domains\Pets\Actions;

use App\Domains\Pets\Models\Species;

class UpdateSpeciesAction
{
    public function __invoke(array $validatedData, Species $species): Species
    {
        $species->update($validatedData);
        return $species->refresh();
    }
}
