<?php
namespace App\Domains\Auth\DTOs;

use Illuminate\Foundation\Http\FormRequest;
class CreateUserDto{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $email,
        public string $phone,
        public string $password,
        public ?string $avatarUrl = null,
        public ?string $avatarId  = null,
    ){}

    public function toArray(): array
    {
        return [
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => $this->password,
            'avatar_url' => $this->avatarUrl,
            'avatar_id' => $this->avatarId,
        ];
    }

    public static function fromRequest(FormRequest $request): self
    {
        return new self(
            firstName:  $request->validated('first_name'),
            lastName:   $request->validated('last_name'),
            email:      $request->validated('email'),
            phone:      $request->validated('phone'),
            password:   $request->validated('password'),
        );
    }
}
