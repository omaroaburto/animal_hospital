<?php

namespace App\Domains\Auth\Actions;

use App\Domains\Auth\Contracts\UpdateUserActionInterface;
use App\Domains\Auth\DTOs\UpdateUserDto;
use App\Domains\Auth\Models\User;
//Inyectamos el contrato de las imágenes
use App\Shared\Images\Contracts\ImageUploader;
use Illuminate\Http\UploadedFile;

class UpdateUserAction implements UpdateUserActionInterface
{
    // El constructor recibe el uploader activo dinámicamente desde el ServiceProvider
    public function __construct(
        private ImageUploader $uploader
    ) {}

    public function __invoke(
        UpdateUserDto $validatedData,
        User $user,
        ?UploadedFile $avatarFile = null
    ): User
    {
        //Si el usuario envía una nueva foto de avatar
        if ($avatarFile) {

            // 🔥 CONTROL DE BASURA: Si el usuario ya tenía una foto previa, la borramos del storage activo
            if ($user->avatar_id) {
                $this->uploader->delete($user->avatar_id);
            }

            // 3. Subimos el nuevo archivo al directorio 'avatars'
            $uploadResult = $this->uploader->upload($avatarFile, 'avatars');

            // 4. Mutamos el DTO con los datos de la nueva imagen
            $validatedData->avatar_url = $uploadResult->url;
            $validatedData->avatar_id = $uploadResult->fileId;
        }

        // 5. Ejecutamos la actualización masiva filtrada (solo lo que no sea null)
        $user->update($validatedData->toArray());

        return $user->refresh();
    }
}
