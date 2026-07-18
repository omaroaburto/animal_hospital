<?php

namespace App\Domains\Clients\Controllers;

use App\Domains\Clients\Models\Client;
use App\Domains\Pets\Contracts\ClientPetRepositoryInterface;
use App\Domains\Pets\Resources\PetCollection;
use App\Http\Requests\BaseIndexFilterRequest as IndexRequest;

class ClientPetIndexController
{
    public function clientPetIndex(
        Client $client,  
        IndexRequest $request, 
        ClientPetRepositoryInterface $getPetsByClient
    ): PetCollection 
    {
        $pets = $getPetsByClient($client->id, $request->validated());
        return new PetCollection($pets);
    }
}
