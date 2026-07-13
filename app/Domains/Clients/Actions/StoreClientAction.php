<?php

namespace App\Domains\Clients\Actions;

use App\Domains\Clients\DTOs\CreateClientDto;
use App\Domains\Clients\Models\Client;

class StoreClientAction
{
    public function __invoke(CreateClientDto $validatedData): Client
    {
        $client = Client::Create($validatedData->toArray());
        return $client;
    }
}
