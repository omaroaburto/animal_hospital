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
        public SendVerificationEmailAction $sendEmail
    ){}
    public function __invoke(UpdateClientRequest $request, Client $clientTarget ) {
        $client = DB::transaction(function () use ($request, $clientTarget){
            $requestValidated = $request->validated();
            $validatedDataUser = UpdateUserDto::fromArray($requestValidated);
            $avatar = $requestValidated->file('avatar');
            $user= ($this->updateUser)($validatedDataUser, $avatar);
            $validatedDataClient = UpdateClientDto::fromRequest($request, $user->id);
            return ($this->updateClient)($validatedDataClient, $clientTarget);
        });
        ($this->sendEmail)($client->user);
        return $client->load(['commune.region', 'user']);
    }
}
