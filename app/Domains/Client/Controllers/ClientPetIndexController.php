<?php

namespace App\Domains\Client\Controllers;

use App\Domains\Client\Models\Client;
use App\Domains\Pet\Contracts\ClientPetRepositoryInterface;
use App\Domains\Pet\Resources\PetCollection;
use App\Http\Requests\BaseIndexFilterRequest as IndexRequest;
use Illuminate\Support\Facades\Gate;

class ClientPetIndexController
{
    public function clientPetIndex(
        Client $client,
        IndexRequest $request,
        ClientPetRepositoryInterface $getPetsByClient
    ): PetCollection {
        Gate::authorize('view', $client);
        $pets = $getPetsByClient($client->id, $request->validated())->getCollection();
        return new PetCollection($pets);
    }
}
