<?php

namespace App\Shared\Images\Data;

// (DTO) para la subida de imágenes en cualquier proveedor de almacenamiento.

class ImageUploadResult
{
    public function __construct(
        public readonly string $url,      // URL pública para el frontend (ej: https://res.cloudinary.com/...)
        public readonly string $fileId,   // ID único en el proveedor para poder borrarlo/editarlo (ej: public_id, drive_id, s3_key)
        public readonly string $driver,   // El driver que procesó la subida (ej: 'cloudinary', 'local', 'google_drive')
    ) {}
}
