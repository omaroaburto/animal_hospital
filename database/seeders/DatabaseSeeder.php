<?php

namespace Database\Seeders;

use App\domains\Auth\Models\Role;
use App\domains\Auth\Models\User;
use App\Domains\Clients\Models\Client;
use App\Domains\Pets\Models\Pet;
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
        $roles = ['superadmin','admin', 'client'];

        Role::factory()
            ->count(count($roles))
            ->state(new Sequence(
                fn (Sequence $sequence) => ['name' => $roles[$sequence->index]],
            ))
            ->create();

        //crea 1 superadmin
        User::factory()
            ->count(1)
            ->create();

        //crea 2 admin
        User::factory()
            ->count(2)
            ->admin()
            ->create();

        //se cargan los datos de las regiones y comunas
        $this->call([
            RegionCommuneSeeder::class,
            SpeciesBreedSeeder::class
        ]);

        Client::factory()
            ->count(3)
            ->create()
            ->each(function (Client $client) {
                Pet::factory()
                    ->count(5)
                    ->create([
                        'client_id' => $client->id,
                    ]);
            });


    }
}
