<?php

namespace App\Domains\Clients\DTOs;

use Illuminate\Http\Request;

class UpdateClientDto
{
    public function __construct(
        public ?string $documentType = null,
        public ?string $documentNumber = null,
        public ?string $notes = null,
        public ?string $secondaryPhone = null,
        public ?string $street = null,
        public ?string $number = null,
        public ?string $apartment = null,
        public ?string $communeId = null,
    ){}

    /**
     * Convierte el DTO a array ignorando las propiedades que no fueron seteadas (para PATCH).
     */
    public function toArray(): array
    {
        return array_filter([
            'document_type'   => $this->documentType,
            'document_number' => $this->documentNumber,
            'notes'           => $this->notes,
            'secondary_phone' => $this->secondaryPhone,
            'street'          => $this->street,
            'number'          => $this->number,
            'apartment'       => $this->apartment,
            'commune_id'      => $this->communeId,
        ], function ($value) {
            // Esto permite que el valor se mantenga si es 0 o un string vacío,
            // pero elimina del array lo que sea estrictamente NULL (no enviado).
            return $value !== null;
        });
    }

    /**
     * Mapea dinámicamente desde la Request validada (sirve para PUT, PATCH o STORE)
     */
    public static function fromRequest(Request $request, ?int $userId = null): self
    {
        // Usamos $request->validated() si estás usando FormRequests específicos,
        // o $request->all() si lo manejas directo. Cambia a $request->validated() si corresponde.
        $data = method_exists($request, 'validated') ? $request->validated() : $request->all();

        return new self(
            documentType:   $data['document_type'] ?? null,
            documentNumber: $data['document_number'] ?? null,
            secondaryPhone: $data['secondary_phone'] ?? null,
            street:         $data['street'] ?? null,
            number:         $data['number'] ?? null,
            apartment:      $data['apartment'] ?? null,
            notes:          $data['notes'] ?? null,
            communeId:      $data['commune_id'] ?? null, 
        );
    }
}
