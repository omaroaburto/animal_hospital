<?php

namespace App\Shared\Images\Services;

use App\Shared\Images\Contracts\ImageUploader;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Implementación técnica para almacenar imágenes localmente en el disco duro del servidor
 * utilizando el sistema de archivos nativo de Laravel.
 */
class LocalUploader implements ImageUploader
{
    private const DISK_NAME = 'public';

    public function upload(UploadedFile $file, string $folder = 'general'): string
    {
        // Guarda el archivo físico (Parámetros corregidos: 1° carpeta de destino, 2° archivo binario)
        $path = Storage::disk(self::DISK_NAME)->putFile($folder, $file);

        // Retorna la URL pública construida usando la variable APP_URL del .env
        return Storage::disk(self::DISK_NAME)->url($path);
    }

    public function delete(string $url): void
    {
        $path = $this->extractPathFromUrl($url);

        if ($path && Storage::disk(self::DISK_NAME)->exists($path)) {
            Storage::disk(self::DISK_NAME)->delete($path);
        }
    }

    /**
     * Extrae la ruta interna del archivo eliminando el dominio y el prefijo público.
     * Ejemplo: de "http://api.com/storage/pets/foto.png" extrae "pets/foto.png"
     */
    private function extractPathFromUrl(string $url): ?string
    {
        if (preg_match('/\/storage\/(.+)$/i', $url, $matches)) {
            return $matches[1];
        }

        return null;
    }
}
