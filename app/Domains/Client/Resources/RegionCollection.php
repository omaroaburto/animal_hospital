<?php

namespace App\Domains\Client\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RegionCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->map(function ($region) {
                return new RegionResource($region);
            }),
            'meta' => [
                'total_regions' => $this->collection->count(),
                'version'       => '1.0.0'
            ]
        ];
    }
}
