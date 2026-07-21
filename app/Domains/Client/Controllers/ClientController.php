<?php

namespace App\Domains\Client\Controllers;

use App\Domains\Client\Actions\IndexClientAction;
use App\Domains\Client\Actions\RegisterClientAction;
use App\Domains\Client\Actions\ShowClientAction;
use App\Domains\Client\Actions\DeactiveClientAction;
use App\Domains\Client\Actions\RestoreClientAction;
use App\Domains\Client\Actions\UpdateClientProfileAction;
use App\Domains\Client\Models\Client;
use App\Domains\Client\Requests\StoreClientRequest;
use App\Domains\Client\Requests\UpdateClientRequest;
use App\Domains\Client\Resources\ClientCollection;
use App\Domains\Client\Resources\ClientResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\BaseIndexFilterRequest as IndexRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class ClientController extends Controller
{

    //lista cliente
    public function index(
        IndexRequest $request,
        IndexClientAction $indexClient,
    ) {
        Gate::authorize('viewAny', Client::class);
        $result = $indexClient($request->validated());
        return new ClientCollection($result);
    }

    //crear cuenta de cliente
    public function store(
        StoreClientRequest $request,
        RegisterClientAction $registerClient,
    ): ClientResource {
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
    ): ClientResource {
        Gate::authorize('view', $client);
        $result = $showClient($client);
        return new ClientResource($result);
    }

    //Actualizar datos de cliente
    public function update(
        UpdateClientRequest $request,
        Client $client,
        UpdateClientProfileAction $updateClientProfile,
    ): ClientResource {
        Gate::authorize('update', $client);
        $result = $updateClientProfile($request, $client);
        return new ClientResource($result);
    }

    //Desactivar cuenta de usuario.is_active = false
    public function destroy(
        Client $client,
        DeactiveClientAction $deactiveClient,
    ): JsonResponse {
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
    ) {
        Gate::authorize('restore', $client);
        $restoreClient($client);
        return response()->json([
            'success' => true,
            'message' => "El usuario {$client->user->email} se ha restaurado."
        ], Response::HTTP_OK);
    }
}
