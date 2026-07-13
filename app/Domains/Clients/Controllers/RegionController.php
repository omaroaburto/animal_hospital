<?php

namespace App\Domains\Clients\Controllers;

use App\Domains\Clients\Actions\IndexRegionAction;
use App\Domains\Clients\Actions\ShowRegionAction;
use App\Domains\Clients\Models\Region;
use App\Domains\Clients\Resources\RegionCollection;
use App\Domains\Clients\Resources\RegionResource;
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
    ): RegionResource
    {
        return new RegionResource($region);
    }
    public function showWithCommunes(
        Region $region,
        ShowRegionAction $showRegion
    ): RegionResource
    {
        $result = $showRegion($region);
        return new RegionResource($result);
    }

}
