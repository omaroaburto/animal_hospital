<?php

namespace App\Domains\Pets\Controllers;

use App\Domains\Pets\Actions\DeleteBreedAction;
use App\Domains\Pets\Actions\GetPetsByBreedAction as GetPetsByBreed;
use App\Domains\Pets\Actions\IndexBreedAction;
use App\Domains\Pets\Actions\StoreBreedAction;
use App\Domains\Pets\Actions\UpdateBreedAction;
use App\Domains\Pets\Models\Breed;
use App\Domains\Pets\Requests\DeleteBreedRequest;
use App\Domains\Pets\Requests\StoreBreedRequest;
use App\Domains\Pets\Requests\UpdateBreedRequest;
use App\Domains\Pets\Resources\BreedCollection;
use App\Domains\Pets\Resources\BreedResource;
use App\Domains\Pets\Resources\PetCollection;
use App\Http\Controllers\Controller;
use App\Http\Requests\BaseIndexFilterRequest as IndexRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class BreedController extends Controller
{
    public function index(
        IndexRequest $request,
        IndexBreedAction $indexBreed,
    ): BreedCollection
    {
        $breeds = $indexBreed($request->validated());
        return new BreedCollection($breeds);
    }

    public function store(
        StoreBreedRequest $request,
        StoreBreedAction $storeBreed,
    )
    {
        Gate::authorize('create', Breed::class);
        $breed = $storeBreed($request->validated());
        return new BreedResource($breed);
    }

    public function show(
        Breed $breed,
    ): BreedResource
    {
        $breed->load(['species']);
        return new BreedResource($breed);
    }

    public function update(
        UpdateBreedRequest $request,
        Breed $breed,
        UpdateBreedAction $updateBreed,
    ): BreedResource
    {
        Gate::authorize('update', $breed);
        $result = $updateBreed($request->validated(), $breed);
        return new BreedResource($result);
    }

    public function destroy(
        Breed $breed,
        DeleteBreedRequest $request,
        DeleteBreedAction $deleteBreed,
    ): JsonResponse {
        $result = $deleteBreed($request->validated(), $breed);

        if (! $result['reassigned']) {
            return response()->json([
                'message' => "La raza {$result['old_breed']} se eliminó correctamente.",
            ], Response::HTTP_OK);
        }

        return response()->json([
            'total_pets_updated' => $result['pets_updated'],
            'message' => "Se reasignaron {$result['pets_updated']} mascotas de la raza {$result['old_breed']} a {$result['new_breed']}. La raza original fue eliminada correctamente.",
        ], Response::HTTP_OK);
    }

    public function indexBreedPet(
        IndexRequest $request,
        Breed $breed,
        GetPetsByBreed $getPetsByBreed,
    ): PetCollection
    {
        Gate::authorize('getPet', $breed);
        $pets = $getPetsByBreed($request->validated(), $breed->id);
        return new PetCollection($pets);
    }
}
