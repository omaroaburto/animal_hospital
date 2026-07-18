<?php

namespace App\Domains\Pets\Actions;

use App\Domains\Pets\Models\Breed;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class DeleteBreedAction
{
    public function __invoke(array $validatedData, Breed $breed): array
    {
        $oldBreedName = $breed->name;

        if (! $breed->pets()->exists()) {
            $breed->delete();

            return [
                'reassigned' => false,
                'old_breed' => $oldBreedName,
                'new_breed' => null,
                'pets_updated' => 0,
            ];
        }

        return DB::transaction(function () use ($breed, $validatedData, $oldBreedName) {
            $replacementBreed = Breed::findOrFail($validatedData['replacement_breed_id']);

            if ($replacementBreed->is($breed)) {
                $this->throwSameBreedException();
            }

            if ($replacementBreed->species_id !== $breed->species_id) {
                $this->throwDifferentSpeciesException();
            }

            $petsUpdated = $breed->pets()->update([
                'breed_id' => $replacementBreed->id,
            ]);

            $breed->delete();

            return [
                'reassigned' => true,
                'old_breed' => $oldBreedName,
                'new_breed' => $replacementBreed->name,
                'pets_updated' => $petsUpdated,
            ];
        });
    }

    private function throwSameBreedException(): never
    {
        throw ValidationException::withMessages([
            'replacement_breed_id' => [
                'Debe seleccionar una raza diferente.',
            ],
        ]);
    }

    private function throwDifferentSpeciesException(): never
    {
        throw ValidationException::withMessages([
            'replacement_breed_id' => [
                'La raza de reemplazo debe pertenecer a la misma especie.',
            ],
        ]);
    }
}