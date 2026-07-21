<?php

namespace App\Domains\Client\Actions;

use App\Domains\Client\DTOs\UpdateClientDto;
use App\Domains\Client\Models\Client;

class UpdateClientAction
{
    public function __invoke(
        UpdateClientDto $validatedData,
        Client $client,
    ) {
        $client->update($validatedData->toArray());
        return $client->refresh();
    }
}
