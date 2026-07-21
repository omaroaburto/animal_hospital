<?php

namespace App\Domains\Client\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommuneResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'   => $this['id'],
            'name' => $this['name'],
        ];
    }
}
