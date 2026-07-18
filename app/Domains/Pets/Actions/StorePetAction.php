<?php

namespace App\Domains\Pets\Actions;

use App\Domains\Pets\Models\Pet;
use App\Shared\Images\Contracts\ImageUploader;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class StorePetAction
{
    public function __construct(
        private ImageUploader $uploader
    ) {}

    public function __invoke(array $validatedData, ?UploadedFile $photoFile = null): Pet
    {
        return DB::transaction(function () use ($validatedData, $photoFile) {
            // 1. Creamos el registro en la BD (Genera el ID que Drive, Local o Cloudinary podrían necesitar)
            $pet = Pet::create($validatedData);

            // 2. Si hay un archivo, delegamos al servicio agnóstico del Shared
            if ($photoFile) {
                // Tu ImageUploader decidirá internamente si usa Cloudflare, Cloudinary, Drive o Local
                $uploadResult = $this->uploader->upload($photoFile, 'pets');

                // 3. Guardamos los identificadores únicos que nos retorna el driver activo
                $pet->update([
                    'photo_url' => $uploadResult->url,
                    'photo_id'  => $uploadResult->fileId, // Crucial para saber qué borrar en el driver si se elimina la mascota
                ]);
            }

            return $pet;
        });
    }
}
