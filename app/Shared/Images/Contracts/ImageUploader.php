<?php

namespace App\Shared\Images\Contracts;

use App\Shared\Images\Data\ImageUploadResult; // <-- Importamos el DTO
use Illuminate\Http\UploadedFile;

interface ImageUploader
{
    /**
     * Sube una imagen al servicio y retorna un objeto estructurado con sus metadatos.
     */
    public function upload(UploadedFile $file, string $folder = 'general'): ImageUploadResult;

    /**
     * Elimina una imagen del servicio externo usando su ID único en la plataforma.
     *  @param string $fileId Identificador único del archivo en el proveedor activo.
     */
    public function delete(string $fileId): void;
}
