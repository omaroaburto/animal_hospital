<?php

namespace App\Domains\Pet\Controllers;

use App\Domains\Pet\Actions\DestroySpeciesAction;
use App\Domains\Pet\Actions\GetBreedBySpeciesAction as GetBreedBySpecies;
use App\Domains\Pet\Actions\IndexSpeciesAction;
use App\Domains\Pet\Actions\ShowSpeciesAction;
use App\Domains\Pet\Actions\StoreSpeciesAction;
use App\Domains\Pet\Actions\UpdateSpeciesAction;
use App\Domains\Pet\Models\Species;
use App\Domains\Pet\Requests\StoreSpeciesRequest;
use App\Domains\Pet\Requests\UpdateSpeciesRequest;
use App\Domains\Pet\Resources\BreedCollection;
use App\Domains\Pet\Resources\SpeciesCollection;
use App\Domains\Pet\Resources\SpeciesResource;
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
    ): SpeciesCollection {
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
    ): SpeciesResource {
        Gate::authorize('create', Species::class);
        $species = $storeSpecies($request->validated());
        return new SpeciesResource($species);
    }
    public function show(
        Species $species,
        ShowSpeciesAction $showSpecies,
    ) {
        $result = $showSpecies($species);
        return new SpeciesResource($result);
    }

    public function update(
        UpdateSpeciesRequest $request,
        Species $species,
        UpdateSpeciesAction $updateSpecies,
    ): SpeciesResource {
        Gate::authorize('update', $species);
        $result = $updateSpecies($request->validated(), $species);
        return new SpeciesResource($result);
    }

    public function destroy(
        Species $species,
        DestroySpeciesAction $destroySpecies,
    ): JsonResponse {
        Gate::authorize('delete', $species);
        $destroySpecies($species);
        return response()->json([
            'message' => 'Se ha eliminado la especie.'
        ], Response::HTTP_OK);
    }


    public function indexSpeciesBreed(
        IndexRequest $request,
        Species $species,
        GetBreedBySpecies $getBreedBySpecies
    ): BreedCollection {
        Gate::authorize('getBreeds', $species);
        $breeds = $getBreedBySpecies($request->validated(), $species->id);
        return new BreedCollection($breeds);
    }
}
