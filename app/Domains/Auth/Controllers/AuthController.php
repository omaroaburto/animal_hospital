<?php

namespace App\Domains\Auth\Controllers;

use App\Domains\Auth\Actions\LoginAction;
use App\Domains\Auth\Actions\LogoutAction;
use App\Domains\Auth\Actions\RefreshTokenAction;
use App\Domains\Auth\Actions\VerifyEmailAction;
use App\Domains\Auth\Actions\ForgotPasswordAction;
use App\Domains\Auth\Actions\ResetPasswordAction;
use App\Domains\Auth\Requests\ForgotPasswordRequest;
use App\Domains\Auth\Requests\LoginRequest;
use App\Domains\Auth\Requests\ResetPasswordRequest;
use App\Domains\Auth\Requests\VerifyEmailRequest;
use App\Domains\Auth\Resources\LoginResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpFoundation\Response;
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

    public function forgotPassword(
        ForgotPasswordRequest $request,
        ForgotPasswordAction $forgotPasswordAction,
    ): JsonResponse
    {
        $forgotPasswordAction($request->validated('email'));
        return response()->json([
            "message" => "Si el correo está registrado, recibirás un enlace para restablecer tu contraseña."
        ], Response::HTTP_OK);
    }

    public function resetPassword(
        ResetPasswordRequest $request,
        ResetPasswordAction $resetPasswordAction
    ): JsonResponse
    {
        $status = $resetPasswordAction($request->validated());
        if($status === Password::PASSWORD_RESET){
            return response()->json([
                'message' => 'La contraseña se ha restablecido correctamente.',
            ], Response::HTTP_OK);
        }

        return response()->json([
            'message' => 'El enlace de restablecimiento no es válido o ha expirado.',
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
