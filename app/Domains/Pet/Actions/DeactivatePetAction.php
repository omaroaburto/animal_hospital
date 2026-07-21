<?php

namespace App\Domains\Pet\Actions;

use App\Domains\Pet\Models\Pet;

class DeactivatePetAction
{
    public function __invoke(Pet $pet): string
    {
        $pet->update(['is_active' => false]);
        return $pet->name;
    }
}
