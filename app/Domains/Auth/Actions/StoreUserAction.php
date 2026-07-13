<?php
namespace App\Domains\Auth\Actions;

use App\Domains\Auth\Contracts\StoreUserActionInterface;
use App\Domains\Auth\DTOs\CreateUserDto;
use App\Domains\Auth\Exceptions\RoleNotFoundException;
use App\Domains\Auth\Models\Role;
use App\Domains\Auth\Models\User;
// Importamos la interfaz de tu servicio de imágenes
use App\Shared\Images\Contracts\ImageUploader;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class StoreUserAction implements StoreUserActionInterface
{
    //Inyectamos de forma automática el cargador de imágenes activo
    public function __construct(
        private ImageUploader $uploader
    ) {}

    public function __invoke(
        CreateUserDto $validatedData,
        string $roleName,
        ?UploadedFile $avatarFile = null
    ): User
    {
        // Valida que exista el rol
        if (!$role = Role::where('name', $roleName)->first()) {
            throw new RoleNotFoundException("El rol '{$roleName}' no está registrado.");
        }

        // Se crea la cuenta de usuario
        $user = User::create([
            ...$validatedData->toArray(),
            'role_id'   => $role->id,
            'is_active' => true
        ]);


        // Si el usuario subió una imagen de avatar, retrasamos su ejecución
        if ($avatarFile) {
            // Laravel guardará esta función y SOLO la ejecutará si la transacción general tiene éxito
            DB::afterCommit(function () use ($avatarFile, $user) {
                // 1. Subimos la imagen físicamente a la carpeta 'avatars'
                $uploadResult = $this->uploader->upload($avatarFile, 'avatars');

                // 2. Actualizamos el usuario ya persistido con los datos reales devueltos por el uploader
                $user->update([
                    'avatar_url' => $uploadResult->url,
                    'avatar_id'  => $uploadResult->fileId,
                ]);
            });
        }
        
        return $user;
    }
}

/**
 *
 *
        //Si el usuario subió una imagen de avatar, la procesamos
        if ($avatarFile) {
            // Subimos la imagen a la carpeta 'avatars' usando el driver activo
            $uploadResult = $this->uploader->upload($avatarFile, 'avatars');

            // Asignamos dinámicamente los valores devueltos por el driver al DTO
            $validatedData->avatarUrl = $uploadResult->url;
            $validatedData->avatarId = $uploadResult->fileId;
        }
 */
