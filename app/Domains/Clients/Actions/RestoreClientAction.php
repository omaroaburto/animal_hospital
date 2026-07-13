<?php

namespace App\Domains\Clients\Actions;

use App\Domains\Auth\Actions\RestoreUserAction;
use App\Domains\Clients\Models\Client;

class RestoreClientAction
{
    public function __construct(
        public RestoreUserAction $restoreUser,
    ){}
    public function __invoke(Client $client): void
    {
        ($this->restoreUser)($client->user);
    }
}
