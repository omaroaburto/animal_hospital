<?php

namespace App\Domains\Auth\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'first_name'    => $this['first_name'],
            'last_name'     => $this['last_name'],
            'email'         => $this['email'],
            'phone'         => $this['phone'],
            'avatar_url'    => $this['avatar_url'],
            'avatar_id'     => $this['avatar_id'],
            'is_active'     => $this['is_active'],
            'last_login_at' => $this['last_login_at']
        ];
    }
}
