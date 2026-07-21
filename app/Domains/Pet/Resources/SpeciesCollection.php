<?php

namespace App\Domains\Pet\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SpeciesCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->map(function ($species) {
                return new SpeciesResource($species);
            }),
            'meta' => [
                'total_species' => $this->collection->count(),
                'version'       => '1.0.0'
            ]
        ];
    }
}
