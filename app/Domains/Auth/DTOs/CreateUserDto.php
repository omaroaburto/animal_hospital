<?php
namespace App\Domains\Auth\DTOs;

use App\Domains\Auth\Requests\StoreAdminRequest;

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

    public static function fromRequest(StoreAdminRequest $request): self
    {
        return new self(
            first_name: $request->validated('first_name'),
            last_name:  $request->validated('last_name'),
            name:       $request->validated('name'),
            email:      $request->validated('email'),
            phone:      $request->validated('phone'),
            password:   $request->validated('password'),
        );
    }
}
