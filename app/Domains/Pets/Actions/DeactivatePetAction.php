<?php

namespace App\Domains\Pets\Actions;

use App\Domains\Pets\Models\Pet;

class DeactivatePetAction
{
    public function __invoke(Pet $pet): string
    {
        $pet->update(['is_active' => false]); 
        return $pet->name;
    }
}
