<?php

namespace App\Domains\Pet\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BreedCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->map(function ($breed) {
                return new BreedResource($breed);
            }),
            'meta' => [
                'total_breeds' => $this->collection->count(),
                'version'      => '1.0.0'
            ]
        ];
    }
}
