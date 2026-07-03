<?php

namespace App\domains\Auth\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'success'     => $this['success'],
            'message'     => $this['message'],
            'accessToken' => $this['access_token'],
            'tokenType'   => $this['token_type'],
            'expiresIn'   => $this['expires_in'],
        ];
    }
}
