<?php

namespace App\Domains\Auth\Controllers;

use App\Domains\Auth\Actions\LoginAction;
use App\Domains\Auth\Actions\LogoutAction;
use App\Domains\Auth\Actions\RefreshTokenAction;
use App\Domains\Auth\Actions\VerifyEmailAction;
use App\Domains\Auth\Requests\LoginRequest;
use App\Domains\Auth\Requests\VerifyEmailRequest;
use App\Domains\Auth\Resources\LoginResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
//use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
   //inicir sesión
   public function login(LoginRequest $request, LoginAction $loginAction): LoginResource
   {
        $result = $loginAction($request->validated());
        return new LoginResource($result);
   }

   //desconectarse de sesión
   public function logout(LogoutAction $logoutAction): JsonResponse
   {
        $logoutAction();
        return response()->json([
            'success' => true,
            'message' => 'Sesión cerrada correctamente.'
        ]);
   }

   //refrescar el token
   public function refresh(RefreshTokenAction $refresh): LoginResource
   {
        $result = $refresh();
        return new LoginResource($result);
   }


   public function verifyEmail(
        VerifyEmailRequest $request,
        VerifyEmailAction $verifyEmail
    )
    {
        try {
            $user = $verifyEmail($request->validated());
            return view('emails.verified', compact('user'));   
        } catch (\Exception $e) { 
            return view('emails.errors.invalid-token', [
                'message' => $e->getMessage()  
            ]);
        }
    }

    /* 
    
    public function verifyEmail(
            VerifyEmailRequest $request,
            VerifyEmailAction $verifyEmail
        ): RedirectResponse {
            
            $frontendUrl = config('app.frontend_url', 'http://localhost:4200'); // Tu url de Angular/React

            try {
                // Ejecutamos la lógica de negocio
                $user = $verifyEmail($request->validated());
                
                // Redirigimos al frontend con estado exitoso
                return redirect()->to("{$frontendUrl}/email-verification?status=success");

            } catch (Exception $e) {
                // Redirigimos al frontend con el mensaje de error de la excepción
                $message = urlencode($e->getMessage());
                return redirect()->to("{$frontendUrl}/email-verification?status=error&message={$message}");
            }
        }
    */
}
