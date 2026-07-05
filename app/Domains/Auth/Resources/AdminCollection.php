<?php

namespace App\Domains\Auth\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AdminCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->map(function($admin){
                return new AdminResource($admin);
            }),
            'meta' => [
                'total_admin' => $this->collection->count(),
                'version'     => '1.0.0'
            ]
        ];
    }
}
