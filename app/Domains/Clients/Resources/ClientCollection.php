<?php

namespace App\Domains\Clients\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ClientCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->map(function($client){
                return new ClientResource($client);
            }),
            'meta' => [
                'total_clients' => $this->collection->count(),
                'version'       => '1.0.0'
            ],
        ];
    }
}
