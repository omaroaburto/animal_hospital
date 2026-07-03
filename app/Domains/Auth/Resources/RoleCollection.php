<?php

namespace App\domains\Auth\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RoleCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->map(function($role){
                return new RoleResource($role);
            }),
            'meta' => [
                'total_roles' => $this->collection->count(),
                'version' => '1.0.0'
            ]
        ];
    }
}
