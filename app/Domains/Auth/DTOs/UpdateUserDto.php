<?php

namespace App\Domains\Auth\DTOs;

use App\Domains\Auth\Requests\UpdateAdminRequest;

class UpdateUserDto
{
    public function __construct(
        public ?string $first_name = null,
        public ?string $last_name = null, 
        public ?string $email = null,
        public ?string $phone = null,
        public ?string $password = null,
        public ?string $avatar_url = null,
        public ?string $avatar_id = null,
    ){}

    public function toArray(): array
    {
        return array_filter([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => $this->password,
            'avatar_url' => $this->avatar_url,
            'avatar_id' => $this->avatar_id,
        ], fn ($value) => $value !== null);
    }

    public static function fromRequest(UpdateAdminRequest $request): self
    {
        return new self(
            first_name: $request->validated('first_name'),
            last_name:  $request->validated('last_name'),
            email:      $request->validated('email'),
            phone:      $request->validated('phone'),
            password:   $request->validated('password'),
        );
    }
}
