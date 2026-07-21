<?php

namespace App\Domains\Client\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class ClientResource extends JsonResource
{
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,

            // User
            'first_name' => $this->whenLoaded('user', fn() => $this->user->first_name),
            'last_name' => $this->whenLoaded('user', fn() => $this->user->last_name),
            'email' => $this->whenLoaded('user', fn() => $this->user->email),
            'phone' => $this->whenLoaded('user', fn() => $this->user->phone),
            'avatar_url' => $this->whenLoaded('user', fn() => $this->user->avatar_url),
            'avatar_id' => $this->whenLoaded('user', fn() => $this->user->avatar_id),
            'is_active' => $this->whenLoaded('user', fn() => $this->user->is_active),

            // Client
            'document_type' => $this->document_type,
            'document_number' => $this->document_number,
            'notes' => $this->notes,
            'secondary_phone' => $this->secondary_phone,
            'street' => $this->street,
            'number' => $this->number,
            'apartment' => $this->apartment,

            // Location
            'commune' => $this->whenLoaded('commune', fn() => $this->commune->name),
            'region' => $this->when(
                $this->relationLoaded('commune')
                    && $this->commune->relationLoaded('region'),
                fn() => $this->commune->region->name,
            ),
        ];
    }
}
