<?php

namespace App\Domains\Pet\Actions;

use App\Domains\Pet\Models\Pet;

class RestorePetAction
{
    public function __invoke(Pet $pet): string
    {
        $pet->update(['is_active' => true]);
        return $pet->name;
    }
}
