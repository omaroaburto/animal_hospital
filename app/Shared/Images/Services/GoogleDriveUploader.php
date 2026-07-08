<?php

namespace App\Shared\Images\Services;

use App\Shared\Images\Contracts\ImageUploader;
use App\Shared\Images\Data\ImageUploadResult;
use Illuminate\Http\UploadedFile;
use Google\Client;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;
use Google\Service\Drive\Permission;

/**
 * Servicio encargado de gestionar el almacenamiento de imágenes en Google Drive
 * utilizando el SDK oficial de Google.
 */
class GoogleDriveUploader implements ImageUploader
{
    private Drive $driveService;
    private string $rootFolderId;

    public function __construct()
    {
        // 1. Inicializamos el cliente oficial de Google
        $client = new Client();
        $client->setAuthConfig(config('filesystems.google_drive.credentials'));
        $client->addScope(Drive::DRIVE);

        // 2. Instanciamos el servicio específico de Drive y leemos la carpeta destino
        $this->driveService = new Drive($client);
        $this->rootFolderId = config('filesystems.google_drive.folder_id');
    }

    /**
     * Sube un archivo a Google Drive, lo hace público y retorna el DTO estandarizado.
     */
    public function upload(UploadedFile $file, string $folder = 'general'): ImageUploadResult
    {
        // Nota: Google Drive maneja carpetas mediante IDs únicos, no por strings de ruta.
        // Para simplificar, los archivos se subirán a la carpeta raíz compartida,
        // usando el prefijo de la subcarpeta en el nombre del archivo.
        $fileName = "{$folder}_" . uniqid() . '.' . $file->getClientOriginalExtension();

        // 1. Configurar la metadata del archivo
        $fileMetadata = new DriveFile([
            'name' => $fileName,
            'parents' => [$this->rootFolderId]
        ]);

        // 2. Subir el archivo físico
        $driveFile = $this->driveService->files->create($fileMetadata, [
            'data' => file_get_contents($file->getRealPath()),
            'mimeType' => $file->getMimeType(),
            'uploadType' => 'multipart',
            'fields' => 'id'
        ]);

        $fileId = $driveFile->id;

        // 3. CAMBIO CRÍTICO: Hacer el archivo público para que cualquiera con el enlace pueda verlo
        $this->makeFilePublic($fileId);

        // 4. Construir la URL de visualización web directa
        $publicUrl = "https://lh3.googleusercontent.com/d/{$fileId}";

        return new ImageUploadResult(
            url: $publicUrl,
            fileId: $fileId, // El fileId real que tú necesitas para borrarlo
            driver: 'google_drive'
        );
    }

    /**
     * Elimina un archivo de Google Drive usando su identificador único.
     */
    public function delete(string $fileId): void
    {
        try {
            $this->driveService->files->delete($fileId);
        } catch (\Exception $e) {
            // Silenciar o reportar en logs si el archivo ya no existía en Drive
            logger()->error("No se pudo borrar el archivo de Drive con ID {$fileId}: " . $e->getMessage());
        }
    }

    /**
     * Modifica los permisos del archivo en Drive para habilitar el acceso de lectura público.
     */
    private function makeFilePublic(string $fileId): void
    {
        $publicPermission = new Permission([
            'type' => 'anyone',
            'role' => 'reader',
        ]);

        $this->driveService->permissions->create($fileId, $publicPermission);
    }
}
