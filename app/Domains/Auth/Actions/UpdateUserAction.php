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
        private ImageUploader $uploader,
        private SendVerificationEmailAction $sendVerificationEmail,
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
            $validatedData->avatarUrl = $uploadResult->url;
            $validatedData->avatarId = $uploadResult->fileId;
        }

         /*
        |--------------------------------------------------------------------------
        | Cambio de correo
        |--------------------------------------------------------------------------
        |
        | El email nunca se cambia directamente.
        | Se guarda como pending_email hasta que
        | el usuario confirme el nuevo correo.
        |
        */
        $data = $validatedData->toArray();


        $emailChanged = false;


        if (isset($data['email']) && $data['email'] !== $user->email) {

            $data['pending_email'] = $data['email'];

            unset($data['email']);

            $emailChanged = true;
        }


        $user->update($data);

        /*
        |--------------------------------------------------------------------------
        | Enviar verificación al nuevo correo
        |--------------------------------------------------------------------------
        */
        if ($emailChanged) {
            ($this->sendVerificationEmail)($user->refresh());
        }


        return $user->refresh();
    }
}
