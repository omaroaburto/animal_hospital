<?php

namespace App\Domains\Pets\Actions;

use App\Domains\Pets\Models\Species;
use Illuminate\Validation\ValidationException;

class DestroySpeciesAction
{
    public function __invoke(Species $species): void
    {
        $breedsCount = $species->breeds()->count();
        if($breedsCount > 0){
            // Lanzamos una excepción de validación amigable para el frontend
            throw ValidationException::withMessages([
                'species' => [
                    "No se puede eliminar la especie '{$species->name}' porque tiene {$breedsCount} razas asociadas. Debes eliminar o reasignar las razas primero."
                ]
            ]);
        }

        $species->delete();
    }
}
