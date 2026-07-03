<?php

namespace App\domains\Auth\Controllers;

use App\domains\Auth\Actions\LoginAction;
use App\domains\Auth\Actions\LogoutAction;
use App\domains\Auth\Actions\RefreshTokenAction;
use App\domains\Auth\Requests\LoginRequest;
use App\domains\Auth\Resources\LoginResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse; 

class AuthController extends Controller
{
   public function login(LoginRequest $request, LoginAction $loginAction): LoginResource
   {
        $result = $loginAction($request->validated());
        return new LoginResource($result);
   }
   public function logout(LogoutAction $logoutAction): JsonResponse
   {
        $logoutAction();
        return response()->json([
            'success' => true,
            'message' => 'Sesión cerrada correctamente.'
        ]);
   }
   public function refresh(RefreshTokenAction $refresh): LoginResource
   {
        $result = $refresh();
        return new LoginResource($result);
   }
}
