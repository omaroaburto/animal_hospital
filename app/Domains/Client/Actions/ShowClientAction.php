<?php

namespace App\Domains\Client\Actions;

use App\Domains\Client\Models\Client;

class ShowClientAction
{
    public function __invoke(Client $client): Client
    {
        return $client->load(['commune.region', 'user']);
    }
}
