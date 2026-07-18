<?php

namespace App\Domains\Pets\Actions;

use App\Domains\Pets\Models\Pet;

class RestorePetAction
{
    public function __invoke(Pet $pet): string
    {
        $pet->update(['is_active' => true]);
        return $pet->name;
    }
}
