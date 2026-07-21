<?php

namespace App\Domains\Client\Actions;

use App\Domains\Auth\Actions\RestoreUserAction;
use App\Domains\Client\Models\Client;

class RestoreClientAction
{
    public function __construct(
        public RestoreUserAction $restoreUser,
    ) {}
    public function __invoke(Client $client): void
    {
        ($this->restoreUser)($client->user);
    }
}
