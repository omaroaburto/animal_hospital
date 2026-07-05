<?php

namespace App\Domains\Auth\Actions;
use Illuminate\Http\Request;
use App\domains\Auth\Models\User;
use Illuminate\Support\Collection;

class IndexUserAction
{
    public function __invoke(Request $request): Collection 
    {
        
        $perPage = $request->query('per_page', 10);
        $page    = $request->query('page', 1);
        
        $adminUsers = User::whereHas('role', function($query){
            $query->where('name','admin');
        })
        ->with('role')
        ->when($request->has('is_active'), function($query) use ($request) { 
            $query->where('is_active', $request->boolean('is_active'));
        })
        ->paginate(
            perPage: $perPage,
            page: $page
        );

        return $adminUsers->getCollection();
    }
}
