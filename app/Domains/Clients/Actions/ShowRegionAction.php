<?php

namespace App\Domains\Clients\Actions;

use App\Domains\Clients\Models\Region;

class ShowRegionAction
{
    public function __invoke(Region $region): Region
    {
        return $region->load(['communes']);
    }
}
