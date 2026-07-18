<?php

namespace App\Domains\Pets\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BreedResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'      => $this->id,
            'name'    => $this->name,
            'species' => $this->whenLoaded('species', fn () => $this->species->name),
        ];
    }
}
