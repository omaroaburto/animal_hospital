<?php

namespace App\Domains\Auth\DTOs;

class UpdateUserDto
{
    public function __construct(
        public ?string $firstName = null,
        public ?string $lastName = null,
        public ?string $email = null,
        public ?string $phone = null,
        public ?string $password = null,
        public ?string $avatarUrl = null,
        public ?string $avatarId = null,
    ) {}


    public static function fromArray(array $data): self
    {
        return new self(
            firstName: $data['first_name'] ?? null,
            lastName: $data['last_name'] ?? null,
            email: $data['email'] ?? null,
            phone: $data['phone'] ?? null,
            password: $data['password'] ?? null,
            avatarUrl: $data['avatar_url'] ?? null,
            avatarId: $data['avatar_id'] ?? null,
        );
    }


    public function toArray(): array
    {
        return array_filter([
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => $this->password,
            'avatar_url' => $this->avatarUrl,
            'avatar_id' => $this->avatarId,
        ], fn ($value) => $value !== null);
    }
}
