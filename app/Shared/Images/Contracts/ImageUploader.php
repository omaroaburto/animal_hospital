<?php

namespace App\Shared\Images\Contracts;

use Illuminate\Http\UploadedFile;

/**
 * Interfaz/Contrato agnóstico para la gestión de imágenes.
 * Define las operaciones permitidas por los dominios de la aplicación.
 */
interface ImageUploader
{
    /**
     * Sube una imagen al servicio de almacenamiento activo.
     *
     * @param UploadedFile $file Archivo binario enviado a través de una petición HTTP.
     * @param string $folder Subcarpeta organizativa asociada al dominio (ej: 'pets', 'avatars').
     * @return string URL absoluta y pública de la imagen procesada.
     */
    public function upload(UploadedFile $file, string $folder = 'general'): string;

    /**
     * Elimina una imagen del almacenamiento utilizando su URL pública.
     *
     * @param string $url URL completa del recurso guardado previamente en la base de datos.
     * @return void
     */
    public function delete(string $url): void;
}
