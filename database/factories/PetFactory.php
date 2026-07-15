<?php

namespace Database\Factories;

use App\Domains\Pets\Enums\Gender;
use App\Domains\Pets\Models\Breed;
use App\Domains\Pets\Models\Pet;
use Illuminate\Database\Eloquent\Factories\Factory;

class PetFactory extends Factory
{
    protected $model = Pet::class;

    private static ?array $breedIds = null;

    public function definition(): array
    {
        self::$breedIds ??= Breed::query()->pluck('id')->all();

        $hasMicrochip = fake()->boolean(20);

        $birthDate = fake()->optional(0.9)->dateTimeBetween('-20 years', 'today');

        $deathDate = $birthDate !== null && fake()->boolean(30)
            ? fake()->dateTimeBetween($birthDate, 'today')
            : null;
            
        $gender = fake()->randomElement([
                Gender::MALE,
                Gender::FEMALE,
            ]);

        return [
            'name' => fake()->name($gender),
            // Se asigna desde el seeder
            'client_id' => null,

            'breed_id' => fake()->randomElement(self::$breedIds),

            'gender' => $gender,

            'microchip' => $hasMicrochip,

            'microchip_number' => $hasMicrochip
                ? fake()->numerify('###############')
                : null,

            'birth_date' => $birthDate,

            'death_date' => $deathDate,

            'color' => fake()->randomElement([
                'Negro',
                'Blanco',
                'Gris',
                'Café',
                'Dorado',
                'Canela',
                'Crema',
                'Atigrado',
                'Tricolor',
                'Bicolor',
                'Manchado',
            ]),

            'sterilized' => fake()->boolean(40),

            'photo_url' => null,

            'photo_id' => null,

            'notes' => null,
        ];
    }
}
