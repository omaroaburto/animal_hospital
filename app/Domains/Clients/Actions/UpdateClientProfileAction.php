<?php

namespace App\Domains\Clients\Actions;

use App\Domains\Auth\Actions\SendVerificationEmailAction;
use App\Domains\Auth\Contracts\UpdateUserActionInterface;
use App\Domains\Auth\DTOs\UpdateUserDto;
use App\Domains\Clients\DTOs\UpdateClientDto;
use App\Domains\Clients\Models\Client;
use App\Domains\Clients\Requests\UpdateClientRequest;
use Illuminate\Support\Facades\DB;

class UpdateClientProfileAction
{
    public function __construct(
        public UpdateUserActionInterface $updateUser,
        public UpdateClientAction $updateClient,
    ){}
    public function __invoke(UpdateClientRequest $request, Client $clientTarget ) {
        $client = DB::transaction(function () use ($request, $clientTarget){

            $requestValidated = $request->validated();
            $avatar = $requestValidated['avatar'] ?? null;
            $validatedDataUser = UpdateUserDto::fromArray($requestValidated);
            $user= ($this->updateUser)($validatedDataUser,$clientTarget->user, $avatar);
            $validatedDataClient = UpdateClientDto::fromRequest($request, $user->id);
            return ($this->updateClient)($validatedDataClient, $clientTarget);
        }); 
        return $client->load(['commune.region', 'user']);
    }
}
