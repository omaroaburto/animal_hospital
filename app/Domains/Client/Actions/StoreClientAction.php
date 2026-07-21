<?php

namespace App\Domains\Client\Actions;

use App\Domains\Client\DTOs\CreateClientDto;
use App\Domains\Client\Models\Client;

class StoreClientAction
{
    public function __invoke(CreateClientDto $validatedData): Client
    {
        $client = Client::Create($validatedData->toArray());
        return $client;
    }
}
