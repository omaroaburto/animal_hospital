<?php

namespace App\Domains\Clients\Actions;

use App\Domains\Auth\Actions\SendVerificationEmailAction;
use App\Domains\Auth\Contracts\StoreUserActionInterface;
use App\Domains\Auth\DTOs\CreateUserDto;
use App\Domains\Clients\DTOs\CreateClientDto;
use App\Domains\Clients\Requests\StoreClientRequest; 
use App\Domains\Clients\Models\Client;
use Illuminate\Support\Facades\DB;

class RegisterClientAction
{
    public function __construct(
        public StoreUserActionInterface $userAction,
        public StoreClientAction $clientAction,
        public SendVerificationEmailAction $sendEmail,
    ) {}

    public function __invoke(StoreClientRequest $request): Client
    {
        $client = DB::transaction(function () use ($request) {
            $validatedDataUser = CreateUserDto::fromRequest($request);
            $avatar = $request->file('avatar');
            $user = ($this->userAction)($validatedDataUser, 'client', $avatar);
            $validatedDataClient = CreateClientDto::fromRequest($request, $user->id);
            return ($this->clientAction)($validatedDataClient);
        });
        ($this->sendEmail)($client->user);
        return $client;
    }
}
