<?php

namespace App\Providers;

use App\Domains\Auth\Actions\StoreUserAction;
use App\Domains\Auth\Actions\UpdateUserAction;
use App\Domains\Auth\Contracts\StoreUserActionInterface;
use App\Domains\Auth\Contracts\UpdateUserActionInterface;
use App\Domains\Auth\Models\Role;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Policies\AdminPolicy;
use App\Domains\Auth\Policies\RolePolicy;
use App\Domains\Client\Models\Client;
use App\Domains\Client\Policies\ClientPolicy;
use App\Domains\Pet\Actions\GetPetsByClientAction;
use App\Domains\Pet\Contracts\ClientPetRepositoryInterface;
use App\Domains\Pet\Models\Breed;
use App\Domains\Pet\Models\Pet;
use App\Domains\Pet\Models\Species;
use App\Domains\Pet\Policies\BreedPolicy;
use App\Domains\Pet\Policies\PetPolicy;
use App\Domains\Pet\Policies\SpeciesPolicy;
use App\Shared\Images\Contracts\ImageUploader;
use App\Shared\Images\Services\CloudflareUploader;
use App\Shared\Images\Services\CloudinaryUploader;
use App\Shared\Images\Services\GoogleDriveUploader;
use App\Shared\Images\Services\LocalUploader;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Enlace para la acción de guardar usuario que requería RegisterClientAction
        $this->app->bind(StoreUserActionInterface::class, StoreUserAction::class);
        $this->app->bind(UpdateUserActionInterface::class, UpdateUserAction::class);
        $this->app->bind(ClientPetRepositoryInterface::class, GetPetsByClientAction::class);
        // Enlace polimórfico del gestor de imágenes
        $this->app->bind(ImageUploader::class, function ($app) {

            $driver = config('filesystems.image_driver', 'cloudinary');

            return match ($driver) {
                'cloudinary' => new CloudinaryUploader(),
                'local'      => new LocalUploader(),
                'cloudflare'   => new CloudflareUploader(),
                'google_drive' => new GoogleDriveUploader(),
                default => throw new \RuntimeException("El driver de imágenes [{$driver}] no está soportado o configurado."),
            };
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(User::class, AdminPolicy::class);
        Gate::policy(Role::class, RolePolicy::class);
        Gate::policy(Client::class, ClientPolicy::class);
        Gate::policy(Pet::class, PetPolicy::class);
        Gate::policy(Breed::class, BreedPolicy::class);
        Gate::policy(Species::class, SpeciesPolicy::class);
    }
}
