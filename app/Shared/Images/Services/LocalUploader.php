<?php

namespace App\Shared\Images\Services;

use App\Shared\Images\Contracts\ImageUploader;
use App\Shared\Images\Data\ImageUploadResult;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Class LocalUploader
 * * Implementación del servicio de carga de imágenes para el almacenamiento local.
 * Utiliza el sistema de archivos (Filesystem) nativo de Laravel para persistir
 * los archivos directamente en el disco duro del servidor web.
 * * @package App\Shared\Images\Services
 */
class LocalUploader implements ImageUploader
{
    /**
     * Nombre del disco de almacenamiento definido en config/filesystems.php.
     * Se utiliza 'public' para que los archivos guardados tengan acceso web directo.
     */
    private const DISK_NAME = 'public';

    /**
     * Sube y persiste una imagen en el almacenamiento local del servidor.
     * * El método guarda físicamente el archivo binario generando un nombre único (hash)
     * de forma automática para prevenir colisiones o sobreescritura de archivos.
     *
     * @param UploadedFile $file El archivo binario recibido desde la petición HTTP ($request).
     * @param string $folder Nombre de la subcarpeta organizativa del dominio (ej: 'pets', 'avatars').
     * @return ImageUploadResult Objeto de datos estandarizado con la URL pública y metadatos del archivo.
     */
    public function upload(UploadedFile $file, string $folder = 'general'): ImageUploadResult
    {
        // Almacena el archivo en el disco configurado bajo la carpeta indicada.
        // Retorna la ruta relativa interna (ej: "pets/f83j2da9.png").
        $path = Storage::disk(self::DISK_NAME)->putFile($folder, $file);

        // Retorna la estructura de datos unificada para la aplicación.
        return new ImageUploadResult(
            // Construye la URL web absoluta (ej: "http://localhost:8000/storage/pets/f83j2da9.png")
            url: Storage::disk(self::DISK_NAME)->url($path),

            // La ruta relativa actúa como el identificador único indispensable para el borrado futuro
            fileId: $path,

            // Declara explícitamente el proveedor técnico utilizado
            driver: 'local'
        );
    }

    /**
     * Elimina físicamente un archivo del almacenamiento local del servidor.
     * Gracias al uso del DTO, este método recibe la ruta directa del archivo en el disco,
     * evitando la necesidad de procesar o parsear URLs públicas mediante expresiones regulares.
     *
     * @param string $fileId Identificador único del archivo (para este driver, corresponde a la ruta relativa).
     * @return void
     */
    public function delete(string $fileId): void
    {
        // Verifica de manera segura que el archivo exista en el disco antes de proceder a su remoción
        if (Storage::disk(self::DISK_NAME)->exists($fileId)) {
            Storage::disk(self::DISK_NAME)->delete($fileId);
        }
    }
}
