<?php

namespace Database\Factories;

use App\domains\Auth\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Role>
 */
class RoleFactory extends Factory
{

    protected $model = Role::class;
    
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'description' => $this->faker->optional(0.7)->sentence()
        ];
    }
}
