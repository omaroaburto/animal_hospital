<?php

namespace App\Domains\Clients\Actions;

use App\Domains\Clients\DTOs\UpdateClientDto;
use App\Domains\Clients\Models\Client;

class UpdateClientAction
{
    public function __invoke(
        UpdateClientDto $validatedData,
        Client $client,
    )
    {
        $client->update($validatedData->toArray());
        return $client->refresh();
    }
}
