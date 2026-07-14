<?php

namespace App\Domains\Clients\Controllers;

use App\Domains\Clients\Actions\IndexClientAction;
use App\Domains\Clients\Actions\RegisterClientAction;
use App\Domains\Clients\Actions\ShowClientAction;
use App\Domains\Clients\Actions\DeactiveClientAction;
use App\Domains\Clients\Actions\RestoreClientAction;
use App\Domains\Clients\Actions\UpdateClientProfileAction;
use App\Domains\Clients\Models\Client;
use App\Domains\Clients\Requests\StoreClientRequest;
use App\Domains\Clients\Requests\UpdateClientRequest;
use App\Domains\Clients\Resources\ClientCollection;
use App\Domains\Clients\Resources\ClientResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class ClientController extends Controller
{

    //lista cliente
    public function index(
        Request $request,
        IndexClientAction $indexClient,
    )
    {
        Gate::authorize('anyView', Client::class);
        $result = $indexClient($request);
        return new ClientCollection($result);
    }

    //crear cuenta de cliente
    public function store(
        StoreClientRequest $request,
        RegisterClientAction $registerClient,
    ): ClientResource
    {
        $client = $registerClient($request);
        $client->load([
            'user',
            'commune.region',
        ]);
        return new ClientResource($client);
    }

    //Mostar datos de un cliente
    public function show(
        Client $client,
        ShowClientAction $showClient,
    ): ClientResource
    {
        Gate::authorize('view', $client);
        $result = $showClient($client);
        return new ClientResource($result);
    }

    //Actualizar datos de cliente
    public function update(
        UpdateClientRequest $request,
        Client $client,
        UpdateClientProfileAction $updateClientProfile,
    ): ClientResource
    {
        Gate::authorize('update', $client);
        $result = $updateClientProfile($request, $client);
        return new ClientResource($result);
    }

    //Desactivar cuenta de usuario.is_active = false
    public function destroy(
        Client $client,
        DeactiveClientAction $deactiveClient,
    ): JsonResponse
    {
        Gate::authorize('delete', $client);
        $deactiveClient($client);
        return response()->json([
            'success' => true,
            'message' => "El usuario {$client->user->email} se ha desactivado."
        ], Response::HTTP_OK);
    }

    //Restaurar cuenta de usuario.is_active = true
    public function restore(
        Client $client,
        RestoreClientAction $restoreClient,
    )
    {
        Gate::authorize('restore', $client);
        $restoreClient($client);
        return response()->json([
            'success' => true,
            'message' => "El usuario {$client->user->email} se ha restaurado."
        ], Response::HTTP_OK);
    }
}
