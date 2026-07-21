<?php

namespace App\Domains\Client\Actions;

use App\Domains\Client\Models\Region;
use Illuminate\Support\Collection;

class IndexRegionAction
{
    public function __invoke(): Collection
    {
        return Region::all();
    }
}
