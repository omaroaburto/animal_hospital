<?php

namespace App\Domains\Pets\Controllers;

use App\Domains\Pets\Actions\DeactivatePetAction;
use App\Domains\Pets\Actions\IndexPetAction;
use App\Domains\Pets\Actions\RestorePetAction;
use App\Domains\Pets\Actions\ShowPetAction;
use App\Domains\Pets\Actions\StorePetAction;
use App\Domains\Pets\Actions\UpdatePetAction;
use App\Domains\Pets\Models\Pet;
use App\Domains\Pets\Requests\StorePetRequest;
use App\Domains\Pets\Requests\UpdatePetRequest;
use App\Domains\Pets\Resources\PetCollection;
use App\Domains\Pets\Resources\PetResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\BaseIndexFilterRequest as IndexRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class PetController extends Controller
{

    public function index(
        IndexRequest $request,
        IndexPetAction $indexPet,
    ): PetCollection
    {
        Gate::authorize('viewAny', Pet::class);
        $pets = $indexPet($request->validated());
        return new PetCollection($pets);
    }

    public function store(
        StorePetRequest $request,
        StorePetAction $storePet,
    ): PetResource
    {
        Gate::authorize('create', Pet::class);
        $pet = $storePet($request->validated(), $request->file('photo'));
        return new PetResource($pet);
    }

    public function show(
        Pet $pet,
        ShowPetAction $showPet,
    ): PetResource
    {
        Gate::authorize('view', $pet);
        $result = $showPet($pet);
        return new PetResource($result);
    }

    public function update(
        UpdatePetRequest $request,
        Pet $pet,
        UpdatePetAction $updatePet,
    ): PetResource
    {
        Gate::authorize('update', $pet);
        $result = $updatePet($request->validated(), $pet, $request->file('photo'));
        return new PetResource($result);
    }

    public function destroy(
        Pet $pet,
        DeactivatePetAction $deactivePet
    )
    {
        Gate::authorize('deactivate', $pet);
        $petName = $deactivePet($pet);
        return response()->json([
            'message' => "Se ha desactivo la mascota {$petName}.",
        ], Response::HTTP_OK);
    }

    public function restore(
        Pet $pet,
        RestorePetAction $restorePet,
    )
    {
        Gate::authorize('restore', $pet);
        $petName = $restorePet($pet);
        return response()->json([
            'message' => "Se ha activado la mascota {$petName}.",
        ], Response::HTTP_OK);
    }
}
