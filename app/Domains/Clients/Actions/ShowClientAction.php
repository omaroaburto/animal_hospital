<?php

namespace App\Domains\Clients\Actions;

use App\Domains\Clients\Models\Client;

class ShowClientAction
{
    public function __invoke(Client $client): Client
    {
        return $client->load(['commune.region', 'user']);
    }
}
