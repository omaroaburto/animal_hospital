<?php

namespace Database\Factories;

use App\domains\Auth\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        $avatar = trim("{$this->faker->lastName()}.jpg");
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => 'papas1Conqueso12',
            'phone' => fake()->numerify('9########'),
            'avatar_url' => 'https://loremflickr.com/all/?lock='.$avatar,
            'avatar_id' => $avatar,
            'is_active' => fake()->boolean(90),
            'last_login_at' => fake()->optional(0.7, null)->dateTimeBetween('-14 days', 'now'),
            'role_id' => 1, //por defecto crea un super administrador
        ];
    }
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role_id' => 2 //administrador
        ]);
    }

    public function client(): static
    {
        return $this->state(fn (array $attributes) => [
            'role_id' => 3
        ]);
    }
}
