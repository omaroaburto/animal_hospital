<?php

namespace App\Shared\Images\Services;

use App\Shared\Images\Contracts\ImageUploader;
use App\Shared\Images\Data\ImageUploadResult;
use Illuminate\Http\UploadedFile;
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;

class CloudinaryUploader implements ImageUploader
{
    public function __construct()
    {
        Configuration::instance();
    }

    public function upload(UploadedFile $file, string $folder = 'general'): ImageUploadResult
    {
        $uploadApi = new UploadApi();

        $response = $uploadApi->upload($file->getRealPath(), [
            'folder'        => "tu_proyecto_api/{$folder}",
            'quality'       => 'auto',
            'fetch_format'  => 'auto'
        ]);

        // Retornamos el DTO mapeando los datos nativos de Cloudinary
        return new ImageUploadResult(
            url: $response['secure_url'],
            fileId: $response['public_id'], // Guardamos el public_id nativo sin hackear la URL
            driver: 'cloudinary'
        );
    }

    public function delete(string $fileId): void
    {
        $uploadApi = new UploadApi();
        $uploadApi->destroy($fileId);
    }
}
