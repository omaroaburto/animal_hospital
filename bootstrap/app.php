<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException; // Verificado
use Tymon\JWTAuth\Exceptions\JWTException; // Agregado para consistencia
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Configuraciones de middleware
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );

        // 1. Manejar errores 404 (Not Found y Model Not Found)
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                $previous = $e->getPrevious();
                if ($previous instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                    $model = class_basename($previous->getModel());
                    return response()->json([
                        'status'  => 'error',
                        'message' => "El registro en el módulo '{$model}' no existe."
                    ], Response::HTTP_NOT_FOUND);
                }
            }
        });

                // 2. Manejar excepciones directas o envueltas de JWT (Expirado, Inválido, Lista Negra, Ausente)
        // CAMBIO AQUÍ: Cambiamos JWTException por UnauthorizedHttpException
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException $e, Request $request) {
            if ($request->is('api/*')) {

                // Obtenemos la excepción interna real de Tymon (TokenExpiredException, TokenInvalidException, etc.)
                $actualException = $e->getPrevious();

                return match (true) {
                    $actualException instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException => response()->json([
                        'status' => 'error',
                        'error_code' => 'JWT_TOKEN_EXPIRED',
                        'message' => 'El token ha expirado. Por favor, solicita uno nuevo.'
                    ], Response::HTTP_UNAUTHORIZED),

                    $actualException instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException => response()->json([
                        'status' => 'error',
                        'error_code' => 'JWT_TOKEN_INVALID',
                        'message' => 'El token proporcionado no es válido o ha sido alterado.'
                    ], Response::HTTP_UNAUTHORIZED),

                    $actualException instanceof \Tymon\JWTAuth\Exceptions\TokenBlacklistedException => response()->json([
                        'status' => 'error',
                        'error_code' => 'JWT_TOKEN_BLACKLISTED',
                        'message' => 'El token ya no es válido porque se ha cerrado la sesión.'
                    ], Response::HTTP_UNAUTHORIZED),

                    // Caso por defecto: Si $actualException es null significa que "Token not provided" (No se envió token)
                    default => response()->json([
                        'status' => 'error',
                        'error_code' => 'JWT_TOKEN_MISSING',
                        'message' => 'Token de autenticación no proporcionado en la petición.'
                    ], Response::HTTP_UNAUTHORIZED),
                };
            }
        });


        // 3. Manejar excepciones genéricas de autenticación de Laravel
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => 'error',
                    'error_code' => 'UNAUTHENTICATED',
                    'message' => 'Usuario no autenticado en el sistema.'
                ], Response::HTTP_UNAUTHORIZED);
            }
        });

    // Manejo global para errores del SDK de Cloudinary
    $exceptions->render(function (\Cloudinary\Api\Exception\ApiError $e, Request $request) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Hubo un problema con el proveedor de almacenamiento de imágenes.',
            'details' => $e->getMessage()
        ], Response::HTTP_BAD_GATEWAY);
    });

})->create();

