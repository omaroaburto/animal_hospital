<?php

namespace App\Domains\Client\Controllers;

use App\Domains\Client\Actions\IndexRegionAction;
use App\Domains\Client\Actions\ShowRegionAction;
use App\Domains\Client\Models\Region;
use App\Domains\Client\Resources\RegionCollection;
use App\Domains\Client\Resources\RegionResource;
use App\Http\Controllers\Controller;

class RegionController extends Controller
{
    public function index(IndexRegionAction $indexRegion): RegionCollection
    {
        $regions = $indexRegion();
        return new RegionCollection($regions);
    }
    public function show(
        Region $region,
    ): RegionResource {
        return new RegionResource($region);
    }
    public function showWithCommunes(
        Region $region,
        ShowRegionAction $showRegion
    ): RegionResource {
        $result = $showRegion($region);
        return new RegionResource($result);
    }
}
