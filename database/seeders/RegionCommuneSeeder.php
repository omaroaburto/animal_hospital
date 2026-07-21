<?php

namespace Database\Seeders;

use App\Domains\Client\Models\Commune;
use App\Domains\Client\Models\Region;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionCommuneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = json_decode(
            file_get_contents(database_path('data/regions_communes.json')),
            true
        );

        DB::transaction(function () use ($json) {

            foreach ($json['regions'] as $regionData) {

                $region = Region::firstOrCreate([
                    'name' => $regionData['name'],
                ]);

                foreach ($regionData['communes'] as $communeData) {

                    Commune::firstOrCreate([
                        'name' => $communeData['name'],
                        'region_id' => $region->id,
                    ]);
                }
            }
        });
    }
}
