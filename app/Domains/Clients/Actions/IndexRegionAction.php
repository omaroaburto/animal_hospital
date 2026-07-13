<?php

namespace App\Domains\Clients\Actions;

use App\Domains\Clients\Models\Region;
use Illuminate\Support\Collection;

class IndexRegionAction
{
    public function __invoke(): Collection
    {
        return Region::all();
    }
}
