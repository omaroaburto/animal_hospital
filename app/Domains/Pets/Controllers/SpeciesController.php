<?php

namespace App\Domains\Pets\Controllers;

use App\Domains\Pets\Actions\DestroySpeciesAction;
use App\Domains\Pets\Actions\GetBreedBySpeciesAction as GetBreedBySpecies;
use App\Domains\Pets\Actions\IndexSpeciesAction;
use App\Domains\Pets\Actions\ShowSpeciesAction;
use App\Domains\Pets\Actions\StoreSpeciesAction;
use App\Domains\Pets\Actions\UpdateSpeciesAction;
use App\Domains\Pets\Models\Species;
use App\Domains\Pets\Requests\StoreSpeciesRequest;
use App\Domains\Pets\Requests\UpdateSpeciesRequest;
use App\Domains\Pets\Resources\BreedCollection;
use App\Domains\Pets\Resources\SpeciesCollection;
use App\Domains\Pets\Resources\SpeciesResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\BaseIndexFilterRequest as IndexRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class SpeciesController extends Controller
{
    /**
     * método para listar las especies
     * @param $request, puede contener el 'per_page', el 'page' y 'all'
     * @param $indexSpecies, es un elemento de tipo IndexSpeciesAction
     * la clase tiene un método __invoke que acepta el request y que retorna
     * un collection con las especies registradas en el sistema
     */
    public function index(
        IndexRequest $request,
        IndexSpeciesAction $indexSpecies
    ): SpeciesCollection
    {
        $species = $indexSpecies($request->validated());
        return new SpeciesCollection($species);
    }

    /**
     * Es el método que se encarga de crear una especie
     * @param $request, contiene los elementos solicitados para crear una especie
     * @param $storeSpecies
     */
    public function store(
        StoreSpeciesRequest $request,
        StoreSpeciesAction $storeSpecies
    ): SpeciesResource
    {
        Gate::authorize('create', Species::class);
        $species = $storeSpecies($request->validated());
        return new SpeciesResource($species);
    }
    public function show(
        Species $species,
        ShowSpeciesAction $showSpecies,
    )
    {
        $result = $showSpecies($species);
        return new SpeciesResource($result);
    }

    public function update(
        UpdateSpeciesRequest $request,
        Species $species,
        UpdateSpeciesAction $updateSpecies,
    ): SpeciesResource
    {
        Gate::authorize('update',$species);
        $result = $updateSpecies($request->validated(), $species);
        return new SpeciesResource($result);
    }

    public function destroy(
        Species $species,
        DestroySpeciesAction $destroySpecies,
    ): JsonResponse
    {
        Gate::authorize('delete',$species);
        $destroySpecies($species);
        return response()->json([
            'message' => 'Se ha eliminado la especie.'
        ], Response::HTTP_OK);
    }

    
    public function indexSpeciesBreed(
        IndexRequest $request,
        Species $species,
        GetBreedBySpecies $getBreedBySpecies
    ): BreedCollection
    {
        Gate::authorize('getBreeds', $species);
        $breeds = $getBreedBySpecies($request->validated(), $species->id);
        return new BreedCollection($breeds);
    }
}
