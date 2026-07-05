<?php

namespace App\Domains\Auth\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RoleNotFoundException extends Exception
{
    /**
     * Reportar la excepción (Registrar logs, métricas, etc.).
     */
    public function report(): void
    {
        // Log::error('Excepción en el dominio Auth: ' . $this->getMessage());
    }

    /**
     * Renderizar la excepción en una respuesta HTTP/JSON.
     */
    public function render(Request $request): JsonResponse
    {
        $message = $this->getMessage() ?: 'Error interno en el dominio Auth.';

        return response()->json([
            'status'  => 'error',
            'code'    => 'ROLE_NOT_FOUND',
            'message' => $message,
        ], 404);
    }
}