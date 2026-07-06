<?php

namespace App\Shared\Images\Services;

use App\Shared\Images\Contracts\ImageUploader;
use Illuminate\Http\UploadedFile;
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;

/**
 * Implementación técnica para almacenar imágenes en la nube de Cloudinary
 * utilizando el SDK nativo de PHP.
 */
class CloudinaryUploader implements ImageUploader
{
    public function __construct()
    {
        // Inicializa el SDK leyendo directamente la variable CLOUDINARY_URL del archivo .env
        Configuration::instance();
    }

    public function upload(UploadedFile $file, string $folder = 'general'): string
    {
        $uploadApi = new UploadApi();

        // Sube el archivo temporal aplicando optimizaciones automáticas de peso y formato
        $response = $uploadApi->upload($file->getRealPath(), [
            'folder'        => "animal_hospital_api/{$folder}", // Carpeta raíz virtual en Cloudinary
            'quality'       => 'auto',                     // Optimiza el tamaño del archivo sin perder calidad visual
            'fetch_format'  => 'auto'                      // Sirve el formato más ligero según el navegador (WebP, AVIF, etc.)
        ]);

        return $response['secure_url'];
    }

    public function delete(string $url): void
    {
        $publicId = $this->extractPublicId($url);

        if ($publicId) {
            $uploadApi = new UploadApi();
            $uploadApi->destroy($publicId);
        }
    }

    /**
     * Extrae el identificador único (Public ID) que Cloudinary requiere para borrar un recurso.
     */
    private function extractPublicId(string $url): ?string
    {
        // Captura la ruta interna del asset omitiendo el dominio y la versión de la URL (/upload/vXXXX/)
        if (preg_match('/\/upload\/(?:v\d+\/)?(.+)\.[a-z]{3,4}$/i', $url, $matches)) {
            return $matches[1];
        }

        return null;
    }
}
