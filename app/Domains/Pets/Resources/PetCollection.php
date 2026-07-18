<?php

namespace App\Domains\Pets\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PetCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->map(function($pet){
                return new PetResource($pet);
            }),
            'meta' => [
                'total_pets' => $this->collection->count(),
                'version'    => '1.0.0'
            ]
        ];
    }
}
