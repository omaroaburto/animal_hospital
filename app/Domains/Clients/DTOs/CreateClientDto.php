<?php
namespace App\Domains\Clients\DTOs;

use App\Domains\Clients\Requests\StoreClientRequest;

class CreateClientDto{
    public function __construct(
        public string $documentType,
        public string $documentNumber,
        public ?string $notes = null,
        public string $secondaryPhone,
        public string $street,
        public string $number,
        public ?string $apartment = null,
        public string $communeId,
        public int $userId,
    ){}

    public function toArray()
    {
        return [
            'document_type'   => $this->documentType,
            'document_number' => $this->documentNumber,
            'notes'           => $this->notes,
            'secondary_phone' => $this->secondaryPhone,
            'street'          => $this->street,
            'number'          => $this->number,
            'apartment'       => $this->apartment,
            'commune_id'      => $this->communeId,
            'user_id'         => $this->userId,
        ];
    }
    public static function fromRequest(StoreClientRequest $request, int $userId): self
    {
        $validated = $request->validated();

        return new self(
            documentType:   $validated['document_type'],
            documentNumber: $validated['document_number'],
            secondaryPhone: $validated['secondary_phone'],
            street:         $validated['street'],
            number:         $validated['number'],
            apartment:      $validated['apartment'] ?? null,
            notes:          $validated['notes'] ?? null,
            communeId:      $validated['commune_id'],
            userId:         $userId,
        );
    }
}
