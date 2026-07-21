<?php

namespace App\Domains\Client\Actions;

use App\Domains\Client\Models\Region;

class ShowRegionAction
{
    public function __invoke(Region $region): Region
    {
        return $region->load(['communes']);
    }
}
