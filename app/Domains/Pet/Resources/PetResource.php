<?php

namespace App\Domains\Pet\Resources;

use App\Domains\Client\Resources\ClientResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PetResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'birth_date'        => $this->birth_date,
            'death_date'        => $this->death_date,
            'is_active'         => $this->is_active,
            'gender'            => $this->gender,
            'microchip'         => $this->microchip,
            'microchip_number'  => $this->microchip_number,
            'color'             => $this->color,
            'sterilized'        => $this->sterilized,
            'photo_url'         => $this->photo_url,
            'photo_id'          => $this->photo_id,
            'notes'             => $this->notes,
            'breed'             => $this->whenLoaded('breed', fn() => $this->breed->name),
            // Relaciones anidadas protegidas contra consultas N+1
            'species_name'            => $this->whenLoaded('breed', function () {
                return $this->breed->relationLoaded('species') ? $this->breed->species->name : null;
            }),
            'species_scientific_name' => $this->whenLoaded('breed', function () {
                return $this->breed->relationLoaded('species') ? $this->breed->species->scientific_name : null;
            }),
            'client' => new ClientResource($this->whenLoaded('client')),
        ];
    }
}
