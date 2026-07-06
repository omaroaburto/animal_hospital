<?php
namespace App\Domains\Auth\DTOs;

class CreateUserDto{
    public function __construct(
        public string $first_name,
        public string $last_name,
        public string $name,
        public string $email,
        public string $phone,
        public string $password,
        public ?string $avatar_url = null,
        public ?string $avatar_id  = null,
    ){}

    public function toArray(): array
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => $this->password,
            'avatar_url' => $this->avatar_url,
            'avatar_id' => $this->avatar_id,
        ];
    }
}
