<?php

namespace App\Domains\Pet\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;

interface ClientPetRepositoryInterface
{
    /**
     * Obtiene las mascotas paginadas de un cliente específico con filtros aplicados.
     */
    public function __invoke(int $clientId, array $filters): LengthAwarePaginator;
}
