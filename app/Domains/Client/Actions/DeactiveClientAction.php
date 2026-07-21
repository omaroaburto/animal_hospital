<?php

namespace App\Domains\Client\Actions;

use App\Domains\Auth\Actions\DeactivateUserAction;
use App\Domains\Client\Models\Client;

class DeactiveClientAction
{
    public function __construct(
        public DeactivateUserAction $deactiveUser,
    ) {}
    public function __invoke(Client $client): void
    {
        ($this->deactiveUser)($client->user);
    }
}
