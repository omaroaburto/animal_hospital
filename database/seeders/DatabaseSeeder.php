<?php

namespace Database\Seeders;

use App\domains\Auth\Models\Role;
use App\domains\Auth\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roles = ['admin', 'client'];

        // Creamos exactamente 2 registros mapeando los nombres del array
        Role::factory()
            ->count(count($roles))
            ->state(new Sequence(
                fn (Sequence $sequence) => ['name' => $roles[$sequence->index]],
            ))
            ->create();
        User::factory()
            ->count(10)
            ->create();

    }
}
