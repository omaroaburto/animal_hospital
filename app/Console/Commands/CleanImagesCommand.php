<?php
//php artisan storage:clean-all-drivers
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CleanImagesCommand extends Command
{
    /**
     * Nombre del comando en consola
     */
    protected $signature = 'storage:clean-all-drivers';

    protected $description = 'Borra las imágenes de los drivers, refresca las tablas y ejecuta los seeders';

    public function handle()
    {
        // 1. Menú interactivo para seleccionar el almacenamiento
        $opcion = $this->choice(
            '¿Qué almacenamiento deseas vaciar por completo antes de resetear la base de datos?',
            [
                '1' => 'Todos los drivers (Limpieza Total de la App)',
                '2' => 'Solo Local (Disco público)',
                '3' => 'Solo Google Drive',
                '4' => 'Solo Cloudflare R2 / S3',
                '5' => 'Solo Cloudinary'
            ],
            '1'
        );

        // Mapeamos la opción a los discos configurados
        $discosAProcesar = [];
        switch ($opcion) {
            case 'Todos los drivers (Limpieza Total de la App)':
                $discosAProcesar = ['public', 'google', 's3', 'cloudinary'];
                break;
            case 'Solo Local (Disco público)':
                $discosAProcesar = ['public'];
                break;
            case 'Solo Google Drive':
                $discosAProcesar = ['google'];
                break;
            case 'Solo Cloudflare R2 / S3':
                $discosAProcesar = ['s3'];
                break;
            case 'Solo Cloudinary':
                $discosAProcesar = ['cloudinary'];
                break;
        }

        // 2. Advertencia definitiva
        if (!$this->confirm("⚠️ ¡ATENCIÓN! Se eliminarán los archivos físicos de [{$opcion}] y se BORRARÁ TODA LA BASE DE DATOS para volver a sembrar los seeders. ¿Deseas continuar?")) {
            $this->info('Operación cancelada.');
            return Command::SUCCESS;
        }

        // --- PASO 1: VACIADO DE ARCHIVOS EN LOS DRIVERS ---
        $this->info("\n1. Iniciando vaciado de directorios de imágenes...");

        // Define aquí todas las carpetas de imágenes que use tu hospital veterinario
        $carpetasDeImagenes = ['avatars', 'pets', 'medical_images'];

        foreach ($discosAProcesar as $disco) {
            try {
                $this->comment("   Limpiando disco: [{$disco}]...");

                foreach ($carpetasDeImagenes as $carpeta) {
                    if (Storage::disk($disco)->exists($carpeta)) {
                        $count = count(Storage::disk($disco)->allFiles($carpeta));

                        // Elimina la carpeta y todo su contenido
                        Storage::disk($disco)->deleteDirectory($carpeta);

                        // La vuelve a crear vacía para mantener la estructura lista
                        Storage::disk($disco)->makeDirectory($carpeta);

                        $this->line("      [-] Carpeta '{$carpeta}' vaciada. ({$count} archivos eliminados)");
                    } else {
                        Storage::disk($disco)->makeDirectory($carpeta);
                    }
                }
            } catch (\Exception $e) {
                $this->error("   ⚠️ No se pudo vaciar por completo el driver [{$disco}]: " . $e->getMessage());
            }
        }

        // --- PASO 2: REFRESCAR TABLAS Y EJECUTAR SEEDERS ---
        $this->info("\n2. Reseteando la base de datos...");

        // Ejecuta php artisan migrate:fresh
        $this->comment("   Corriendo 'migrate:fresh'...");
        $this->call('migrate:fresh');

        // Ejecuta php artisan db:seed
        $this->info("\n3. Sembrando datos de prueba...");
        $this->comment("   Corriendo 'db:seed'...");
        $this->call('db:seed');

        $this->info("\n🚀 ¡Todo el entorno ha sido restaurado con éxito! Archivos borrados, tablas limpias y seeders ejecutados.");
        return Command::SUCCESS;
    }
}
