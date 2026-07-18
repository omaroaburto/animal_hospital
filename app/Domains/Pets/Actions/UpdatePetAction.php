<?php

namespace App\Domains\Pets\Actions;

use App\Domains\Pets\Models\Pet;
use App\Shared\Images\Contracts\ImageUploader;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Throwable;

class UpdatePetAction
{
    public function __construct(
        private ImageUploader $uploader
    ) {}

    public function __invoke(
        array $validatedData,
        Pet $pet,
        ?UploadedFile $photoFile = null,
    ): Pet {
        $oldPhotoId = $pet->photo_id;
        $newPhotoId = null;

        try {
            if ($photoFile !== null) {
                $upload = $this->uploader->upload($photoFile, 'pets');

                $newPhotoId = $upload->fileId;

                $validatedData['photo_url'] = $upload->url;
                $validatedData['photo_id']   = $upload->fileId;
            }

            DB::transaction(function () use ($validatedData, $pet, $photoFile, $oldPhotoId) {
                $pet->update($validatedData);

                if ($photoFile !== null && $oldPhotoId !== null) {
                    DB::afterCommit(fn () => $this->uploader->delete($oldPhotoId));
                }
            });

            return $pet->refresh();

        } catch (Throwable $e) {
            // Si la base de datos falló, limpiamos el storage externo inmediatamente
            // eliminando la foto nueva que quedó huérfana. ¡Brillante!
            if ($newPhotoId !== null) {
                $this->uploader->delete($newPhotoId);
            }

            throw $e;
        }
    }
}
