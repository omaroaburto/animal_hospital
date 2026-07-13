<?php

namespace App\Domains\Clients\Actions;

use App\Domains\Clients\Models\Client;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

class IndexClientAction
{
    public function __invoke(Request $request): Collection
    {
        $perPage = $request->query('per_page', 10);
        $page    = $request->query('page', 1);
        $clients = Client::with(['user', 'commune.region'])
            // El método 'when' solo ejecuta el código de adentro si 'has' es true
            ->when($request->has('is_active'), function ($query) use ($request) {
                $query->whereHas('user', function($subQuery) use ($request) {
                    $subQuery->where('is_active', $request->boolean('is_active'));
                });
            })
            ->paginate(perPage: $perPage, page: $page);

        return $clients->getCollection();
    }
}
