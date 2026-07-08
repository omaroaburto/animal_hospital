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

        //Si el usuario subió una imagen de avatar, la procesamos
        if ($avatarFile) {
            // Subimos la imagen a la carpeta 'avatars' usando el driver activo
            $uploadResult = $this->uploader->upload($avatarFile, 'avatars');

            // Asignamos dinámicamente los valores devueltos por el driver al DTO
            $validatedData->avatar_url = $uploadResult->url;
            $validatedData->avatar_id = $uploadResult->fileId;
        }

        // Se crea la cuenta de usuario
        $user = User::create([
            ...$validatedData->toArray(),
            'role_id'   => $role->id,
            'is_active' => true
        ]);

        return $user;
    }
}
