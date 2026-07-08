<?php

namespace App\Shared\Images\Services;

use App\Shared\Images\Contracts\ImageUploader;
use App\Shared\Images\Data\ImageUploadResult;
use Illuminate\Http\UploadedFile;
use Aws\S3\S3Client;

/**
 * Servicio encargado de gestionar el almacenamiento de imágenes en Cloudflare R2
 * utilizando el SDK de AWS S3 gracias a la compatibilidad nativa de R2.
 */
class CloudflareUploader implements ImageUploader
{
    private S3Client $s3Client;
    private string $bucket;
    private string $publicUrl;

    public function __construct()
    {
        // Corregido: Se añade el prefijo 'filesystems.' para leer correctamente el arreglo desde config/filesystems.php
        $this->s3Client = new S3Client([
            'version'                 => 'latest',
            'region'                  => 'auto', // Cloudflare R2 no usa regiones rígidas, 'auto' es el estándar
            'endpoint'                => config('filesystems.cloudflare_r2.endpoint'),
            'use_path_style_endpoint' => true,
            'credentials' => [
                'key'    => config('filesystems.cloudflare_r2.key'),
                'secret' => config('filesystems.cloudflare_r2.secret'),
            ],
        ]);

        $this->bucket = config('filesystems.cloudflare_r2.bucket');
        $this->publicUrl = rtrim(config('filesystems.cloudflare_r2.url'), '/');
    }

    /**
     * Sube un archivo a Cloudflare R2 y retorna el DTO estandarizado.
     */
    public function upload(UploadedFile $file, string $folder = 'general'): ImageUploadResult
    {
        // Generamos un nombre único para evitar colisiones en el objeto Storage
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();

        // El 'fileId' para Cloudflare/S3 es la ruta completa de la llave (Key)
        $fileKey = "{$folder}/{$fileName}";

        // Subimos el archivo a Cloudflare R2
        $this->s3Client->putObject([
            'Bucket'      => $this->bucket,
            'Key'         => $fileKey,
            'SourceFile'  => $file->getRealPath(),
            'ContentType' => $file->getMimeType(),
        ]);

        // Construimos la URL pública final concatenando la URL base del CDN y la llave del archivo
        $absoluteUrl = "{$this->publicUrl}/{$fileKey}";

        return new ImageUploadResult(
            url: $absoluteUrl,
            fileId: $fileKey, // Guardamos la llave exacta para poder borrarlo después
            driver: 'cloudflare'
        );
    }

    /**
     * Elimina un archivo de Cloudflare R2 usando su Key única.
     */
    public function delete(string $fileId): void
    {
        try {
            $this->s3Client->deleteObject([
                'Bucket' => $this->bucket,
                'Key'    => $fileId,
            ]);
        } catch (\Exception $e) {
            logger()->error("No se pudo borrar el archivo de Cloudflare R2 [{$fileId}]: " . $e->getMessage());
        }
    }
}
