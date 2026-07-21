<?php

namespace Database\Seeders;

use App\Domains\Pet\Models\Breed;
use App\Domains\Pet\Models\Species;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpeciesBreedSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$json = json_decode(
			file_get_contents(database_path('data/species_breeds.json')),
			true,
			flags: JSON_THROW_ON_ERROR,
		);

		DB::transaction(function () use ($json) {
			foreach ($json['species'] as $speciesData) {

				$species = Species::updateOrCreate(
					['name' => $speciesData['name']],
					['scientific_name' => $speciesData['scientific_name']],
				);

				foreach ($speciesData['breeds'] as $breedName) {
					Breed::firstOrCreate([
						'species_id' => $species->id,
						'name' => $breedName,
					]);
				}
			}
		});
	}
}
