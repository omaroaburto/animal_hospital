<?php

namespace App\Domains\Clients\Controllers;

use App\Domains\Clients\Models\Client;
use App\Domains\Pets\Contracts\ClientPetRepositoryInterface;
use App\Domains\Pets\Resources\PetCollection;
use App\Http\Requests\BaseIndexFilterRequest as IndexRequest;
use Illuminate\Support\Facades\Gate;

class ClientPetIndexController
{
    public function clientPetIndex(
        Client $client,
        IndexRequest $request,
        ClientPetRepositoryInterface $getPetsByClient
    ): PetCollection
    {
        Gate::authorize('view', $client);
        $pets = $getPetsByClient($client->id, $request->validated())->getCollection();
        return new PetCollection($pets);
    }
}
